<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 * @property PaginatorComponent $Paginator
 */
class RolesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Role->recursive = 1;
        $result = $this->Paginator->paginate();
        $roles = array();

        foreach($result as $item){
            $role = $item['Role'];
            $user = $item['User'];
            $name = $role['name'];
            $id = bin2hex($role['id']);
            $count = count($user);
            array_push($roles, array("name" => $name, "count" => $count, "id" => $id));
            unset($role);
            unset($user);
        }

		$this->set('roles', $roles );
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
		$this->set('role', $this->Role->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash(__('The role has been saved.'), "default", array(
                    "class" => "alert alert-success"
                ));

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.'), "default", array(
                    "class" => "alert alert-danger"
                ));
			}
		}
		$users = $this->Role->User->find('list');
		$this->set(compact('users'));
        $this->render("admin_add");
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
        $id = pack("H*", $id);
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is(array('post', 'put'))) {
            $options = array(
                'conditions' => array('Role.' . $this->Role->primaryKey => $id),
                'recursive' => 0);
            $foundRole = $this->Role->find('first', $options);

            $this->Role->id = $foundRole[$this->Role->alias]['id'];

			if ($this->Role->save($this->request->data['Role'])) {
				$this->Session->setFlash(__('The role has been saved.'), "default", array(
                    "class" => "alert alert-success"
                ));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.'), "default", array(
                    "class" => "alert alert-danger"
                ));
			}
		} else {
			$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
			$this->request->data = $this->Role->find('first', $options);
            $this->request->data['Role']['id'] = bin2hex($id) ;
		}
		$users = $this->Role->User->find('list');
		$this->set(compact('users'));

        $this->render("admin_edit");
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
        $id = pack("H*", $id);
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		//$this->request->allowMethod('post', 'delete');
		if ($this->Role->delete()) {
			$this->Session->setFlash(__('The role has been deleted.'), "default", array(
                "class" => "alert alert-success"
            ));
		} else {
			$this->Session->setFlash(__('The role could not be deleted. Please, try again.'), "default", array(
                "class" => "alert alert-danger"
            ));
		}
		return $this->redirect(array('action' => 'index'));
	}


    public  function beforeFilter(){
        parent::beforeFilter();

        $this->WrsftAuth = $this->Components->load('WrsftAuth');
        $this->WrsftAuth->initialize($this);
        $this->WrsftAuth->ConstraintRolesAction(
            array(
                'admin' => array('admin_index', 'admin_add', 'admin_view', 'admin_edit', 'admin_delete'),
                'manager' => array('admin_index', 'admin_view', 'admin_edit'),
                'support' => array('admin_index', 'admin_view' )
            )
        );
    }

}
