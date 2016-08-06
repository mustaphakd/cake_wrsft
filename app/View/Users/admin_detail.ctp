<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/12/2016
 * Time: 4:08 PM
 */
?>

<div class="payment-online-form-left">

    <div class="row">
        <div class="col-md-6">
                <fieldset>
                    <h4>User Info</h4>
                    <dl class="dl-horizontal">
                        <dt>Id</dt>
                        <dd><?php echo $user['id'] ?></dd>
                        <dt>User name</dt>
                        <dd><?php echo $user['username'] ?></dd>
                        <dt>Email</dt>
                        <dd><?php echo $user['email'] ?></dd>
                        <dt>Confirmation date</dt>
                        <dd><?php echo $user['confirmed'] ?></dd>
                        <dt>Account creation date</dt>
                        <dd><?php echo $user['created'] ?></dd>
                        <dt>Confirmation hash</dt>
                        <dd><?php echo $user['confirmationhash'] ?></dd>
                        <!--<dt>Reset confirmaiton hash</dt>
                        <dd><?php //echo $user['resethash']
                        ?></dd>-->
                    </dl><?php

                    if (isset($user['Role']) && is_array($user['Role']) && !empty($user['Role']))
                        echo '<h2><small>Roles</small></h2>';
                    foreach($user['Role'] as $role){
                        echo '<strong><span class="label label-primary">'. $role["name"] .'</span><strong>';

                    }

                    echo $this->Form->create(null, array("admin" => true, "controller" => "users", "action" => "edit", "id" => $user['id'], "url" => array("controller" => "users")));
                    echo $this->Form->end(array(
                        "label" => "Edit",
                        "div" => "row",
                        "before" => '<ul class="payment-sendbtns list-unstyled"><li>',
                        "after" => '</li></ul><div class="clearfix"> </div>'
                    ))
                    ?>
                </fieldset>
        </div>
        <div class="col-md-6">
        <fieldset>
            <h4>Payments</h4>
            <dl class="dl-horizontal">
                <dt>Skrills</dt>
                <dt>Payoneer</dt>
                <dt>paypal</dt>
            </dl>
        </fieldset>
    </div>
    </div>

    <div class="col-md-6">
        <fieldset>
            <h4>Licences Summaries</h4>

        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset>
            <h4>Products Listing</h4>

        </fieldset>
    </div>


    <ul class="payment-sendbtns list-unstyled">
        <li>
            <?php $this->Form->input("", array(
                "type" => "button",
                "class" => 'form-control',
                'error' => false,
                'div' => false,
                'label' => false,
                'value' => "Edit",
                'style' => "margin-right: .02em;",
                'controller' => 'users',
                'action' => 'index'
            )) ?>
        </li>
    </ul>
</div>