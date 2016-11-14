<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 5/25/2016
 * Time: 9:31 PM
 */

?>
<!----start-footer--->


<div class="footer <?php if (isset($footerAlignment) && $footerAlignment == "fixed") { echo "navbar-fixed-bottom";}?> ">
    <div class="container">
        <div class="row">
            <div class="col-md-6 footer-left">
                <ul>
                    <li><a href="#">
                            <?php echo $this->Html->image("footer-logo.png", array("title"=>"logo")); ?>
                        </a>
                    </li>
                    <li><p> thanks <a href="http://w3layouts.com/">W3layouts</a> for this template</p></li>
                </ul>
            </div>
            <div class="col-md-6 footer-right">
                <ul>
                    <li><a class="twitter" href="#"><span> </span></a></li>
                    <li><a class="facebook" href="#"><span> </span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!----//End-footer--->