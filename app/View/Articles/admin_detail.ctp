<?php
/**
 * Created by PhpStorm.
 * User: musta
 * Date: 11/15/2016
 * Time: 11:01 PM
 */

?>
<?php if(isset($article)) : ?>
    <fieldset>
        <h4>Article: <?php echo $article['title'] ?> </h4>

        <?php

        $imageSrc = Router::url(array(
            "controller" => "filesystem",
            "action" => "image",
            "admin" => false
        )) . $article['image_path'];
        ?>

        <div class=" col-lg-offset-1 col-lg-10">
            <div class="col-lg-3"><img src="<?php echo $imageSrc ?>" style="width:255px; height:297px"> </div>

            <div class=" col-lg-8">
                <dl class="dl-horizontal">
                    <dt>Id</dt>
                    <dd><?php echo $article['id'] ?></dd>
                    <dt>Created</dt>
                    <dd><?php echo $article['created'] ?></dd>
                    <dt>Creator (User Name)</dt>
                    <dd><?php echo $user['username'] ?></dd>
                    <dt>Enabled</dt>
                    <dd><?php echo $article['enabled'] ?  "Enabled" : "Not enabled" ?></dd>
                    <dt>Content</dt><dd><br />
                    <?php echo $article['content'] ?></dd>
                    <dt>Edit</dt>
                    <dd>
                        <a title="Edit article" href="<?php echo $this->Html->url(array("controller" => "articles", "action" => "edit","admin" => true, bin2hex($article['id']))); ?>">Edit</a>
                    </dd>
                </dl>
            </div>
        </div>
    </fieldset>
<?php endif ?>
<?php
if (isset($backlink))
    echo '<input type="hidden" name="backlink_articleDetail" value="' . $backlink  .'">';
?>
<div class="clearfix"> </div>
<a class="btn btn-block btn-primary" href="<?php if (isset($backlink)) { echo $backlink; }   ?>"> < Go Back</a>
<br />