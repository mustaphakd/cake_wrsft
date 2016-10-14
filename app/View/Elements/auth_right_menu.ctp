<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/23/2016
 * Time: 9:08 PM
 */

?>

<ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo AuthComponent::user()['username']; ?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo $this->Html->url(array("controller" => "licenses", "action" => "")); ?>"> Licences</a></li>
            <li><a href="<?php echo $this->Html->url(array("controller" => "products", "action" => "download")); ?>"> Downloads</a></li>
            <li><a href="<?php echo $this->Html->url(array("controller" => "payments", "action" => "history")); ?>"> Transaction History</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo $this->Html->url(array("controller" => "users", "action" => "logout")); ?>"><span class="glyphicon glyphicon-log-out"></span> LogOff</a></li>
        </ul>
    </li>
</ul>