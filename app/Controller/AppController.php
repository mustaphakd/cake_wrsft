<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array(
        'Session',
        'DebugKit.Toolbar',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'accounts', 'action' => 'index'),
            'logoutRedirect' => array(
                'controller' => 'pages',
                'action' => 'display',
                'home'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            ),
            'authorize' => array('Controller'),
            'loginAction' => array(
                'controller' => 'pages',
                'action' => 'login',
                'plugin' => null
            )
        )
    );


    protected function _getHash($string)
    {
        App::uses("Security", "Utility");

        return Security::hash($string, 'sha1');
    }

    protected  function _generateHash()
    {
        $datetime = new DateTime('now', new DateTimeZone('UTC'));
        $formattedDateTime = $datetime->format("Y-m-d H:i:s");
        $hash = $this->_getHash($formattedDateTime);
        return $hash;
    }

    public function isAuthorized($user){
        //ToDO: need revise. check prefix before continuing to admin related dash
        if ($this->params['prefix'] == 'admin' ) {
            $test = "rse";
        }

        if ($this->params['prefix'] == 'patron' ) {
            $test = "rse";
        }
        return true;

    }

    public function convert_validationErrors_toString($validationErrors){
        $text = "";
        foreach($validationErrors as $pk => $assoc) {
            foreach ($assoc as $k => $v) {
                $text .= $pk. " : " . $k ." : " . $v;
            }
            $text .= "<br />";
        }
        return $text;
    }
}
