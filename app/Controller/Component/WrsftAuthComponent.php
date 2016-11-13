<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 10/14/2016
 * Time: 7:16 PM
 */


App::uses('Component', 'Controller');

/**
 * WrsftAuthComponent
 *
 *  @property AuthComponent $Auth
 */
class WrsftAuthComponent extends Component {

    public $components = array('Auth');

    private $_initz = false;
    private $_roles = array();

    public function __construct(ComponentCollection $collection, $settings = array()){
        //$this->initialize(null);
    }

    public function initialize(Controller $controller) {
        if(! $this->_initz){
            $this->Auth = ($controller->Auth);

            $user = $this->Auth->user(); //how to pull roles as simple array

            $tempRoles = $user['Role'];

            if (isset($tempRoles))
            foreach($tempRoles as $role){
                array_push($this->_roles, $role['name']);
            }

            $this->_initz = true;
        }
    }

    public function IsInEitherRoles($roles){

        if(!$this->Auth->user())
            return false;

        if(!isset($roles) || empty($roles))
            return true;

        if(is_array($roles)){
            foreach($roles as $role){
                if ($this->IsInEitherRoles($role)){
                    return true;
                }
            }
            return false;
        }

        foreach($this->_roles as $role){
            if (strcasecmp($role, $roles) == 0)
                return true;
        }

        return false;
    }

    public  function ConstraintRolesAction($roleConstraints = array()){

        foreach($roleConstraints as $role => $constraint){
            if($this->IsInEitherRoles($role)){
                $this->Auth->allow($constraint);
            }
        }
    }

} 