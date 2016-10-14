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
 * @property WrsftAuthComponent $WrsftAuth
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array(
        'Session',
        'DebugKit.Toolbar',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'pages', 'action' => 'index'),
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
        //$datetime = new DateTime('now', new DateTimeZone('UTC'));
        //$formattedDateTime = $datetime->format("Y-m-d H:i:s");
        $formattedDateTime =  $this->udate('Y-m-d H:i:s.u T');
        $hash = $this->_getHash($formattedDateTime);
        return $hash;
    }

    //http://php.net/manual/en/datetime.format.php
    protected function udate($strFormat = 'u', $uTimeStamp = null)
    {

        // If the time wasn't provided then fill it in
        if (is_null($uTimeStamp))
        {
            $uTimeStamp = microtime(true);
        }

        // Round the time down to the second
        $dtTimeStamp = floor($uTimeStamp);

        // Determine the millisecond value
        $intMilliseconds = round(($uTimeStamp - $dtTimeStamp) * 1000000);
        // Format the milliseconds as a 6 character string
        $strMilliseconds = str_pad($intMilliseconds, 6, '0', STR_PAD_LEFT);

        // Replace the milliseconds in the date format string
        // Then use the date function to process the rest of the string
        return date(preg_replace('`(?<!\\\\)u`', $strMilliseconds, $strFormat), $dtTimeStamp);
    }

    public function isAuthorized($user){
        //ToDO: need revise. check prefix before continuing to admin related dash
        if ($this->params['prefix'] == 'admin' ) {
            //$test = "rse";
        }

        if ($this->params['prefix'] == 'patron' ) {
            //$test = "rse";
        }

        $this->WrsftAuth = $this->Components->load('WrsftAuth');
        $this->WrsftAuth->initialize($this);
        if ($this->WrsftAuth->IsInEitherRoles('admin'))
            return true;

        return false;

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
