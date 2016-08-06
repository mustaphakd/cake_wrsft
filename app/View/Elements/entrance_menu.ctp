<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/23/2016
 * Time: 9:39 PM
 */
?>


<?php if (AuthComponent::user() === null): ?>

<div class="login-info well header-right">
    <i style="margin-left: 1.2em;">
        <a href="<?php echo $this->Html->url(array("controller" => "users", "action" => "register")); ?>">  Register</a>
    </i>
    <p><span> || </span>
        <i><a href="<?php echo $this->Html->url(array("controller" => "pages", "action" => "login")); ?>">Login</a> </i>
    </p>
</div>
<?php
else:
    echo '<div type="submit" class="btn btn-default"">';
    echo $this->element('auth_right_menu');
    echo '</div>';
endif;
?>
<!--//End-header-right--->