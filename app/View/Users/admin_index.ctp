<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 7/30/2016
 * Time: 5:10 PM

<tr> <th scope="row">2</th> <td>Column content</td> <td>Column content</td> <td>Column content</td>

 */ ?>

<fieldset>
    <legend> Registered Users</legend>
</fieldset>
<?php if(isset($users)) : ?>
    <table class="table table-condensed table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>User name</th>
            <th>Email</th>
            <th>Registered since</th>
            <th>Active</th>
            <th>Confirmation date</th>
            <th>Commands</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($users as &$user) :
            ?>
            <tr>
                <th scope="row"><?php echo $counter++ ?></th>
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['created'] ?></td>
                <td><?php echo  $user['active'] == false ? "false" : "true" ?></td>
                <td><?php echo $user['confirmed'] ?></td>
                <td>
                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "detail","admin" => true, $user['id'])); ?>">Detail</a>
                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "edit","admin" => true, $user['id'])); ?>">Edit</a>
                    <?php if ($user['active'] == false): ?>
                        <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "delete", "admin" => true, $user['id'])); ?>">Delete</a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
<?php  endif ?>

<div class="clearfix"> </div>
<a class="btn btn-block btn-primary" href="<?php echo $this->Html->url(array("controller" => "Users", "action" => "Add", "admin" => true)); ?>"> Add new User</a>
<br />