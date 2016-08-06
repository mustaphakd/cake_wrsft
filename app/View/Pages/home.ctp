<?php
 //$this->layout = "entrance";

?>

<!-- start-container---->
<div class="bg">
    <!-- start-header---->
    <div class="container  header row">
        <div class="slide-banner">
            <div class="col-md-6">
                <!--start-logo---->
                <div class="well logo">
                    <a href="#"><?php echo $this->Html->image("woroIcon.png", array(
                            "alt" => "Worosoft",
                            "title" => "Worosoft"
                        )); ?></a>
                </div>
                <!--//End-logo---->
            </div>
            <div class="slide-banner-left col-md-6">
                <span> </span>
                <h1>Excellence is a journey</h1>
                <p>Our solutions allow you to have more insight and better management of your business and provide great services to your clients </p>
                <!-- <p><a class="btn btn-primary btn-lg b-btn" href="#"> Read More</a></p> -->
            </div>
        </div>
    </div>
    <!-- //End-header---->
</div>

<!--start-top-grids---->
<div class="top-grids">
    <div class="container">
        <div class="top-grid-left col-md-3">
            <a href="#">
                <?php echo $this->Html->image("cola_leaf.png",
                    array( "class" => "img-responsive", "title" => "doc"));
                ?>
            </a>
        </div>
        <div class="top-grid-center col-md-7">
            <h2>Lorem ipsum dolor sit amet</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div class="top-grid-right col-md-2">
            <ul><!--
                <li><a href="#"><span class="icon1"> </span></a></li>
                <li><a href="#"><span class="icon2"> </span></a></li>-->
                <div class="clearfix"> </div>
            </ul>
        </div>
    </div>
</div>
<!--//End-top-grids---->

<!----start-contact---->
<div class="contact">
    <div class="container">
        <p><i> </i></p>
        <div class="row">
            <form>
                <div class="col-md-6 contact-text-box">
                    <div>
                        <span>Name<label>*</label></span>
                        <input type="text" required/>
                    </div>
                    <div>
                        <span>Email<label>*</label></span>
                        <input type="text" required/>
                    </div>
                </div>
                <div class="col-md-6 contact-text-textarea">
                    <div>
                        <span>Message<label>*</label></span>
                        <textarea> </textarea>
                    </div>
                    <input class="btn btn-danger btn-lg" type="submit" Value="send" />
                </div>
            </form>
        </div>
    </div>
</div>
<!----//End-contact---->