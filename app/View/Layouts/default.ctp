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
        "bootstrap.min.css","theme-style.css"
    ));
    echo $this->fetch('css');

    echo $this->Html->script(array("jquery.min.js", "bootstrap.min.js", "main.js"))
    ?>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css' >
    <link href='http://fonts.googleapis.com/css?family=Fauna+One' rel='stylesheet' type='text/css' >

    <?php
        echo $this->fetch('script');
    ?>
</head>
<body > <!-- data-spy="scroll" data-target=".navbar-fixed-top" -->
<?php echo $this->element('menu'); ?>
<div class="container">
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

   echo '</div>';
    echo $this->element(
        "footer",
        isset($this->footerOptions)?
            $this->footerOptions :
            array("footerAlignment" => "none"));

    echo $this->fetch('scriptBottom');
?>
</body>
</html>
