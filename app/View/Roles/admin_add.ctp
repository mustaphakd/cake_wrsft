<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 7/30/2016
 * Time: 5:40 PM
 */

?>

<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(null, array("controller" => "roles", "action" => "add", "url" => array("controller" => "roles")));
    echo '<fieldset>';
    echo    '<legend>Add new Role</legend>'
        . '<div class="row">'
        .'<div class="col-lg-8">';


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

    echo "<br />";

    echo '</div></div>';

    echo '<fieldset>';

    echo $this->Form->end(array(
        "label" => "Create",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled"><li><input style="margin-right: .02em;" type="reset" value="Reset"></li>'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
</div>