<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
//todo:  app\View\Errors\fatal_error.ctp
//todo: app\View\Errors\pdo_error.ctp
//todo: app\View\Errors\missing_view.ctp
//todo: pagination inside admin_index.ctp
//todo: audit trails in v3. so when managers edits a user, trails are kept.

    public function admin_index(){

        $this->User->recursive = 0;
        $this->Paginator = $this->Components->load("Paginator") ;
        $users = array();

        $options = array(
            'recursive' => 0,
            'limit' => 25,
            'order' => array(
                'User.confirmed' => 'desc'
            ),
            'fields' => array(
                'User.id',
                'User.username',
                'User.email',
                'User.created',
                'User.confirmed'));

        $this->Paginator->settings = $options;
        try{

            $results = $this->Paginator->paginate('User');
            foreach($results as &$item){


                $user = array(
                    'id' => bin2hex($item["User"]['id']),
                    'username' => $item["User"]['username'],
                    'email' => $item["User"]['email'],
                    'created' => $item["User"]['created'],
                    'confirmed' => $item["User"]['confirmed']
                );

                if (isset($item["User"]['confirmed']) && ! empty($item["User"]['confirmed'])) {
                    $user['active'] = true;
                }else {
                    $user['active'] = false;
                }

                array_push($users, $user);
                unset($user);
            }
        }
        catch(NotFoundException $e){
            $this->Session->setFlash(__('Users not found ' . $e ));
        }
        $this->set('users', $users);
    }

    public function admin_add(){
        if ($this->request->is('post')){

            if (!isset($this->request->data))
                return;

            $newUser = $this->request->data['User'];
            ///$newUser["confirmationhash"] = $this->_generateHash();

            if (isset($newUser['Roles']))
                unset($newUser['Roles']);

            if (isset($newUser['activated']))
                unset($newUser['activated']);

            $this->User->create($newUser);
            $this->User->set("confirmationhash",$this->_generateHash());

            if (isset($this->request->data['User']['activated'])){
                $dateTIme = new DateTime('now', new DateTimeZone('UTC'));
                $dateTIme->modify("+6 minutes");
                $this->User->set("confirmed",$dateTIme->format("Y-m-d H:i:s"));
            }

            $validationResults = $this->User->validates();

            if ($validationResults)
            {
                if (isset($this->request->data['User']['Roles']) && is_array($this->request->data['User']['Roles'])){
                    $roles = array();
                    foreach($this->request->data['User']['Roles'] as $role){
                        $roleId  = pack("H*", $role);

                        array_push($roles, $roleId);
                    }

                 /*   $this->loadModel('Role');
                    $foundRoles = $this->Role->find(
                        'all',
                        array(
                            'recursive' => 0,
                            'conditions' => array('Role.id' => $roles)
                        ));
*/

                   // if (isset($foundRoles) && !empty($foundRoles)){
                        $this->User->data['Role'] = array('Role' => $roles); // $foundRoles;

                        if ($this->User->saveAll(null, array('deep' => true)))
                        {
                            $href = Router::url(
                                array(
                                    "controller" => "users",
                                    "action" => "admin_index"),
                                true);
                            unset($this->request->data);

                            $this->redirect($href);
                        }
                    //}
                }
            }
            else{
                $errors = $this->convert_validationErrors_toString($this->User->validationErrors) ;
                $this->Session->setFlash($errors, "default", array(
                    "class" => "alert alert-danger"
                ));
            }
        }

        $this->loadModel('Role');
        $foundList = $this->Role->find(
            'list',
            array('recursive' => 0));

        $roles = array();
        foreach($foundList as $key => $value){
            $roleId = bin2hex($key);
            $roleName = $value;

            array_push($roles, array("id" => $roleId, "roleName" => $roleName));
        }

        $this->set("roles", $roles);
        $this->render('admin_add');
    }

    public function admin_detail($id){
        $id = pack("H*", $id);
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        $foundUser = $this->User->find(
            'first',
            array(
                'fields' => 'User.id, User.username, User.created, User.email, User.confirmed, User.confirmationhash',
                'conditions' => array('User.id' => $id),
                'recursive' => 1
            ));
        $this->set("user", array_merge($foundUser['User'],array("Role" => $foundUser['Role'])) );
    }

    public function admin_edit(){
         if (! $this->request->is("post"))
             $this->redirect($this->referer());
    }

    public  function forgotPassword()
    {
        if ($this->request->is('post'))
        {
            if (isset($this->request->data["email"]) &&
                !empty($this->request->data["email"]))
            {
                $foundUser = $this->User->find(
                    'first',
                    array(
                        "conditions" => array("User.email" => $this->request->data["email"])
                    ));

                $hash = $this->_generateHash();

                if (!isset($foundUser) || empty($foundUser))
                {
                    $this->Session->setFlash(
                        __('An account with the email: $this->request->data["email"] could not be found.'),
                        "default",
                        array(
                        "class" => "alert alert-danger"
                    ));
                    $this->render('/Messages/thanks');
                    return;
                }

                $this->User->id = $foundUser["id"];
                $this->User->saveField("resethash", $hash);

                $href = Router::url(array(
                    "controller" => "users",
                    "action" => "resetPassword",
                    $hash
                ), true);

               // $this->SendPasswordResetEmail($this->request->data["email"], $href);
                $this->Session->setFlash('<a href="'. $href .'"> '. $href .' </a>');

                $this->set(
                    "message",
                    "A message has been sent to your email:" . $this->request->data["email"] );
                $this->render('/Messages/thanks');
                return;
            }
        }
        $this->redirect($this->referer(),true);
    }

    public function resetPassword($hash)
    {
        if ($this->request->is('post'))
        {
            if (isset($this->request->data) &&
                !empty($this->request->data))
            {

            }

            return;
        }

        if (!isset($hash) || empty($hash))
        {
            throw new BadRequestException();
        }

        $foundUser = $this->User->find(
            'first',
            array(
                "conditions" => array("User.resethash" => $hash),
                "fields" => array("id", "resethash")
            ));

        if (!isset($foundUser) || empty($foundUser))
        {
            throw new NotFoundException("nothing found!");
        }

        $this->set("user",$foundUser);
    }

    public function register()
    {
        if ($this->request->is('post'))
        {
            if ($this->doesUserExist($this->request->data[$this->User->alias]))
            {
                $this->Session->setFlash(
                    __('A user with the same username and/or email already exist'),
                    "default",
                    array(
                        "class" => "alert alert-danger"));
                return;
            }

            $this->User->create($this->request->data);
            $this->User->set("confirmationhash",$this->_generateHash());
            $this->User->data['Role'] = array($this->RetrieveRole('patron'));

            if ($this->User->validates())
            {
                if (!$this->User->save(null, true, array("username", "password", "email", "confirmationhash")))
                {
                    return;
                }

                $href = Router::url(
                    array(
                        "controller" => "users",
                        "action" => "confirm_account",
                        $this->User->field("confirmationhash")),
                    true);

                $userEmail = $this->request->data['User']['email'];

                unset($this->request->data);


                //todo: validate sending of email
                $this->SendPasswordResetEmail($userEmail, $href);
                $this->Session->setFlash('<a href="'. $href .'">  </a>'); //$href

                $this->set("message", "An email has been sent to you. click on the link to active your account.");
                $this->render('/Messages/thanks');
            }
        }
    }

    private function RetrieveRole($roleName){
        $this->loadModel('Role');
        $unformattedRoles = $this->Role->find('all');
        $_rolesCache = array();

        foreach($unformattedRoles as $unformattedRole){
            array_push($_rolesCache, $unformattedRole['Role']);
        }

        if(!isset($roleName) || empty($roleName))
            return null;
        $roleName = strtolower(trim($roleName));
        foreach($_rolesCache as $role){
            $lower = strtolower(trim($role['name']));
            if (strcmp($roleName, $lower) == 0){
                return $role['id'];
            }
        }
        return null;
    }

    public  function create_default_accounts(){
        $url = Router::url(array(
            'controller' => 'bootstrap',
            'action' => 'initapp'
        ),true);

        $this->redirect($url);
    }

    public function confirm_account($confirmationHash)
    {
        $message = 'Account not found. can not be confirmed!';

        $this->User->recursive = 1;
        $foundUser = $this->User->findByConfirmationhash($confirmationHash);

        if (isset($foundUser) && !empty($foundUser))
        {
            $this->User->id = $foundUser[$this->User->alias]["id"];
            $dateTIme = new DateTime('now', new DateTimeZone('UTC'));
            $this->User->saveField("confirmed", $dateTIme->format("Y-m-d H:i:s"));
            $message = "Your account has been activated";


            //logs in User atmic
            $userToken = array_merge($foundUser[$this->User->alias], $foundUser[$this->Role->alias]);
            unset($this->request->data);
            unset($foundUser);
            $this->Auth->login($userToken);
        }

        $this->set(
            "message",
            $message);
        $this->render('/Messages/thanks');
        return;
    }

    private function SendPasswordResetEmail($email, $href)
    {
        if (empty($email) ||
            $email == null
        )
        {
            throw new InvalidArgumentException('Invalid');
        }

        App::uses('CakeEmail', 'Network/Email');

        $Email = new CakeEmail();
        $Email->template('passwordReset', 'email')//view, layout
            ->emailFormat('html')
            ->from(array('services@worosoft.com' => 'WoroSoft'))
            ->to($email)
            ->subject("Password reset request")
            ->viewVars(array('content' => $href))
            ->send();

        /*$this->Email->to = $email;
        $this->Email->from = "services@worosoft.com";
        $this->Email->subject = "Password reset request";

        $this->Email->sendAs = "html";

        $this->Email->send($href,"passwordReset", "email");*/
    }

    private function doesUserExist($user)
    {
        $foundUser = $this->User->findAllByEmailOrUsername($user['email'], $user['username']);

        if (isset($foundUser) && ! empty($foundUser))
        {
            return true;
        }
        return false;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow(
            'forgotPassword',
            'logout',
            'resetPassword',
            'confirm_account',
            'register',
            'create_default_accounts');
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

}
