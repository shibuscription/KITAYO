<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;

/**
 * ScanLogs Controller
 *
 * @property \App\Model\Table\ScanLogsTable $ScanLogs
 * @method \App\Model\Entity\ScanLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ScanLogsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('ScanLogs');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Devices'],
        ];
        $scanLogs = $this->paginate($this->ScanLogs);

        $this->set(compact('scanLogs'));
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['next', 'devCreate', 'devPanel']);
    }


    /**
     * View method
     *
     * @param string|null $id Scan Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scanLog = $this->ScanLogs->get($id, [
            'contain' => ['Devices'],
        ]);

        $this->set(compact('scanLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $scanLog = $this->ScanLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $scanLog = $this->ScanLogs->patchEntity($scanLog, $this->request->getData());
            if ($this->ScanLogs->save($scanLog)) {
                $this->Flash->success(__('The scan log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The scan log could not be saved. Please, try again.'));
        }
        $devices = $this->ScanLogs->Devices->find('list', ['limit' => 200])->all();
        $this->set(compact('scanLog', 'devices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Scan Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $scanLog = $this->ScanLogs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scanLog = $this->ScanLogs->patchEntity($scanLog, $this->request->getData());
            if ($this->ScanLogs->save($scanLog)) {
                $this->Flash->success(__('The scan log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The scan log could not be saved. Please, try again.'));
        }
        $devices = $this->ScanLogs->Devices->find('list', ['limit' => 200])->all();
        $this->set(compact('scanLog', 'devices'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Scan Log id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scanLog = $this->ScanLogs->get($id);
        if ($this->ScanLogs->delete($scanLog)) {
            $this->Flash->success(__('The scan log has been deleted.'));
        } else {
            $this->Flash->error(__('The scan log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function next()
    {
        $this->request->allowMethod(['get']);

        // まずクエリ
        $deviceId = (string)$this->request->getQuery('device_id', '');

        $sessionDeviceId = (string)$this->request->getSession()->read('Kiosk.device_id');
        if ($sessionDeviceId !== '') {
            if ($deviceId !== '' && $deviceId !== $sessionDeviceId) {
                $this->viewBuilder()->setClassName('Json');
                $this->set(['found' => false, 'error' => 'device_id mismatch']);
                $this->set('_serialize', ['found', 'error']);
                return;
            }
            $deviceId = $sessionDeviceId;
        }

        // クエリが無ければセッション（Kiosk）から補う
        if ($deviceId === '') {
            $deviceId = (string)$this->request->getSession()->read('Kiosk.device_id');
        }

        $this->viewBuilder()->setClassName('Json');

        if ($deviceId === '') {
            $this->set(['found' => false, 'error' => 'device_id is required']);
            $this->set('_serialize', ['found', 'error']);
            return;
        }

        // 直近10秒以内だけ有効
        $windowSec = (int)$this->request->getQuery('window_sec', 10);
        if ($windowSec <= 0 || $windowSec > 120) {
            $windowSec = 10;
        }

        $conn = $this->ScanLogs->getConnection();

        $result = $conn->transactional(function () use ($deviceId, $windowSec) {
            $now = FrozenTime::now();                 // AppのTZ設定に従う
            $threshold = $now->subSeconds($windowSec);

            // ★掃除：古い未処理を期限切れ(9)へ
            $this->ScanLogs->updateAll(
                ['processed' => 9],
                [
                    'processed' => 0,
                    'device_id' => $deviceId,
                    'scanned_at <' => $threshold,
                ]
            );

            // ★直近の未処理を1件拾う（10秒以内）
            $scanLog = $this->ScanLogs->find()
                ->where([
                    'processed' => 0,
                    'device_id' => $deviceId,
                    'scanned_at >=' => $threshold,
                ])
                ->orderAsc('id')
                ->first();

            if (!$scanLog) {
                return ['found' => false];
            }

            // ★取得済みにする（0 → 1）
            $affected = $this->ScanLogs->updateAll(
                ['processed' => 1],
                ['id' => $scanLog->id, 'processed' => 0]
            );

            if ($affected !== 1) {
                return ['found' => false];
            }

            return [
                'found' => true,
                'scan_log_id' => (int)$scanLog->id,
            ];
        });

        $this->set($result + ['error' => null]);
        $this->set('_serialize', ['found', 'scan_log_id', 'error']);
    }


    public function devCreate()
    {
        if (!\Cake\Core\Configure::read('debug')) {
            throw new \Cake\Http\Exception\NotFoundException();
        }

        $idm = (string)$this->request->getQuery('idm', 'TEST_IDM_001');
        $deviceId = (string)$this->request->getQuery('device_id', 'DEV_LOCAL');
        $at = (string)$this->request->getQuery('at', '');

        $e = $this->ScanLogs->newEmptyEntity();
        $e->idm = $idm;
        $e->device_id = $deviceId;
        $e->scanned_at = $at !== '' ? $at : date('Y-m-d H:i:s');
        $e->processed = 0;

        $this->ScanLogs->saveOrFail($e);

        return $this->redirect(['action' => 'devPanel']);
    }

    public function devPanel()
    {
        if (!\Cake\Core\Configure::read('debug')) {
            throw new \Cake\Http\Exception\NotFoundException();
        }

        // デフォルト値（画面に表示用）
        $this->set([
            'defaultIdm' => 'TEST_IDM_001',
            'defaultDeviceId' => 'DEV_LOCAL',
        ]);
    }
}
