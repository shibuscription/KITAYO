# 勤怠管理システム（IDM打刻・タブレット端末向け）

ICカード（IDM）を使った **タブレット常設型の勤怠打刻システム**です。  
出勤・退勤操作は「カードをかざす → 大きなボタンを押す」だけのシンプルなUIを重視しています。

---

## 🧭 コンセプト・方針

- **打刻端末はタブレット専用**
  - スマホ対応はしない（UIを極力シンプルに）
- **誰でも迷わず操作できる**
  - 大きなボタン
  - リアルタイム時計表示（秒単位）
- **カード再スキャン前提の運用**
  - 画面遷移後にキャンセルしても問題なし
  - 必要ならもう一度カードをかざせばよい
- **複数会社・複数端末対応を前提**
  - device_id ごとに打刻を分離
- **打刻端末は未ログイン運用**
  - 管理者が事前に端末をセットアップし、端末側はURLを開くだけ

---

## 🗂️ テーブル構成（主要）

### companies
会社マスタ

### employees
社員マスタ（会社に所属）

### employee_idm
社員と IDM（ICカードID）の紐づけ  
※ **EmployeeIdm（単数）** を使用

| column | note |
|------|------|
| employee_id | employees.id |
| idm | ICカードID（ユニーク） |

---

### scan_logs
カード読み取りログ（打刻のトリガ）

| column | note |
|------|------|
| idm | 読み取ったカードID |
| device_id | 端末ID |
| scanned_at | 読み取り時刻 |
| processed | 状態フラグ |

#### processed の運用
- `0` : 未処理（待ち）
- `1` : 取得済み（画面遷移済み）
- `9` : 期限切れ・未使用

---

### attendance_records
勤怠実績（1日1レコード）

- employee_id + work_date でユニーク
- check_in / check_out を保持

---

## 🔁 打刻フロー

```
[待ち画面]
  ↓（カード読み取り）
scan_logs に INSERT（processed=0）
  ↓（ポーリング）
/scan-logs/next
  - 10秒以内
  - device_id一致
  - processed=0
  ↓
processed=1 に更新
  ↓
/attendance/decide
  ↓
[出勤 / 退勤 ボタン]
  ↓
attendance_records 更新
```

---

## 🖥️ 画面一覧

### ① 打刻待ち画面（Kiosk / Dashboard）

- 画面いっぱいに表示
- 秒単位で更新されるリアルタイム時計
- `/scan-logs/next` を 1秒ごとにポーリング
- 該当ログがあれば自動遷移
- 通信エラー時は「接続中…（再試行）」を表示

---

### ② 打刻確認画面（Attendance/decide）

- 表示内容
  - 社員名
  - 現在時刻（リアルタイム）
  - 出勤 / 退勤 大型ボタン
- 出勤・退勤は左右に大きく配置
- 押せない方は disabled 表示
- **キャンセル（戻る）ボタンあり**
  - 押すと打刻待ち画面へ戻る
  - scan_log はそのまま（再スキャン前提）

---

### ③ IDM未登録時（予定）

- IDM に対応する社員がいない場合
- 社員一覧から選択してその場で紐づけ
- 現状は全社員表示（将来は会社絞り込み予定）

---

## 🧪 開発用機能

### devCreate（ScanLogs）

開発時にカード読み取りを擬似再現するための機能。

```
GET /scan-logs/dev-create
```

#### パラメータ（省略可）
- `idm`（デフォルト: TEST_IDM_001）
- `device_id`（デフォルト: DEV_LOCAL）
- `at`（日時、省略時は now）

---

## ⚙️ ルーティング（抜粋）

```php
$routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
$routes->connect('/dashboard', ['controller' => 'Dashboard', 'action' => 'index']);

$routes->connect('/scan-logs/next', ['controller' => 'ScanLogs', 'action' => 'next']);
$routes->connect('/scan-logs/dev-create', ['controller' => 'ScanLogs', 'action' => 'devCreate']);
```

---

## 🧩 AttendanceController の設計方針

- IDM → employee_id の解決は `EmployeeIdm` で行う
- ScanLog は **next 時点で processed=1**
- commit では ScanLog を触らない（シンプル運用）
- 古い ScanLog は next 内で `processed=9` に更新

---

## 🕰️ 時刻・ロケール設定

- defaultTimezone: `Asia/Tokyo`
- defaultLocale: `ja_JP`

---

## 🚀 VPS・本番運用メモ（追記）

### 実行環境
- OS: Rocky Linux
- Web: Apache (httpd)
- PHP: 8.2
- FW: CakePHP 4.6
- 公開ポート: **8080**
  - 80番は別サイト運用のため分離

### DocumentRoot
```
/var/www/html/kintai-cakephp/webroot
```

### 端末アクセス例
```
http://<host>:8080/kiosk/wait?device_id=XXX
```

### 権限
- Web / PHP 実行ユーザー: `apache`
- 書き込みディレクトリ:
  - `logs/`
  - `tmp/`
```
chown -R apache:apache logs tmp
chmod -R 775 logs tmp
```

### 未ログイン端末対応
- `/scan-logs/next` は **認証不要**
- AuthenticationMiddleware で unauthenticated action に指定

### JSONレスポンスの注意
- PHP 8.2 + debug 環境では **Deprecated 警告がJSONに混入**しやすい
- 本番では以下を設定して抑制する

```php
'Error' => [
    'errorLevel' => E_ALL & ~E_USER_DEPRECATED,
    'trace' => false,
],
```

### ScanLogsController の注意点
- PHP8.2 対応のため以下を明示
```php
public $ScanLogs = null;
```

- JSON返却は新方式を使用
```php
$this->viewBuilder()->setOption('serialize', [...]);
```

---

## 📌 今後の検討事項

- IDM未登録時の社員検索UI改善
- 会社単位での社員絞り込み
- 管理画面（ユーザー・社員・デバイス管理）
- 打刻履歴・修正機能
- CSV出力（月次）
- 本番運用時の ScanLog クリーンアップ方針

---

※ 本 README は開発途中の仕様を含みます。
