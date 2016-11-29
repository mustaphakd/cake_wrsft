<?php
 //$this->layout = "entrance";


$recaptchaHelper = $this->Helpers->load('ReCaptcha', array('publicKey' => Configure::read('reCaptcha.publicKey')));
$this->ReCaptcha->generateScriptTagOnloadCallback('recaptcha'); //

$this->Html->script(
    array("vendors/shim.min.js","vendors/reflect.js", "vendors/system.src.js", "vendors/zone.js", "articles/systemjs.config.js"),
    array("block" => "script"));
$this->Html->script(
    array("https://rawgit.com/web-animations/web-animations-js/master/web-animations.min.js"),
    array("block" => "script"));

$latestEndpoint = Router::url(
    array(
        "controller" => "articles",
        "action" => "latest",
        "admin" => false
    ), true);
?>

<!-- start-container---->
<div class="bg">
    <!-- start-header---->
    <div class="container  header row">
        <div class="slide-banner">
            <div class="col-md-6">
                <!--start-logo---->
                <div class="well logo">
                    <a href="#"><?php echo $this->Html->image("woroIcon4.png", array(
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
<div class="top-grids" style="margin-bottom: -10%;">
    <?php echo '<my-art [endpoint]="'.$latestEndpoint.'" > </my-art>'; ?>
</div>
<!--//End-top-grids---->

<!----start-contact---->
<div class="contact">
    <div class="container">
        <p><i> </i></p>
        <div class="row">
            <?php

            echo $this->Form->create(null, array("admin" => false, "controller" => "Messages", "action" => "add", "url" => array("controller" => "messages")));

            ?>

            <div class="col-md-6 contact-text-box">

                <div>
                    <span id="messagename_spn">Title<label>*</label></span>
                    <?php
                    echo $this->Form->input("Message.title", array(
                        "placeholder" => "Provide a title for your message",
                        'div' => false,
                        'label' => false,
                        'error' => false,
                        "aria-describedby" => "messagename_spn",
                        "required" => true
                    ));
                    ?>
                </div>
                <div>
                    <span id="messageemail_spn">Email<label>*</label></span>
                    <?php
                    echo $this->Form->input("Message.email", array(
                        "placeholder" => "Email",
                        'type' => "email",
                        'div' => false,
                        AuthComponent::user() === null ? : 'value' => AuthComponent::user("email"),

                        'label' => false,
                        'error' => false,
                        "aria-describedby" => "messageemail_spn",
                        "required" => true
                    ));
                    ?>
                </div>
            </div>

            <div class="col-md-6 contact-text-textarea">
                <div>
                    <span id="mesagebody_spn">Message<label>*</label></span>
                    <?php

                    echo $this->Form->input("Message.body", array(
                        "type" => "textarea",
                        "placeholder" => AuthComponent::user() === null ? "You must log in before being able to submit a message" : " message body",
                        'div' => false,
                        'label' => false,
                        'error' => false,
                      /*  'row' => "50",
                        'cols' => "250",
                        'rows' => "6",
                        'style' => "margin: 0px; height: 259px;",*/
                        "aria-describedby" => "mesagebody_spn",
                        "required" => true
                    ));

                    ?>
                </div>
                <!--<input class="btn btn-danger btn-lg" type="submit" Value="send" />-->
            </div>

            <div id="recaptcha"></div>

            <?php

            if (AuthComponent::user() !== null)
            echo $this->Form->end(array(
                "label" => "send",
                "div" => false,
                "class" => 'btn btn-danger btn-lg',
                "after" => '</div>'
            ))

             ?>
        </div>
    </div>
</div>
<?php $this->ReCaptcha->makeCallAfterFormEnd();

echo $this->Html-> scriptBlock(
    ' endpoint = "'. $latestEndpoint . '"'  , array("safe" => true, "defer" => false)  );

echo $this->Html->scriptBlock(
    '    
    autoBootstrap = true;
            System.import("woromedia/js/articles/main").catch(function(err){ 
                console.error(err)
                });
    ',
    array("safe" => true, "defer" => true) );
?>
<!----//End-contact---->