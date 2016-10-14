<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 9/20/2016
 * Time: 10:20 AM
 */
?>

<fieldset>
    <legend> Licenses</legend>
</fieldset>
<?php
    echo '<div class="row">';
    echo '    <div class="col-lg-offset-3 col-md-6">';

    echo '      <a class="btn btn-block btn-primary" href="'.
        $this->Html->url(array("controller" => "Licenses", "action" => "inventory", "admin" => false)) .
                '"> Purchase a license</a>';


    echo '    </div>';
    echo '</div>'; // row end
 if(isset($licenses)) : ?>
    <table class="table table-condensed table-hover">
        <thead>
        <tr>
            <th>License #</th>
            <th>Product name</th>
            <th>Version</th>
            <th>Product version description</th>
            <th>Expiration date</th>
            <th>Last payment date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($licenses as &$license) : ?>
            <tr>
                <th scope="row"><?php echo $license['license_id'] ?></th>
                <td><?php echo $license['product_name'] ?></td>
                <td><?php echo $license['product_version'] ?></td>
                <td><?php echo $license['product_description'] ?></td>
                <td><?php echo $license['license_expiration'] ?></td>
                <td><?php echo $license['last_payment'] ?></td>
               <!-- <td> command to view details ;;> licenseFrames
                    <?php if ($license['viewed'] == true):  ?>
                        <a title="read" href="<?php echo $this->Html->url(array("controller" => "messages", "action" => "view","admin" => true, $license['id'])); ?>"><span class="glyphicon glyphicon-envelope"></span></a>
                    <?php else: ?>
                        <a title="unread" href="<?php echo $this->Html->url(array("controller" => "messages", "action" => "view","admin" => true, $license['id'])); ?>"><span class="glyphicon glyphicon-envelope" style="color: rgb(66, 202, 139)"></span></a>

                    <?php  endif ?>
                </td>-->

            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
    <?php
    echo '<div class="col-lg-offset-3">';
    echo $this->Paginator->numbers(array('first' => 1, 'last' => 1, 'modulus' => 5));
    echo '</div>';
    ?>
<?php else:

     echo '<h2><strong>You have not purchase any license!</strong></h2>';

     ?>
<?php endif ?>

<div class="clearfix"> </div>
<br />