<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/25/2016
 * Time: 9:27 AM
 */

App::uses('AppModel', 'Model');

class LoginViewModel extends AppModel{
    public  $useTable = false;

   /* public $user_name;
    public $password;*/

    public $validate = array(
        'username' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'user name required',
                'allowEmpty' => false,
                'required' => true
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'password required',
                'allowEmpty' => false,
                'required' => true
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
    );

} 