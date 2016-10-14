<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 9/21/2016
 * Time: 8:25 AM
 */

App::uses('AppController', 'Controller');
App::uses('LicensesController', 'Controller');
//App::import('LicensesController');

/**
 * Payments Controller
 *
 * @property Payment $Payment
 * @property User $User
 * @property Version $Version
 * @property License $License
 * */

class PaymentsController extends AppController{

    public $uses = array('Payment', 'User', 'Version', 'License');

    public function index(){
        throw new UnauthorizedException();
    }

    public function cashier(){

        $source = Router::parse($this->request->referer(true));
        if(strtolower($source['controller']) !== 'licenses'){
            throw new ForbiddenException('You are not allowed to accessing this page directly. Missing cookie var. :)');
        }

        $sessionVar = $this->Session->read(LicensesController::$_sessionKey);

        $this->request->data = array(
            'Cashier' => array(
                'duration' => '1',
                'price' => $sessionVar['price'],
                'description' => $sessionVar['description'],
                'title' => $sessionVar['title'],
                'total' => " " . intval($sessionVar['price'])
            )
        );
    }

    public function checkout(){

        $source = Router::parse($this->request->referer(true));
        if(strtolower($source['controller']) !== 'payments' || strtolower($source['action']) !== 'cashier' ){
            throw new ForbiddenException('You are not allowed to access this page directly.');
        }

        $data = $this->request->data;

        if ( (!isset($data['Cashier']['duration']))  || ($data['Cashier']['duration'] <= 0))
        {
            $this->Session->setFlash(
                __('the duration requested for your license is incorrect'),
                "default",
                array(
                    "class" => "alert alert-danger"));

            return;
        }

        $sessionVar = $this->Session->read(LicensesController::$_sessionKey);

        if (!is_numeric( floatval($sessionVar['price']))){
            $this->Session->setFlash(
                __('Illegal operation'),
                "default",
                array(
                    "class" => "alert alert-danger"));

            $this->redirect($this->referer());
        }

        preg_match_all('!\d+!', $sessionVar['price'], $matches);

        if (!isset($matches) ||$matches <= 0 || ! is_array($matches)){
            $this->Session->setFlash(
                __('the duration requested for your license is incorrect'),
                "default",
                array(
                    "class" => "alert alert-danger"));

            $this->redirect($this->referer());
        }

        $price = $matches[0][0];

        if ( !is_numeric($price)){
            $this->Session->setFlash(
                __('the duration requested for your license is incorrect'),
                "default",
                array(
                    "class" => "alert alert-danger"));

            return;
        }

        $total = $price * floatval($data['Cashier']['duration']);

        if ($total != floatval($data['Cashier']['total'])){
            $this->Session->setFlash(
                __('Illegal operation'),
                "default",
                array(
                    "class" => "alert alert-danger"));

            $this->redirect($this->referer());
        }

        $currencyArr = explode(" ", trim($sessionVar['price']));
        $currency = $currencyArr[1];

        $this->Session->write(
            LicensesController::$_sessionKey,
            array_merge(
                $sessionVar,
                array(
                    'duration' => floatval($data['Cashier']['duration']),
                    'total'=> $total,
                    'currency' => $currency)));

        $this->redirect(
            Router::url(
                array(
                    'controller' => 'Payments',
                    'action' => 'checkout_confirm'
                ), true
            )
        );
    }

    public function checkout_confirm(){

        if($this->request->is('post')){


            return;
        }

        $source = Router::parse($this->request->referer(true));
        if(strtolower($source['controller']) !== 'payments'){
            throw new ForbiddenException('You are not allowed to accessing this page directly.');
        }

        $sessionVar = $this->Session->read(LicensesController::$_sessionKey);

        $this->request->data = array(
            'Cashier' => array(
                'duration' => '1',
                'price' => $sessionVar['price'],
                'description' => $sessionVar['description'],
                'title' => $sessionVar['title'],
                'total' => $sessionVar['total'] . " " .$sessionVar['currency'],
                'currency' => $sessionVar['currency']
            )
        );
    }

    public function history(){}


    public function admin_history(){

    }


    public function beforeFilter(){

    }
}