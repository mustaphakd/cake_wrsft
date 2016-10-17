<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 10/17/2016
 * Time: 8:26 PM
 */


App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * ReCaptchaComponent
 *
 *
 */
class ReCaptchaComponent extends Component {


    private $_initz = false;

    private  $_reCaptchaEndpoint =  'https://www.google.com/recaptcha/api/siteverify';

    public function __construct(ComponentCollection $collection, $settings = array()){
        parent::__construct($collection, $settings);
    }

    public function initialize(Controller $controller) {
        if(! $this->_initz){

            $this->_initz = true;
        }
    }


    /**
     * @param string $secret ::> your reCaptcha private/secret key
     * @param $userResponseToken ::> g-recaptcha-response POST parameter
     * @param $userRemoteIp ::> client ip address
     *
     * @return array having following keys: 'success', 'error-codes', 'hostname', 'challenge_ts'
     */
    public function VerifyUserResponse($secret, $userResponseToken, $userRemoteIp){

        $HttpSocket = new HttpSocket();

        $body = array(
            'secret' => $secret,
            'response' => $userResponseToken,
            'remoteip' => $userRemoteIp
        );

        $response = $HttpSocket->post($this->_reCaptchaEndpoint, $body );
        $response =  json_decode($response['body'], true);

        if (!$response['success']){
            $errMsg = '';

            switch(trim($response["error-codes"][0])){

                case 'missing-input-response':
                    $errMsg = 'The response parameter is missing.';
                    break;
                case 'invalid-input-response':
                    $errMsg = 'The response parameter is invalid or malformed.';
                    break;
                case 'missing-input-secret':
                case 'invalid-input-secret':
                    default:
                    $errMsg = "internal server error";
                    break;
            }

            $response["error-codes"] = $errMsg;
        }

        return $response;
    }
} 