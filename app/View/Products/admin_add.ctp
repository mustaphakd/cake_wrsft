<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 8/6/2016
 * Time: 4:31 PM
 */

?>

<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(null, array("admin" => true, "controller" => "products", "action" => "add", "url" => array("controller" => "products")));
    echo '<fieldset>';
    echo    '<legend>Product Creation Form</legend>'
        . '<div class="row">'
        .'<div class="col-lg-4">';


    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="prdctname_spn" style="text-align: left;">Name   </span>';
    echo $this->Form->input("Product.name", array(
        "class" => 'form-control text-box-dark',
        "placeholder" => "Product name",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "prdctname_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';

    echo '<div class="col-lg-4">';
    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="announceddate_spn" style="text-align: left;">Availability   </span>';
    echo $this->Form->input("Product.announced_date", array(
        "type" => "date",
        "class" => 'form-control text-box-dark',
        "placeholder" => "Select date",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "announceddate_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';

    echo '<br />';
    echo '<br />';

    echo '<div class="col-lg-8" style="margin-top: 15px;">';
    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="prdctdescription_spn" style="text-align: left;">Description   </span>';
    echo $this->Form->input("Product.description", array(
        "type" => "textarea",
        "class" => 'form-control text-box-dark',
        "placeholder" => "brief description",
        'div' => false,
        'label' => false,
        'error' => false,
        'row' => "50",
        'cols' => "30",
        'rows' => "6",
        'style' => "margin: 0px; width: 603px; height: 259px;",
        "aria-describedby" => "prdctdescription_spn",
        "required" => true,
        "row" => 50
    ));
    echo '</div>';
    echo '</div>';



    echo '</div>';
    echo '</fieldset>';

    echo $this->Form->end(array(
        "label" => "Save",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled"><li><input style="margin-right: .02em;" type="reset" value="Reset"></li>'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
</div>