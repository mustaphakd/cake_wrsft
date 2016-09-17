<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 7/30/2016
 * Time: 5:10 PM

<tr> <th scope="row">2</th> <td>Column content</td> <td>Column content</td> <td>Column content</td>

 */ ?>

<fieldset>
    <legend> Products</legend>
</fieldset>
<?php if(isset($products)) : ?>
    <table class="table table-condensed table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Product name</th>
            <th>Description</th>
            <th>Announced Availability</th>
            <th>Version Count</th>
            <th># of Licences</th>
            <th>Commands</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($products as &$product) :
            ?>
            <tr>
                <th scope="row"><?php echo $counter++ ?></th>
                <td><?php echo $product['name'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td><?php echo $product['announced_date'] ?></td>
                <td><?php echo isset($product['Version']) ? count($product['Version']) : 0 ?></td>
                <td><?php echo $product['LicenseCount']  ?></td>
                <td>
                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Products", "action" => "view","admin" => true, $product['id'])); ?>">Detail</a>
                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Products", "action" => "edit","admin" => true, $product['id'])); ?>">Edit</a>
                   <!-- <?php

                           $dateTIme = new DateTime('now', new DateTimeZone('UTC'));
                   if ($product['announced_date'] >  $dateTIme):

                       ?>
                        <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Products", "action" => "delete", "admin" => true, $product['id'])); ?>">Delete</a>
                    <?php endif ?> -->
                </td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>

    <?php
    echo '<div class="col-lg-offset-3">';
    echo $this->Paginator->numbers(array('first' => 1, 'last' => 1, 'modulus' => 5));
    echo '</div>';
    ?>
<?php  endif ?>

<div class="clearfix"> </div>
<a class="btn btn-block btn-primary" href="<?php echo $this->Html->url(array("controller" => "Products", "action" => "Add", "admin" => true)); ?>"> Add new Product</a>
<br />