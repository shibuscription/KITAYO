<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

/**
 * EmployeeIdm Controller
 *
 * @property \App\Model\Table\EmployeeIdmTable $EmployeeIdm
 * @method \App\Model\Entity\EmployeeIdm[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeIdmController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees'],
        ];
        $employeeIdm = $this->paginate($this->EmployeeIdm);

        $this->set(compact('employeeIdm'));
    }

    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

        // Kiosk からの未認証導線を許可（仕様に合わせて公開）
        $this->Authentication->allowUnauthenticated(['register']);
    }

    /**
     * View method
     *
     * @param string|null $id Employee Idm id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeIdm = $this->EmployeeIdm->get($id, [
            'contain' => ['Employees'],
        ]);

        $this->set(compact('employeeIdm'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeIdm = $this->EmployeeIdm->newEmptyEntity();
        if ($this->request->is('post')) {
            $employeeIdm = $this->EmployeeIdm->patchEntity($employeeIdm, $this->request->getData());
            if ($this->EmployeeIdm->save($employeeIdm)) {
                $this->Flash->success(__('The employee idm has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee idm could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeIdm->Employees->find('list', ['limit' => 200])->all();
        $this->set(compact('employeeIdm', 'employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Idm id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeIdm = $this->EmployeeIdm->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeIdm = $this->EmployeeIdm->patchEntity($employeeIdm, $this->request->getData());
            if ($this->EmployeeIdm->save($employeeIdm)) {
                $this->Flash->success(__('The employee idm has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee idm could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeIdm->Employees->find('list', ['limit' => 200])->all();
        $this->set(compact('employeeIdm', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Idm id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeIdm = $this->EmployeeIdm->get($id);
        if ($this->EmployeeIdm->delete($employeeIdm)) {
            $this->Flash->success(__('The employee idm has been deleted.'));
        } else {
            $this->Flash->error(__('The employee idm could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



    public function register()
    {
        $this->viewBuilder()->setLayout('kiosk');

        if (!Configure::read('debug')) {
            // allow in production
        }

        $scanLogId = (int)$this->request->getQuery('scan_log_id');

        $scanLogs = $this->fetchTable('ScanLogs');
        $devices = $this->fetchTable('Devices');
        $employees = $this->fetchTable('Employees');
        $employeeIdm = $this->fetchTable('EmployeeIdm');

        $deviceId = (string)$this->request->getSession()->read('Kiosk.device_id');
        if ($deviceId === '') {
            $this->Flash->error('Device is not set. Please setup kiosk device.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $device = $devices->find()
            ->select(['company_id', 'device_id', 'active_flag'])
            ->where(['device_id' => $deviceId, 'active_flag' => 1])
            ->first();

        if (!$device) {
            $this->Flash->error('Invalid device. Please setup kiosk device.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $companyId = (int)$device->company_id;

        $scanLog = $scanLogs->get($scanLogId);
        if ((string)$scanLog->device_id !== $deviceId) {
            $this->Flash->error('Device mismatch for scan log.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }
        $idm = (string)$scanLog->idm;

        // もし既に登録済みなら戻す（多重登録回避）
        $exists = $employeeIdm->find()
            ->where(['idm' => $idm])
            ->first();

        if ($exists) {
            $employee = $employees->find()
                ->select(['id', 'company_id'])
                ->where(['id' => $exists->employee_id])
                ->first();

            if ($employee && (int)$employee->company_id === $companyId) {
                return $this->redirect(['controller' => 'Attendance', 'action' => 'decide', '?' => ['scan_log_id' => $scanLogId]]);
            }

            $this->Flash->error('IDM is already assigned to a different company.');
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $employeeList = $employees->find()
            ->select(['id', 'employee_name'])
            ->where(['active_flag' => 1, 'company_id' => $companyId])
            ->orderAsc('employee_name')
            ->all()
            ->combine('id', 'employee_name')
            ->toArray();

        if ($this->request->is('post')) {
            $employeeId = (int)$this->request->getData('employee_id');

            $employee = $employees->find()
                ->select(['id'])
                ->where([
                    'id' => $employeeId,
                    'company_id' => $companyId,
                    'active_flag' => 1,
                ])
                ->first();

            if (!$employee) {
                $this->Flash->error('Invalid employee selection.');
                return;
            }

            if (!isset($employeeList[$employeeId])) {
                $this->Flash->error('社員を選択してください。');
            } else {
                $e = $employeeIdm->newEmptyEntity();
                $e->employee_id = $employeeId;
                $e->idm = $idm;
                $e->active_flag = 1;

                $employeeIdm->saveOrFail($e);

                // 登録後、出退勤ボタンへ戻す
                return $this->redirect([
                    'controller' => 'Attendance',
                    'action' => 'decide',
                    '?' => ['scan_log_id' => $scanLogId],
                ]);
            }
        }

        $this->set(compact('scanLogId', 'scanLog', 'idm', 'employeeList'));
    }
}
