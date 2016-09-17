<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 9/3/2016
 * Time: 7:07 PM
 */
?>

<div class="pricetables">
    <div class="container">
        <div class="pricetables-head">
            <h2><?php echo $product["name"] ?></h2>
            <p><?php echo $product["description"] ?></p>
        </div>
        <?php

        $num_diff_versions = 0;
        $col_lg_offset = "col-md-offset-4";

        if (isset($product['Version']) && is_array($product['Version']) && !empty($product['Version'])){

            $num_diff_versions = count($product['Version']);

            if ($num_diff_versions == 2){
                $col_lg_cls = "col-md-offset-2";
            }elseif ($num_diff_versions > 2) {
                $col_lg_cls = "col-md-offset-0";
            }

            $counter = 0;

            foreach ($product["Version"] as $version) {

                $wrapperDivClass = null;

                if ($counter == 0){
                    $wrapperDivClass = $col_lg_cls . " col-md-4 pricetable";
                }
                else{
                    $wrapperDivClass = " col-md-4 pricetable pricetable" . $counter;
                }

                $product_description_type = explode(';', $version["product_description_type"]);

                echo '<div class="' . $wrapperDivClass . '">';
                echo '<h3>'. $version["name"] .'</h3>';
                //echo '<span> </span>'; todo: add column to version to decide if version has featured mark
                echo '<ul>';
                $attribute_counter = 0;
                foreach($product_description_type as $attribute) {
                    $tokens = explode(':', $attribute);
                    $str = '<li ><a ' . ($attribute_counter == 0 ? 'class="frist-fea"' : '') .
                        ' href = " " > '. ($attribute_counter != 0 ? (trim($tokens[0]) . ": " . trim($tokens[1]))  : trim($tokens[1]))  .'</a ></li >';
                    echo $str;
                    $attribute_counter++;
                }
                echo '</ul>';

                if(AuthComponent::user() === null){
                    echo "Please login to access download";
                }else {

                    if ($version["available"] == true) { //todo: fix version[available] for version creation and update
                        echo '<a class="price-btn1" href="' .
                            $this->Html->url(array($version['download_id'], "admin" => false, "controller" => "products", "action" => "download"))
                            . '" target="new" >Download</a>';
                    } else {
                        echo '<a class="price-btn1" href="#" >Not Available</a>';

                    }
                }
                echo '</div>';
                $counter++;
            }
        }
        ?>
    </div>
</div>