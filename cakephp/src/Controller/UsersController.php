<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Companies', 'Employees'],
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Companies', 'Employees'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $companies = $this->Users->Companies->find('list', ['limit' => 200])->all();
        $employees = $this->Users->Employees->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'companies', 'employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $companies = $this->Users->Companies->find('list', ['limit' => 200])->all();
        $employees = $this->Users->Employees->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'companies', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

        // ログイン画面は未認証でOK
        $this->Authentication->allowUnauthenticated(['login']);
    }
    public function login()
    {
        // すでにログイン済みで /login に来た場合も role に飛ばす
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            return $this->redirect($this->redirectByRole());
        }

        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();

            \Cake\Log\Log::debug('auth valid? ' . ($result && $result->isValid() ? 'yes' : 'no'));
            if ($result) {
                $errors = $result->getErrors();
                if (!empty($errors)) {
                    \Cake\Log\Log::debug('auth errors: ' . json_encode($errors, JSON_UNESCAPED_UNICODE));
                }
            } else {
                \Cake\Log\Log::debug('auth result is null (authenticator may not run)');
            }

            if ($result && $result->isValid()) {
                return $this->redirect($this->redirectByRole());
            }

            $this->Flash->error('ログインに失敗しました。');
        }
    }



    public function logout()
    {
        $this->request->allowMethod(['get', 'post']);

        $this->Authentication->logout();
        $this->Flash->success('ログアウトしました。');

        return $this->redirect(['action' => 'login']);
    }

    private function redirectByRole()
    {
        $identity = $this->request->getAttribute('identity');
        $role = $identity ? $identity->get('role') : null;

        return match ($role) {
            'super_admin'   => ['controller' => 'Companies', 'action' => 'index'], // 例：会社一覧
            'company_admin' => ['controller' => 'Kiosk', 'action' => 'setup'],  // 例：端末選択
            'employee'      => ['controller' => 'Timecards', 'action' => 'index'], // 例：タイムカード
            default         => '/',
        };
    }
}
