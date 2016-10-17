<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 10/17/2016
 * Time: 4:14 PM
 */

App::uses('AppHelper', 'View/Helper');

/**
 *   ReCaptchaHelper from google
 *
 * @property string $publicKey
 *
 *
 */
class ReCaptchaHelper extends AppHelper {

    private $_publicKey = '';
    //private $_view = null;

    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        $this->_publicKey = $settings['publicKey'];
        //$this->_view = $view;
    }

   /* public function generateScriptTagOnloadCallback($element_id){
    //$this $this->View->Html->scriptBlock($script, array("inline"))
    return '
        <script type="text/javascript">
        var onloadCallback = function(){
        grecaptcha.render(\''. $element_id .'\', {
        sitekey: "' . $this->_publicKey . '"});
        };
        </script>
        ';
}

    public  function makeCallAfterFormEnd(){
        //$this->HTML->script
        return '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer></script>';
    }*/

    public function generateScriptTagOnloadCallback($element_id){
       echo $this->_View->Html->scriptBlock('
        var onloadCallback = function(){
        grecaptcha.render(\''. $element_id .'\', {
        sitekey: "' . $this->_publicKey . '"});
        }', array("inline"));
    }

    public  function makeCallAfterFormEnd(){
        echo $this->_View->HTML->script(
            "https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit",
            array("async", "defer"));
    }
}