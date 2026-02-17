<?php
declare(strict_types=1);

namespace App\Controller;

class KioskController extends AppController
{
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

        // 端末解除は未認証でも実行可能
        $this->Authentication->allowUnauthenticated(['clear']);
    }

    public function setup()
    {
        // company_admin 以外は弾く（最低限）
        $identity = $this->request->getAttribute('identity');
        if (!$identity || $identity->get('role') !== 'company_admin') {
            $this->Flash->error('端末セットアップ権限がありません。');
            return $this->redirect('/login');
        }

        $companyId = (int)$identity->get('company_id');

        $devicesTable = $this->fetchTable('Devices');

        if ($this->request->is('post')) {
            $deviceId = (string)$this->request->getData('device_id'); // devices.device_id（文字列）

            // companyのactive端末か確認（重要）
            $device = $devicesTable->find()
                ->select(['id', 'company_id', 'device_id', 'active_flag'])
                ->where([
                    'company_id' => $companyId,
                    'device_id' => $deviceId,
                    'active_flag' => 1,
                ])
                ->first();

            if (!$device) {
                $this->Flash->error('端末が無効か、選択が不正です。');
                return $this->redirect(['action' => 'setup']);
            }

            // 1) 端末モード用にセッションへ保存
            $this->request->getSession()->write('Kiosk.device_id', $deviceId);

            // 2) 管理者ログイン状態は消す
            $this->Authentication->logout();

            // 3) 打刻待ち画面へ
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        // GET：端末一覧を表示
        $devices = $devicesTable->find()
            ->select(['device_id', 'device_name', 'location'])
            ->where(['company_id' => $companyId, 'active_flag' => 1])
            ->orderAsc('device_id')
            ->all();

        $this->set(compact('devices'));
    }

    public function clear()
    {
        // 端末解除（ログイン不要でもOKにするなら allowUnauthenticated 対象）
        $this->request->allowMethod(['post']);

        $this->request->getSession()->delete('Kiosk.device_id');
        $this->Flash->success('端末設定を解除しました。');

        return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
    }
}
