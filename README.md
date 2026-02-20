# KITAYO

## 概要
KITAYO は、ICカード（IDm）打刻を中心とした勤怠管理システムです。  
カード読取イベントを起点に、Web 側で打刻判定と勤怠確定を行う構成を採用しています。  
本リポジトリはモノレポとして、Web アプリケーションと Raspberry Pi クライアントを一元管理しています。

## ディレクトリ構成
- `cakephp/`: Web アプリケーション本体（API、打刻画面、管理機能）
- `raspberrypi/`: ICカード読取クライアント（カード読取・API送信）

## 設計思想
- 打刻端末は未ログイン運用を前提とし、事前セットアップ済み端末として扱う
- `scan_logs` は打刻フローのトリガ専用ログとして扱う
- `attendance_records` を勤怠の確定データとして扱う
- 現場運用は再スキャン前提とし、単純で迷いにくい導線を優先する

## 技術スタック
### Web
- CakePHP 4.x
- PHP 8.x
- Apache

### 端末
- Raspberry Pi
- Python
- nfcpy
- requests

## 開発環境

### 開発サーバ起動方法

初回セットアップ：

cd cakephp
composer install

開発サーバ起動：

composer serve

アクセス：

http://localhost:8080

注意：
- ポートは 8080 を使用する
- ポートを変更すると CSRF Cookie の問題が発生する可能性がある
- localhost で統一してアクセスすること

## 開発ステータス
- 現在は機能追加よりも仕様の精緻化フェーズ
- `devPanel` / `devCreate` は `debug` 前提の制限運用
- CSV出力機能の整理を継続中
- 休憩ロジック（開始/終了・集計ルール）の設計を継続中

## 移行情報
- 旧 `kintai-cakephp` リポジトリの内容は本リポジトリへ移行済み
- 現在の正式リポジトリは `KITAYO`
