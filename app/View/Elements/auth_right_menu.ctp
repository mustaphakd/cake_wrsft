<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/23/2016
 * Time: 9:08 PM
 */

$rolesHelper = $this->Helpers->load("Roles");
$auth = AuthComponent::user();
?>

<ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo AuthComponent::user()['username']; ?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo $this->Html->url(array("admin" => false, "controller" => "licenses", "action" => "")); ?>"> Licences</a></li>
            <li><a href="<?php echo $this->Html->url(array("admin" => false, "controller" => "products", "action" => "download")); ?>"> Downloads</a></li>
            <li><a href="<?php echo $this->Html->url(array("admin" => false, "controller" => "payments", "action" => "history")); ?>"> Transaction History</a></li>

            <?php if( isset($auth) && isset($auth['Role'])  && $rolesHelper->isUserInRoles($auth['Role'], array("admin", "manager", "support"))):  ?>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo $this->Html->url(array("admin" => true, "controller" => "articles", "action" => "index")); ?>"> Articles</a></li>
            <?php endif ?>

            <li role="separator" class="divider"></li>
            <li><a href="<?php echo $this->Html->url(array("admin" => false, "controller" => "users", "action" => "logout")); ?>"><span class="glyphicon glyphicon-log-out"></span> LogOff</a></li>
        </ul>
    </li>
</ul>