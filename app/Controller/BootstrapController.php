<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 10/13/2016
 * Time: 10:24 AM
 */

/**
 * Bootstrap Controller
 *
 * @property User $User
 * @property Role $Role
 *
 *
 */

App::uses('AppController','Controller');

class BootstrapController extends AppController{

    public $uses = array('User','Role');
    private $_rolesCache = array();

    public function index(){
        $url = Router::url(array(
            'controller' => 'Pages',
            'action' => 'display'
        ), true);
        $this->redirect($url);
    }

    public  function initApp(){
        $this->loadModel('User');

        $userCount = $this->User->find('count');
        $url = Router::url(array(
            'controller' => 'Pages',
            'action' => 'display'
        ), true);

        if ($userCount > 0) return $this->redirect($url);

        $roles = array(
            array('name' => 'patron'),
            array('name' =>  'admin'),
            array('name' =>  'support'),
            array('name' =>  'manager'));

        $this->createRoles($roles);
        $this->createUsers(
            array(
                array(
                    'username' => 'root',
                    'email' => 'root@wrsft.com',
                    'password' => 'root_admin',
                    'roles' => array('admin')
                ),
                array(
                    'username' => 'manager1',
                    'email' => 'manager1@wrsft.com',
                    'password' => 'manager1',
                    'roles' => array('manager')
                ),
                array(
                    'username' => 'manager2',
                    'email' => 'manager2@wrsft.com',
                    'password' => 'manager2',
                    'roles' => array('manager')
                ),
                array(
                    'username' => 'user1',
                    'email' => 'user1@wrsft.com',
                    'password' => 'user1',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'user2',
                    'email' => 'user2@wrsft.com',
                    'password' => 'user2',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'user3',
                    'email' => 'user3@wrsft.com',
                    'password' => 'user3',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'user4',
                    'email' => 'user4@wrsft.com',
                    'password' => 'user4',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'user5',
                    'email' => 'user5@wrsft.com',
                    'password' => 'user5',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'user6',
                    'email' => 'user6@wrsft.com',
                    'password' => 'user6',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'user7',
                    'email' => 'user7@wrsft.com',
                    'password' => 'user7',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'user8',
                    'email' => 'user8@wrsft.com',
                    'password' => 'user8',
                    'roles' => array('patron')
                ),
                array(
                    'username' => 'techsupport',
                    'email' => 'techsupport@wrsft.com',
                    'password' => 'techsupport',
                    'roles' => array('support')
                ),
                array(
                    'username' => 'support1',
                    'email' => 'support1@wrsft.com',
                    'password' => 'support1',
                    'roles' => array('support')
                ),
            )
        );
        $this->Session->setFlash(__('Users Created!'), "default", array(
            "class" => "alert alert-success"
        ));

        return $this->redirect($url);
    }

    private function createRoles($roles){
        $this->loadModel('Role');
        $this->Role->saveMany(
            $roles,
            array( 'validate' => false)
        );

        $unformattedRoles = $this->Role->find('all');

        foreach($unformattedRoles as $unformattedRole){
            array_push($this->_rolesCache, $unformattedRole['Role']);
        }
    }

    private function getRoleId($roleName){
        if(!isset($roleName) || empty($roleName))
            return null;
        $roleName = strtolower(trim($roleName));
        foreach($this->_rolesCache as $role){
            $lower = strtolower(trim($role['name']));
            if (strcmp($roleName, $lower) == 0){
                return $role['id'];
            }
        }
        return null;
    }

    private  function createUsers($userArr){

        $dateTIme = new DateTime('now', new DateTimeZone('UTC'));
        $dateFormat  = $dateTIme->format("Y-m-d H:i:s");
        $users = array();

        foreach($userArr as &$user){
            $roleArr = array('Role' => array($this->getRoleId($user['roles'][0])));
            $user["confirmed"] = $dateFormat;
            $user["confirmationhash"] = $this->_generateHash();
            unset($user['roles']);
            $newUser = array('User' => $user);

            array_push($users, array_merge($newUser, $roleArr));
            unset($user);
        }

        $this->User->saveAll($users, array('validate' => false, 'deep' => true));
    }


    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow(array("index", "initApp"));
    }
}