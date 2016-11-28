<?php
/**
 * Created by PhpStorm.
 * User: musta
 * Date: 11/15/2016
 * Time: 11:00 PM
 */
?>

<fieldset>
    <legend> Articles</legend>
</fieldset>
<?php if(isset($articles)) : ?>
    <table class="table table-condensed table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Last Modified</th>
            <th>Enabled</th>
            <th>Commands</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($articles as &$article) : ?>
            <tr>
                <th scope="row"><?php echo $counter++ ?></th>
                <td><?php echo $article['title'] ?></td>
                <td><?php echo $article['modified'] ?></td>

                <?php
                    $bcgColor =  $article['enabled'] ? "green" : "red";
                ?>
                <td style="padding: 1px;"> <div style="width: 80%;height: 20px;background-color:<?php echo  $bcgColor ?> ">  </div>  </td>

                <td>
                    <a title="View detail" href="<?php echo $this->Html->url(array("controller" => "articles", "action" => "detail","admin" => true, $article['id'])); ?>"><span class="glyphicon glyphicon-floppy-open" style="color: rgb(66, 202, 139)"></span></a>
                    <span class="glyphicon" style="color: rgb(66, 202, 139)">|</span>
                    <a title="Edit article" href="<?php echo $this->Html->url(array("controller" => "articles", "action" => "edit","admin" => true, $article['id'])); ?>"><span class="glyphicon glyphicon-floppy-open" style="color: rgb(66, 202, 139)"></span></a>
                    <span class="glyphicon" style="color: rgb(66, 202, 139)">|</span>
                    <a title="Delete article" href="<?php echo $this->Html->url(array("controller" => "articles", "action" => "delete","admin" => true, $article['id'])); ?>"><span class="glyphicon glyphicon-remove" style="color: rgb(66, 202, 139)"></span></a>
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
<a class="btn btn-block btn-primary" href="<?php echo $this->Html->url(array("controller" => "articles", "action" => "create", "admin" => true)); ?>"> Add new Article</a>
<br />