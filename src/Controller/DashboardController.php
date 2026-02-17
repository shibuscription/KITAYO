<?php

declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('kiosk');
    }

    public function index()
    {
        $deviceId = $this->request->getSession()->read('Kiosk.device_id');

        // 端末がまだセットアップされてない場合
        // → 画面上に案内を出す（JS pollingは止める）
        $this->set(compact('deviceId'));
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index']);
    }
}
