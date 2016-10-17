<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/12/2016
 * Time: 4:08 PM
 */

$this->assign('title', 'Authenticate');

$recaptchaHelper = $this->Helpers->load('ReCaptcha', array('publicKey' => Configure::read('reCaptcha.publicKey')));
 $this->ReCaptcha->generateScriptTagOnloadCallback('recaptcha'); //

?>
<div class="payment-online-form-left">
<?php
    echo $this->Form->create(null, array("controller" => "pages", "action" => "login", "url" => array("controller" => "pages")));
    echo '<fieldset>';
    echo    '<legend>Login</legend>'                    //'<h4><span class="formHead"> </span>Login</h4>'
            . '<div class="row">'
            .'<div class="col-lg-6">';


    echo '<div  class="input-group input-group-lg">'
                    .'<span class="input-group-addon" id="username_spn" style="text-align: left;">User name   </span>';
    echo $this->Form->input("LoginViewModel.username", array(
            "class" => 'form-control',
            "placeholder" => "User name",
            'div' => false,
            'label' => false,
            'error' => false,
            "aria-describedby" => "username_spn" /*,
            "onfocus" => "this.value = '';",
            "onblur" => "if (this.value == '') {this.value = 'enter your username';}"*/
    ));
    echo '</div>';

    echo "<br />";

    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="userpwd_spn" style="text-align: left;">Password   </span>';
    echo $this->Form->input("LoginViewModel.password", array(
        "type" => "password",
        "class" => 'form-control',
        "placeholder" => "Password",
        'error' => false,
        'div' => false,
        'label' => false,
        "aria-describedby" => "userpwd_spn" /*,
        "onfocus" => "this.value = '';",
        "onblur" => "if (this.value == '') {this.value = 'enter your password';}"*/
    ));
    echo '</div>';

    echo '<p class="navbar-text navbar-right">';
    echo $this->Html->link(
        "forgot your password?",
        array("controller" => "pages", "action" => "display", "forgot_password"),
        array("class" => "navbar-link"));
    echo '</p>';

    echo '</div></div>';

    echo '<div id="recaptcha"></div>';

    echo '<fieldset>';

    echo $this->Form->end(array(
        "label" => "Login",
        "id" => "btn_login",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled"><li><input style="margin-right: .02em;" type="reset" value="Reset"></li>'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ));



?>
</div>
<?php $this->ReCaptcha->makeCallAfterFormEnd(); ?>