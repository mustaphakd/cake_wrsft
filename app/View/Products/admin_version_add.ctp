<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 8/7/2016
 * Time: 9:49 PM
 */

?>

<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(null, array("admin" => true, "url" => array("controller" => "products", "action" => "admin_version_add", "productId" =>$productId)));
    echo '<fieldset>';
    echo    '<legend>Version Creation Form</legend>'
        . '<div class="row">'
        .'<div class="col-lg-4">';


    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="vrsionname_spn" style="text-align: left;">Name   </span>';
    echo $this->Form->input("Version.name", array(
        "class" => 'form-control text-box-dark',
        "placeholder" => "Product Version name",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "vrsionname_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';

    echo '<div class="col-lg-4">';
    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="vrsionprice_spn" style="text-align: left;">Price   </span>';
    echo $this->Form->input("Version.price", array(
        "class" => 'form-control text-box-dark',
        "placeholder" => "Cost",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "vrsionprice_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';


    echo '<div class="col-lg-4">';
    echo '<li style="margin-top: 15px;display: inline-block;"><span class="col_checkbox">';
    echo $this->Form->checkbox(
        "Version.available",
        array(
            'class' => "css-checkbox1",
            'style' => "float: left",
            "value" => "active",
            "checked" => false,
            "hiddenField" => " "
        ));
    echo '<label for="VersionAvailable" class="css-label1" style="float: left;"></label>';
    echo '<label>Activate product version?</label> ';
    echo '</span></li>';
    echo '</div>';

    echo $this->Form->hidden(
        "Version.product_id",
        array(
            'secure' => true,
            'value' => $productId
        ));

    echo '<br />';
    echo '<br />';

    echo '<div class="col-lg-5" style="margin-top: 15px;">';
    echo '<div  class="input-group input-group-lg">';
    echo $this->Form->input("Version.description", array(
        "type" => "textarea",
        "class" => 'form-control text-box-dark',
        "placeholder" => " description",
        'div' => false,
        'label' => false,
        'error' => false,
        'row' => "50",
        'cols' => "250",
        'rows' => "6",
        'style' => "margin: 0px; height: 259px;",
        "aria-describedby" => "vrsiondescription_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';


    echo '<div class="col-lg-5" style="margin-top: 15px;" >';
    echo '<div  class="input-group input-group-lg">';
    echo $this->Form->input("Version.product_description_type", array(
        "type" => "textarea",
        "class" => 'form-control text-box-dark',
        "placeholder" => "name:value;name:value;",
        'div' => true,
        'label' => false,
        'error' => false,
        'row' => "50",
        'cols' => "230",
        'rows' => "6",
        'data-toggle' => "tooltip",
        'data-placement' => "top",
        'title' => 'fees: $25/per month; number of users : 50 users; mobile support: yes; automatic updates : yes; free tickets : 3',
        //'style' => "margin: 0px; width: 603px; height: 259px;",
        "aria-describedby" => "versionprdctdescriptiontype_spn",
        "required" => true
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
    ));
$this->Html->scriptBlock(
    ' $(function () { $(\'[data-toggle="tooltip"]\').tooltip()})',
    array("inline" => false));
    ?>
</div>
