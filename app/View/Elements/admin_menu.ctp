
<?php //if(isset(AuthComponent::user()['roles']) && in_array("admin", AuthComponent::user()['roles'])):
    ?>
    <ul class="nav navbar-nav">
<li><a href="<?php echo $this->Html->url(array("patron" => false, "admin" => true, "controller" => "Roles", "action" => "index")); ?>"> Roles</a></li>
<li><a href="<?php echo $this->Html->url(array("patron" => false, "controller" => "users", "action" => "index","admin" => true)); ?>"> Users</a></li>
<li><a href="<?php echo $this->Html->url(array("patron" => false, "controller" => "messages", "action" => "index","admin" => true)); ?>"> Messages</a></li>
<li><a href="<?php echo $this->Html->url(array("patron" => false, "controller" => "products", "action" => "index","admin" => true)); ?>"> Products</a></li>
    </ul>
<?php //endif
?>