<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Devices Controller
 *
 * @property \App\Model\Table\DevicesTable $Devices
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevicesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Companies'],
        ];
        $devices = $this->paginate($this->Devices);

        $this->set(compact('devices'));
    }

    /**
     * View method
     *
     * @param string|null $id Device id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $device = $this->Devices->get($id, [
            'contain' => ['Companies', 'Devices', 'ScanLogs'],
        ]);

        $this->set(compact('device'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $device = $this->Devices->newEmptyEntity();
        if ($this->request->is('post')) {
            $device = $this->Devices->patchEntity($device, $this->request->getData());
            if ($this->Devices->save($device)) {
                $this->Flash->success(__('The device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The device could not be saved. Please, try again.'));
        }
        $companies = $this->Devices->Companies->find('list', ['limit' => 200])->all();
        $this->set(compact('device', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Device id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $device = $this->Devices->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $device = $this->Devices->patchEntity($device, $this->request->getData());
            if ($this->Devices->save($device)) {
                $this->Flash->success(__('The device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The device could not be saved. Please, try again.'));
        }
        $companies = $this->Devices->Companies->find('list', ['limit' => 200])->all();
        $this->set(compact('device', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Device id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $device = $this->Devices->get($id);
        if ($this->Devices->delete($device)) {
            $this->Flash->success(__('The device has been deleted.'));
        } else {
            $this->Flash->error(__('The device could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
