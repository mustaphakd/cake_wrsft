<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/25/2016
 * Time: 2:45 PM
 */

$this->footerOptions = array("footerAlignment" => "fixed");
?>

<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(null, array("controller" => "users", "action" => "forgotPassword", "url" => array("controller" => "users")));
    echo '<fieldset>';
    echo    '<legend>Send password reset request</legend>'
        . '<div class="row">'
        .'<div class="col-lg-6">';


    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="useremail_spn" style="text-align: left;">Email   </span>';
    echo $this->Form->input("email", array(
        "class" => 'form-control',
        "placeholder" => "enter your Email",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "useremail_spn",
        "required" => true
    ));
    echo '</div>';

    echo '</div></div>';

    echo '<fieldset>';

    echo $this->Form->end(array(
        "label" => "Send email",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled">'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
</div>