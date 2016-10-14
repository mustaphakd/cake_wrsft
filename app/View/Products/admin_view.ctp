<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 8/6/2016
 * Time: 1:03 PM
 */
?>

<div class="payment-online-form-left">

    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <h4>Product Info</h4>
                <dl class="dl-horizontal">
                    <dt>Id</dt>
                    <dd><?php echo $product['id'] ?></dd>
                    <dt>Name</dt>
                    <dd><?php echo $product['name'] ?></dd>
                    <dt>Announced availability</dt>
                    <dd><?php echo $product['announced_date'] ?></dd>
                    <dt>Description</dt>
                    <dd><?php echo $product['description'] ?></dd>
                </dl><?php

                $num_diff_versions = 0;
                $col_lg_cls = "col-md-12";

                if (isset($product['Version']) && is_array($product['Version']) && !empty($product['Version'])){
                    echo '<h2><small>Versions</small></h2>';
                    $num_diff_versions = count($product['Version']);

                    if ($num_diff_versions == 2){
                        $col_lg_cls = "col-md-6";
                    }elseif ($num_diff_versions > 2) {
                        $col_lg_cls = "col-md-4";
                    }
                }

                if ($num_diff_versions > 0) {

                    echo '<div class="row">';

                    foreach ($product['Version'] as $version) {
                        echo '<div class="'. $col_lg_cls .'">';
                        //echo '<div class="col-md-12">';
                        echo '<strong><span class="label label-primary">' . $version["name"] . '</span><strong>';?>

                        <dl class="dl-horizontal">
                            <dt>Id</dt>
                            <dd><?php echo $version['id'] ?></dd>
                            <dt>Description</dt>
                            <dd><?php echo $version['description'] ?></dd>
                            <dt>Availability</dt>
                            <dd><?php echo $version['available'] == true ? "Available" : "Not Available" ?></dd>
                            <dt>Plan</dt>
                            <dd><?php echo $version['product_description_type'] ?></dd>
                            <dt>Price</dt>
                            <dd><?php echo $version['price'] ?></dd>
                            <dt title="Number of Current Valid Licences">Number of Current Valid Licences</dt>
                            <dd>scheduled</dd>
                            <dt title="Number of Attributed Licences">Number of Attributed Licences</dt>
                            <dd>scheduled</dd>
                        </dl>

                        <div class="row">
                            <ul class="payment-sendbtns list-unstyled"><li>

                                <a class="btn btn-block btn-primary" href="<?php echo $this->Html->url(array($version['edit_id'],"admin" => true, "controller" => "products", "action" => "version_edit")); ?>"> Edit Version</a>
                            </li></ul><div class="clearfix"> </div>
                        </div>
                        <?php
                        echo '</div>'; //version end

                    }

                    if ($num_diff_versions < 3){
                        echo '<div class="col-lg-offset-3 col-md-6">'; ?>

                        <a class="btn btn-block btn-primary" href="<?php echo $this->Html->url(array($product['id'], "controller" => "Products", "action" => "version_add", "admin" => true)); ?>"> Add new Version</a>

                        <?php
                        echo '</div>';
                    }
                    echo '</div>'; // row end

                }
                else{
                    echo '<div class="row">';
                    echo '<div class="col-lg-offset-3 col-md-6">';

                    echo '<a class="btn btn-block btn-primary" href="'. $this->Html->url(array( $product['id'], "controller" => "Products", "action" => "version_add", "admin" => true)) .'"> Add new Version</a>';


                    echo '</div>';
                    echo '</div>'; // row end
                }

                echo $this->Form->create(null, array('type' => 'GET', "admin" => true, "controller" => "products", "action" => "edit", "productId" => $product['id'], "url" => array("controller" => "products", "productId" => $product['id'])));
                echo $this->Form->end(array(
                    "label" => "Edit Product",
                    "div" => "row",
                    "before" => '<ul class="payment-sendbtns list-unstyled"><li>',
                    "after" => '</li></ul><div class="clearfix"> </div>'
                ))
                ?>
            </fieldset>
        </div>
    </div>

</div>