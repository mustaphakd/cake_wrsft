<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/23/2016
 * Time: 9:07 PM
 */
?>

<ul class="nav navbar-nav navbar-right">
    <li><a href="<?php echo $this->Html->url(array("controller" => "users", "action" => "register")); ?>"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
    <li><a href="<?php echo $this->Html->url(array("controller" => "pages", "action" => "login")); ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
</ul>