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
<body >
<div class="container">
    <?php echo $this->fetch('content'); ?>

<?php

   echo '</div>';
    echo $this->element(
        "footer",
        isset($this->footerOptions)?
            $this->footerOptions :
            array("footerAlignment" => "fixed"));
?>
</body>
</html>
