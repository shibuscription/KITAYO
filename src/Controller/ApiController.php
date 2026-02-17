<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\InternalErrorException;

/**
 * フラット構成での IDm API 受信
 */
class ApiController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('ScanLogs');
        $this->RequestHandler->renderAs($this, 'json');
    }

    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

        // 端末/外部送信用の API は未認証で許可
        $this->Authentication->allowUnauthenticated(['idm']);
    }

    public function idm()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        if (empty($data['idm']) || empty($data['device_id'])) {
            throw new BadRequestException('Missing parameters: idm and device_id are required.');
        }

        $scanLog = $this->ScanLogs->newEntity([
            'idm' => $data['idm'],
            'device_id' => $data['device_id'],
            'scanned_at' => date('Y-m-d H:i:s'),
            'processed' => 0,
        ]);

        if (!$this->ScanLogs->save($scanLog)) {
            throw new InternalErrorException('Failed to save scan log.');
        }

        $this->set([
            'status' => 'success',
            'id' => $scanLog->id,
            '_serialize' => ['status', 'id']
        ]);
    }
}
