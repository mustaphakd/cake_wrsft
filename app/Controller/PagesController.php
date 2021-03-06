<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/*
 *
 * @property LoginViewModel $LoginViewModel
 * */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

    public  function login()
    {
        if ($this->request->is('post'))
        {
            $this->loadModel("LoginViewModel");
            $this->LoginViewModel->set($this->request->data);

            if ($this->LoginViewModel->validates())
            {
/*
                $reCaptcha = $this->Components->load('ReCaptcha');
                $reCaptcha->initialize($this);

                $validation = $reCaptcha->VerifyUserResponse(
                    Configure::read('reCaptcha.privateKey'),
                    $this->request->data['g-recaptcha-response'],
                    $this->request->clientIp()
                    );

                if(!$validation['success']){
                    $this->Session->setFlash(__($validation['error-codes']), "default", array(
                        "class" => "alert alert-danger"
                    ));
                    return;
                }*/


                $this->loadModel("User");
                $this->loadModel("Role");
                $this->User->recursive = 1;
                //$this->User->set(array('password' => $this->LoginViewModel->data['LoginViewModel']['password']));
                $passwordHasher = new BlowfishPasswordHasher();
                $pwd = $this->LoginViewModel->data['LoginViewModel']['password'];
                $foundUser = $this->User->find(
                    "first",
                    array(
                        "conditions" => array(
                            'username' => $this->LoginViewModel->data['LoginViewModel']['username'])));

                if(!isset($foundUser) || empty($foundUser))
                {
                    $this->Session->setFlash(__('User not found!'), "default", array(
                        "class" => "alert alert-danger"
                    ));
                    return;
                }

                $matched = $passwordHasher->check($pwd, $foundUser['User']['password']);

                if(! $matched)
                {
                    $this->Session->setFlash(
                        __('Invalid password, account will be disactivated after a number of retrials'),
                        "default", array(
                            "class" => "alert alert-danger"
                    ));
                    return;
                }


                unset($foundUser[$this->User->alias]["password"]);
                $userToken = array_merge($foundUser[$this->User->alias], array('Role' =>  $foundUser[$this->Role->alias]));
                //array_merge($userToken['Role'];


                unset($this->request->data);
                unset($foundUser);

                $this->Auth->login($userToken);
                $paths = explode("/", $this->referer());
                $endToken = end($paths);
                $this->redirect(strcmp($endToken, "login") == 0 ? $this->Auth->redirectUrl() :$this->referer());
            }
            $this->Session->setFlash(__('Please enter all information required'), "default", array(
                "class" => "alert alert-danger"
            ));

        }



        if ($this->Auth->user() !== null)
        {
            $this->redirect(array(
                "controller" => "pages",
                "action" => "display",
                "home"
            ));
        }

        unset($this->LoginViewModel);
        unset($this->request->data);


        $this->render();
    }

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('display', 'login');

        if (isset($this->request->params['prefix'])){

            $prefix = $this->request->params['prefix'];
            unset($this->request->params['prefix']);

            $this->request->params['action'] = preg_replace('/'. $prefix .'_/','', $this->request->params['action'] );
            $this->view = preg_replace('/'. $prefix .'_/','', $this->view );
            unset($this->request->params[$prefix]);
        }
    }

}
