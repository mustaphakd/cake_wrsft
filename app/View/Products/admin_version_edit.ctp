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
    if (isset($version)) :
        echo $this->Form->create(null, array("admin" => true, "url" => array("controller" => "products", "action" => "admin_version_edit", "versionId" =>$version['req_id'])));
        echo '<fieldset>';
        echo    '<legend>Product Version Edit Form</legend>'
            . '<div class="row">'
            .'<div class="col-lg-4">';


        echo '<div  class="input-group input-group-lg">'
            .'<span class="input-group-addon" id="vrsionname_spn" style="text-align: left;">Name   </span>';
        echo $this->Form->input("Version.name", array(
            "class" => 'form-control text-box-dark',
            "placeholder" => "Product Version name",
            "value" => $version["name"],
            'div' => false,
            'label' => false,
            'error' => false,
            "aria-describedby" => "vrsionname_spn",
            "required" => true
        ));
        echo '</div>';
        echo '</div>';

        echo $this->Form->hidden(
            "Version.product_id",
            array(
                'secure' => true,
                'value' => $version['product_id']
            )
        );

        echo $this->Form->hidden(
            "Version.path",
            array(
                'secure' => false,
                'value' => $version['path']
            )
        );

        echo $this->Form->hidden(
            'nukk',
            array(
                'secure' => false,
                'value' => $version['req_id'],
                'id' => 'reqid'
            )
        );

        echo $this->Form->hidden(
            "hiddends",
            array(
                'secure' => false,
                'value' => DS
            )
        );

        echo '<div class="col-lg-4">';
        echo '<div  class="input-group input-group-lg">'
            .'<span class="input-group-addon" id="vrsionprice_spn" style="text-align: left;">Price   </span>';
        echo $this->Form->input("Version.price", array(
            "class" => 'form-control text-box-dark',
            "placeholder" => "Cost",
            "value" => $version["price"],
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
                /*"value" => "active",*/
                "checked" => $version['available'] == true ? true : false ,
                "hiddenField" => " "
            ));
        echo '<label for="VersionAvailable" class="css-label1" style="float: left;"></label>';
        echo '<label>Activate product version?</label> ';
        echo '</span></li>';
        echo '</div>';

        echo '<br />';
        echo '<br />';


        echo '<div class="col-lg-12">'; //text area wrapper

        echo '<div class="col-lg-5" style="margin-top: 15px;">';
        echo '<div  class="input-group input-group-lg">';
        echo $this->Form->input("Version.description", array(
            "type" => "textarea",
            "class" => 'form-control text-box-dark',
            "placeholder" => " description",
            "value" => $version["description"],
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
            "value" => $version["product_description_type"],
            'div' => true,
            'label' => false,
            'error' => false,
            'row' => "50",
            'cols' => "230",
            'rows' => "6",
            //'style' => "margin: 0px; width: 603px; height: 259px;",
            "aria-describedby" => "versionprdctdescriptiontype_spn",
            "required" => true
        ));
        echo '</div>';
        echo '</div>';

        echo '</div>'; //end text area wrappers

        echo '<div class=" col-lg-offset-3 col-md-6">';
        echo '<a class="btn btn-block btn-primary" data-ds="'. DS .'" data-pathTarget="#VersionPath" data-path="' . $version['path']  .'" data-manageMedia="launch" href="#"> Upload installer</a>'; //$version['path']
        echo '</div>';

        echo '</div>'; // end row
        echo '</fieldset>';

        echo $this->Form->end(array(
            "label" => "Save",
            "div" => "row",
            "before" => '<ul class="payment-sendbtns list-unstyled"><li>'.
                '<a class="btn btn-block btn-primary" href="' . $backlink .'"> Cancel</a>'
                .'<li>',
            "after" => '</li></ul><div class="clearfix"> </div>'
        ));
    endif;

   // $this->Html->scriptStart(array("safe" => true));

    echo $this->Html->scriptBlock("
         +function($){
                $(document).on('click.' + 'wrsft.mediaview.data-api', '[data-manageMedia=launch]', function(e){
                    var source = $(e.target)
                    source.is('a') && e.preventDefault()
                    source.mediaview('show')
                })
            }(jQuery);",
        array("inline" => true));
   // $this->Html->scriptEnd();

    $this->Html->script('mediaview.js', array('block' => 'scriptBottom'));
    ?>
</div>