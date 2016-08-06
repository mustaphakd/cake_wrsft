<?php
App::uses('AppController', 'Controller');
/**
 * Forums Controller
 *
 * @property Forum $Forum
 * @property PaginatorComponent $Paginator
 */
class ForumsController extends AppController {

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
	public function index() {
		$this->Forum->recursive = 0;
		$this->set('forums', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Forum->exists($id)) {
			throw new NotFoundException(__('Invalid forum'));
		}
		$options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
		$this->set('forum', $this->Forum->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Forum->create();
			if ($this->Forum->save($this->request->data)) {
				$this->Session->setFlash(__('The forum has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The forum could not be saved. Please, try again.'));
			}
		}
		$versions = $this->Forum->Version->find('list');
		$this->set(compact('versions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Forum->exists($id)) {
			throw new NotFoundException(__('Invalid forum'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Forum->save($this->request->data)) {
				$this->Session->setFlash(__('The forum has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The forum could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
			$this->request->data = $this->Forum->find('first', $options);
		}
		$versions = $this->Forum->Version->find('list');
		$this->set(compact('versions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Forum->id = $id;
		if (!$this->Forum->exists()) {
			throw new NotFoundException(__('Invalid forum'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Forum->delete()) {
			$this->Session->setFlash(__('The forum has been deleted.'));
		} else {
			$this->Session->setFlash(__('The forum could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Forum->recursive = 0;
		$this->set('forums', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Forum->exists($id)) {
			throw new NotFoundException(__('Invalid forum'));
		}
		$options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
		$this->set('forum', $this->Forum->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Forum->create();
			if ($this->Forum->save($this->request->data)) {
				$this->Session->setFlash(__('The forum has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The forum could not be saved. Please, try again.'));
			}
		}
		$versions = $this->Forum->Version->find('list');
		$this->set(compact('versions'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Forum->exists($id)) {
			throw new NotFoundException(__('Invalid forum'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Forum->save($this->request->data)) {
				$this->Session->setFlash(__('The forum has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The forum could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
			$this->request->data = $this->Forum->find('first', $options);
		}
		$versions = $this->Forum->Version->find('list');
		$this->set(compact('versions'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Forum->id = $id;
		if (!$this->Forum->exists()) {
			throw new NotFoundException(__('Invalid forum'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Forum->delete()) {
			$this->Session->setFlash(__('The forum has been deleted.'));
		} else {
			$this->Session->setFlash(__('The forum could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
