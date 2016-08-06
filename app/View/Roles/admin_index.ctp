<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 7/30/2016
 * Time: 5:10 PM

<tr> <th scope="row">2</th> <td>Column content</td> <td>Column content</td> <td>Column content</td>

 */ ?>

<fieldset>
    <legend> Roles List</legend>
</fieldset>
<?php if(isset($roles)) : ?>
    <table class="table table-condensed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>User Count</th>
                <th>Commands</th>
            </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($roles as &$role) : ?>
            <tr>
                <th scope="row"><?php echo $counter++ ?></th>
                <td><?php echo $role['name'] ?></td>
                <td><?php echo $role['count'] ?></td>
                <td>
                    <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Roles", "action" => "Edit","admin" => true, $role['id'])); ?>">Edit</a>
                    <?php if ($role['count'] == 0): ?>
                        <a class="btn" href="<?php echo $this->Html->url(array("controller" => "Roles", "action" => "Delete", "admin" => true, $role['id'])); ?>">Delete</a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
<?php endif ?>

<div class="clearfix"> </div>
<a class="btn btn-block btn-primary" href="<?php echo $this->Html->url(array("controller" => "Roles", "action" => "Add", "admin" => true)); ?>"> Add new Role</a>
<br />