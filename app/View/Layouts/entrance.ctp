<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>

    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->meta("viewport", "width=device-width, initial-scale=1");
    echo $this->fetch('meta');
    echo $this->Html->tag(
        "link",
        null,
        array(
            "rel" => "shortcut icon",
            "type" => "image/x-icon",
            "href" => $this->webroot ."img/favicon.png"));

    echo $this->Html->css(array(
        "bootstrap.css","bootstrap.min.css","theme-style.css"
    ));
    echo $this->fetch('css');

    echo $this->Html->script(array("jquery.min.js", "bootstrap.min.js"))
    ?>



    <script type="application/x-javascript">
        addEventListener("load",
            function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
    </script>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css' >
    <link href='http://fonts.googleapis.com/css?family=Fauna+One' rel='stylesheet' type='text/css' >

    <?php
        echo $this->fetch('script');
    ?>
</head>
<body>
<!-- start-bg---->
<div class="bg">
    <!-- start-container---->
    <div class="container">
        <!-- start-header---->
        <div class="row header">
            <div class="row">
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
                <div class="well col-md-6">
                    <?php echo $this->element('entrance_menu'); ?>
                </div>
            </div>
        </div>
        <!-- //End-header---->
        <!--slide-banner---->
        <div class="well slide-banner row">
            <div class="slide-banner-left col-md-8">
                <span> </span>
                <h1>Excellence is a journey</h1>
                <p>Our solutions allow you to have more insight and better management of your business and provide great services to your clients </p>
                <!-- <p><a class="btn btn-primary btn-lg b-btn" href="#"> Read More</a></p> -->
            </div>
            <div class="well slide-banner-right col-md-4">
                <?php echo $this->Html->image("slider-img.png", array("class" => "img-responsive",  "alt" => "")); ?>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!--//slide-banner---->
    </div>
</div>

<?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>
<!-- start-add-light-box-script---->
<!-- Add fancyBox light-box -->
<?php
    echo $this->Html->script("jquery.magnific-popup.js", array("inline" => false, "defer" => "true"));
    $this->Html->scriptBlock("
    $(document).ready(function() {
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });
    });",
        array("inline" => false));

    echo $this->element("footer");

?>
</body>
</html>
