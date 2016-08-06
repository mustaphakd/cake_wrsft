<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 7/31/2016
 * Time: 1:53 PM
 */

?>
<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(
        null,
        array(
            "admin" => true,
            "controller" => "roles",
            "action" => "edit",
            $this->request->data['Role']['id'],
            "method" => "post",
            "url" => array("controller" => "roles")));
    echo '<fieldset>';
    echo    '<legend>Edit Role</legend>'
        . '<div class="row">'
        .'<div class="col-lg-6">';


    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="rolename_spn" style="text-align: left;">Role name   </span>';
    echo $this->Form->input("Role.name", array(
        "class" => 'form-control',
        "placeholder" => "Role name",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "rolename_spn"
    ));
    echo '</div>';

    echo '</div></div>';

    echo '<fieldset>';

    echo $this->Form->end(array(
        "label" => "Update",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled"><li><a class="btn" href="'. $this->Html->url(array("controller" => "Roles", "action" => "index", "admin" => true)) .'">Cancel</a></li>'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
</div>