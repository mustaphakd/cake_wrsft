<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 8/31/2016
 * Time: 6:48 PM
 */
?>

<fieldset>
    <legend> Messages</legend>
</fieldset>
<?php if(isset($messages)) : ?>
    <table class="table table-condensed table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Confirmation#</th>
            <th>Email</th>
            <th>Title</th>
            <th>Commands</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($messages as &$message) : ?>
            <tr>
                <th scope="row"><?php echo $counter++ ?></th>
                <td><?php echo $message['confirmation'] ?></td>
                <td><?php echo $message['email'] ?></td>
                <td><?php echo $message['title'] ?></td>
                <td>
                    <?php if ($message['viewed'] == true):  ?>
                        <a title="read" href="<?php echo $this->Html->url(array("controller" => "messages", "action" => "view","admin" => true, $message['id'])); ?>"><span class="glyphicon glyphicon-envelope"></span></a>
                    <?php else: ?>
                        <a title="unread" href="<?php echo $this->Html->url(array("controller" => "messages", "action" => "view","admin" => true, $message['id'])); ?>"><span class="glyphicon glyphicon-envelope" style="color: rgb(66, 202, 139)"></span></a>

                    <?php  endif ?>
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
<?php endif ?>

<div class="clearfix"> </div>
<br />