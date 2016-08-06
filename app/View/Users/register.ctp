<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/12/2016
 * Time: 4:08 PM
 */
?>

<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(null, array("controller" => "users", "action" => "register", "url" => array("controller" => "users")));
    echo '<fieldset>';
    echo    '<legend>Registration Form</legend>'
        . '<div class="row">'
        .'<div class="col-lg-6">';


    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="username_spn" style="text-align: left;">Name   </span>';
    echo $this->Form->input("User.username", array(
        "class" => 'form-control',
        "placeholder" => "User name",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "username_spn",
        "required" => true
    ));
    echo '</div>';

    echo "<br />";

    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="useremail_spn" style="text-align: left;">Email   </span>';
    echo $this->Form->input("User.email", array(
        "type" => "email",
        "class" => 'form-control',
        "placeholder" => "Email",
        'error' => false,
        'div' => false,
        'label' => false,
        "aria-describedby" => "useremail_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';



    echo '<div class="col-lg-6">';

    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="userpwd_spn" style="text-align: left;">Password   </span>';
    echo $this->Form->input("User.password", array(
        "type" => "password",
        "class" => 'form-control',
        "placeholder" => "Password",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "userpwd_spn",
        "required" => true,
        "id" => "UserPassword",
        "onchange" => '
        controlsValueMatch(this, $("#UserConfirmPassword")[0]);'
    ));
    echo '</div>';

    echo "<br />";

    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="userconfirmpwd_spn" style="text-align: left;">confirm password   </span>';
    echo $this->Form->input("User.confirmPassword", array(
        "type" => "password",
        "class" => 'form-control',
        "placeholder" => "Confirm password",
        'error' => false,
        'div' => false,
        'label' => false,
        "aria-describedby" => "userconfirmpwd_spn",
        "required" => true,
        "id" => "UserConfirmPassword",
        "onchange" => '
        controlsValueMatch( $("#UserPassword")[0], this);'
    ));
    echo '</div>';
    echo '</div>';



    echo '</div>';
    echo '<fieldset>';

    echo $this->Form->end(array(
        "label" => "Register",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled"><li><input style="margin-right: .02em;" type="reset" value="Reset"></li>'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
</div>