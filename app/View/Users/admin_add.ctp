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
    echo $this->Form->create(null, array("admin" => true, "controller" => "users", "action" => "add", "url" => array("controller" => "users")));
    echo '<fieldset>';
    echo    '<legend>Administrative User Creation Form</legend>'
        . '<div class="row">'
        .'<div class="col-lg-6">';


    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="username_spn" style="text-align: left;">Name   </span>';
    echo $this->Form->input("User.username", array(
        "class" => 'form-control text-box-dark',
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
        "class" => 'form-control text-box-dark',
        "placeholder" => "Email",
        'error' => false,
        'div' => false,
        'label' => false,
        "aria-describedby" => "useremail_spn",
        "required" => true
    ));
    echo '</div>';

    //echo '<div class="input-group input-group-lg">';
    //echo '<label >';

    echo '<li style="margin-top: 15px;display: inline-block;"><span class="col_checkbox">';

    echo $this->Form->checkbox(
        "User.activated",
        array(
            'class' => "css-checkbox1",
            'style' => "float: left",
            "value" => "active",
            "checked" => false,
            "hiddenField" => " "
        ));
    echo '<label for="UserActivated" class="css-label1" style="float: left;"></label>';
    echo '<label>Activate account</label> ';

    echo '</span></li>';

    //echo '</label>';
    //echo '</div>';

    echo '</div>';



    echo '<div class="col-lg-6">';

    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="userpwd_spn" style="text-align: left;">Password   </span>';
    echo $this->Form->input("User.password", array(
        "type" => "password",
        "class" => 'form-control text-box-dark',
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
        "class" => 'form-control text-box-dark',
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
    echo '<br />';

    echo '<fieldset>';

    echo '<legend> </legend>';


    echo '<fieldset>';
    echo    '<legend>Roles</legend>'
        . '<div class="row">'
        .'<div class="col-lg-6">';

    echo '<div class="btn-group" data-toggle="buttons">';

    $roleCounter = 0;
    foreach($roles as $role):

    echo '<label class="btn btn-lg btn-primary " style="margin-right: .3em;">';

    echo $this->Form->checkbox(
        "User.Roles.". $roleCounter++ ,
        array(
            "value" => $role['id'],
            "checked" => false,
            "hiddenField" => false
        ));
    echo $role['roleName'];

    echo '</label>';

    endforeach;


    echo '</div>';

    echo '</div>';
    echo '</div>';

    echo $this->Form->end(array(
        "label" => "Save",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled"><li><input style="margin-right: .02em;" type="reset" value="Reset"></li>'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
</div>