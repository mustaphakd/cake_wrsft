<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 *
 * @property Message $Message
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MessagesController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Text', 'Time', 'Session');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void

	public function index() {
		$this->Message->recursive = 0;
		$this->set('messages', $this->Paginator->paginate());
	}
*/
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
		$this->set('message', $this->Message->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			//$this->Message->create();

            $this->Message->create($this->request->data);

            $dateTIme = new DateTime('now', new DateTimeZone('UTC'));
            $this->Message->set("date_sent", $dateTIme->format("Y-m-d H:i:s"));
            $this->Message->set("viewed", 0);
            $confirmationHash = $this->_generateHash();
            $this->Message->set("confirmation", $confirmationHash);

            if(!($this->Auth->user() === null))
                $this->Message->set("user_id", $this->Auth->user("id"));

			if ($this->Message->validates()) {

                if ( $this->Message->save(null, true, array("title", "viewed", "body", "date_sent", "email","confirmation", "user_id")))
                {
                    unset($this->request->data);
                    unset($this->Message);
                    $this->Session->setFlash(
                        __(
                            'The message has been saved. Please save your confirmation number for future reference. <br />' .
                            'Message Confirmation Reference : <strong>' . $confirmationHash . '</strong>'));
                }
                else{
                    $errors = $this->Message->validationErrors;
                    $this->Session->setFlash(__('The message could not be saved. Please, try again..<br /> '. $this->convert_validationErrors_toString($errors)), "default", array(
                        "class" => "alert alert-danger"
                    ));
                    $this->redirect($this->referer());
                }
				//return $this->redirect(array('action' => 'thanks'));
			} else {
                $errors = $this->Message->validationErrors;
				$this->Session->setFlash(__('The message could not be saved. Please, try again..<br /> '. $this->convert_validationErrors_toString($errors)), "default", array(
                    "class" => "alert alert-danger"
                ));
                $this->redirect($this->referer());
			}
		}
		//$users = $this->Message->User->find('list');
		//$this->set(compact('users'));

        $this->render('thanks');
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void

	public function edit($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
			$this->request->data = $this->Message->find('first', $options);
		}
		$users = $this->Message->User->find('list');
		$this->set(compact('users'));
	}
*/
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void

	public function delete($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Message->delete()) {
			$this->Session->setFlash(__('The message has been deleted.'));
		} else {
			$this->Session->setFlash(__('The message could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
*/
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
        $this->Message->recursive = 0;
        $this->Paginator = $this->Components->load("Paginator") ;
        $messages = array();

        $options = array(
            'recursive' => 0,
            'limit' => 10,
            'order' => array(
                'Message.date_sent' => 'desc'
            ),
            'fields' => array(
                'Message.id',
                'Message.date_sent',
                'Message.email',
                'Message.viewed',
                'Message.title',
                'Message.confirmation'));

        $this->Paginator->settings = $options;
        try{

            $results = $this->Paginator->paginate('Message');
            foreach($results as &$item){


                $message = array(
                    'id' => bin2hex($item["Message"]['id']),
                    'date' => $item["Message"]['date_sent'],
                    'email' => $item["Message"]['email'],
                    'title' => $item["Message"]['title'],
                    'viewed' => $item["Message"]['viewed'],
                    'confirmation' => $item["Message"]['confirmation']
                );

                array_push($messages, $message);
                unset($message);
            }
        }
        catch(NotFoundException $e){
            $this->Session->setFlash(__('Messages not found ' . $e ));
        }
        $this->set('messages', $messages);
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
        $id = pack("H*", $id);
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
        $foundMessage = $this->Message->find(
            'first',
            array(
                'fields' => 'Message.id, Message.title, Message.body, Message.email, Message.viewed,
                            Message.confirmation, Message.date_sent, User.username',
                'conditions' => array('Message.id' => $id),
                'recursive' => 1
            ));

        if (isset($foundMessage) && !empty($foundMessage) && $foundMessage['Message']['viewed'] == false){
            $this->Message->id = $foundMessage["Message"]['id'];
            $this->Message->saveField("viewed", 1);
        }
        $this->set("message", array_merge($foundMessage['Message'],array("User" => $foundMessage['User'])) );
        $this->set("backlink", $this->referer());
	}

/**
 * admin_add method
 *
 * @return void
 *
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		}
		$users = $this->Message->User->find('list');
		$this->set(compact('users'));
	}
*/
/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 *
	public function admin_edit($id = null) {
		if (!$this->Message->exists($id)) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
			$this->request->data = $this->Message->find('first', $options);
		}
		$users = $this->Message->User->find('list');
		$this->set(compact('users'));
	}
*/
/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void

	public function admin_delete($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Message->delete()) {
			$this->Session->setFlash(__('The message has been deleted.'));
		} else {
			$this->Session->setFlash(__('The message could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
*/

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('add');
    }
}
