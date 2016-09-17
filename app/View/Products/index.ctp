<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 8/6/2016
 * Time: 4:31 PM
 */


$this->footerOptions = array("footerAlignment" => "fixed");
?>

<div class="top-grids">
    <div class="container">
        <?php if (isset($products)):
            foreach($products as $product) :

        ?>

        <div class="top-grid-center col-md-offset-1 col-md-7">
            <h2><?php echo $product["name"] ?></h2>
            <p><?php echo $product["description"] . " " ?>
                <a class="btn btn-block" href="<?php echo $this->Html->url(array($product['id'], "controller" => "Products", "action" => "view", "admin" => false, "manager" => false)); ?>">
                     Click here to find out more
                </a>
            </p>
        </div>

        <?php
            endforeach;
            endif
        ?>
    </div>
</div>

