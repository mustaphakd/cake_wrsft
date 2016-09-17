<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/15/2016
 * Time: 11:07 PM
 */

?>
<nav class="navbar navbar-default" >
        <div class="container-fluid">
            <div class="navbar-header">
                <?php
                echo $this->Html->link(
                    $this->Html->image("woroIcon.png", array(
                        "alt" => "Worosoft",
                        "title" => "Worosoft",
                        "style" => "width: 50px"
                    )),
                    array("controller" => "pages", "action" => "index", "admin" => false),
                    array("escapeTitle" => false));
                ?>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-tsarget" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="#">

                </a> -->

            </div>

            <!-- Collect the nav links, forms, and other content for toggling class="active"-->
            <div class="collapse navbar-collapse" id="main-tsarget">
                <ul class="nav navbar-nav">
                    <li ><a href="<?php echo $this->Html->url(array("patron" => false, "admin" => false, "controller" => "products", "action" => "index")); ?>"> Products</a></li>
                    <li><a href="<?php echo $this->Html->url(array("patron" => false, "admin" => false, "controller" => "Forums", "action" => "index")); ?>"> Forums</a></li>
                </ul>
               <!-- <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form> -->

                <?php

                if (AuthComponent::user() === null) {
                    echo $this->element('anonym_right_menu');
                }else {
                    //show admin links
                    echo $this->element('admin_menu');
                    echo $this->element('auth_right_menu');
                }



                     //include external view containing links
                     ?>

                    <?php
                    /*
                    admin link logic
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <b>Admin</b> <span class="caret"></span></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>@Html.ActionLink("Administer Merchandises", "Index", "Merchandise")</li>
                                                    <li>@Html.ActionLink("Users & Activity", "Index", "UserActivity")</li>
                                                    <li>@Html.ActionLink("Competitions Overview", "Index", "Competition")</li>
                                                    <li>@Html.ActionLink("Matches Overview", "Index", "Match")</li>
                                                    <li>@Html.ActionLink("BetaSignUp Overview", "List", "BetaSignUp")</li>
                                                    <li>@Html.ActionLink("Log Overview", "Index", "Log", new { id = DateTime.UtcNow.Date.ToString("yyyyMMdd") }, null)</li>
                                                    <li>@Html.ActionLink("Feature Dashboard", "Index", "FeatureDashboard")</li>
                                                    <li>@Html.ActionLink("Stats DashBoard", "Index", "DashBoard", new { id = DateTime.UtcNow.Date.ToString("yyyyMMdd") }, null)</li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>@Html.ActionLink("Registration Keys", "Generate", "Administration")</li>
                                                    <li>@Html.ActionLink("Generate Competitions", "Generate", "Administration")</li>
                                                </ul>
                                            </li> */
                    ?>


                    <?php
                    //user detail links
                    ?>
            </div>
        <!-- /.navbar-collapse -->
        </div>
<!-- /.container -->
</nav>