<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AttendanceRecords Controller
 *
 * @property \App\Model\Table\AttendanceRecordsTable $AttendanceRecords
 * @method \App\Model\Entity\AttendanceRecord[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttendanceRecordsController extends AppController
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
        $attendanceRecords = $this->paginate($this->AttendanceRecords);

        $this->set(compact('attendanceRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Attendance Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attendanceRecord = $this->AttendanceRecords->get($id, [
            'contain' => ['Employees'],
        ]);

        $this->set(compact('attendanceRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attendanceRecord = $this->AttendanceRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $attendanceRecord = $this->AttendanceRecords->patchEntity($attendanceRecord, $this->request->getData());
            if ($this->AttendanceRecords->save($attendanceRecord)) {
                $this->Flash->success(__('The attendance record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attendance record could not be saved. Please, try again.'));
        }
        $employees = $this->AttendanceRecords->Employees->find('list', ['limit' => 200])->all();
        $this->set(compact('attendanceRecord', 'employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Attendance Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attendanceRecord = $this->AttendanceRecords->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attendanceRecord = $this->AttendanceRecords->patchEntity($attendanceRecord, $this->request->getData());
            if ($this->AttendanceRecords->save($attendanceRecord)) {
                $this->Flash->success(__('The attendance record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attendance record could not be saved. Please, try again.'));
        }
        $employees = $this->AttendanceRecords->Employees->find('list', ['limit' => 200])->all();
        $this->set(compact('attendanceRecord', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Attendance Record id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attendanceRecord = $this->AttendanceRecords->get($id);
        if ($this->AttendanceRecords->delete($attendanceRecord)) {
            $this->Flash->success(__('The attendance record has been deleted.'));
        } else {
            $this->Flash->error(__('The attendance record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
