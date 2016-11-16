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
            "action" => "retrieve_imaage",
            "admin" => false
        ));
        ?>

        <div class="col-lg-12">
            <div class="col-lg-5"><img src="<?php echo $imageSrc ?>" style="width: 140px; height: 140px;"> </div>

            <div class=" col-lg-offset-1 col-lg-6">
                <dl class="dl-horizontal">
                    <dt>Id</dt>
                    <dd><?php echo $article['id'] ?></dd>
                    <dt>Created</dt>
                    <dd><?php echo $article['created'] ?></dd>
                    <dt>Enabled</dt>
                    <dd><?php echo $article['enabled'] ?  "Enabled" : "Not enabled" ?></dd>
                    <dt>Content</dt><dd></dd>
                    <?php echo $article['content'] ?>
                    <dt>Edit</dt>
                    <dd>
                        <a title="Edit article" href="<?php echo $this->Html->url(array("controller" => "articles", "action" => "edit","admin" => true, $article['id'])); ?>">Edit</a>

                    </dd>
                </dl>
            </div>
        </div>
    </fieldset>
<?php endif ?>

<div class="clearfix"> </div>
<a class="btn btn-block btn-primary" href="<?php if (isset($backlink)) { echo $backlink; }   ?>"> < Go Back</a>
<br />