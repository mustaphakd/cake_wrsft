<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 10/17/2016
 * Time: 9:53 PM
 */

App::uses('AppHelper', 'View/Helper');


class RolesHelper extends AppHelper {

    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
    }

    public function isUserInRoles($userRoles, $roles){
        if(!isset($userRoles) || empty($userRoles))
            return false;

        foreach($userRoles as $userRole){
            foreach($roles as $role){
                if ( strcasecmp($userRole['name'], $role) == 0 )
                    return true;
            }
        }

        return false;
    }
} 