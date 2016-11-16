<?php
/**
 * Created by PhpStorm.
 * User: musta
 * Date: 11/15/2016
 * Time: 11:01 PM
 */

?>

<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(null, array("admin" => true, "controller" => "articles", "action" => "create", "url" => array("controller" => "articles")));
    echo '<fieldset>';
    echo    '<legend>Article Creation Form</legend>'
        . '<div class="row">'

        .'<div class="col-lg-4">';
    echo '<div  class="input-group input-group-lg">'
        .'<span class="input-group-addon" id="artcletitle_spn" style="text-align: left;">Title   </span>';
    echo $this->Form->input("Article.title", array(
        "class" => 'form-control text-box-dark',
        "placeholder" => "Title",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "artcletitle_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';


/* echo '<div class=" col-lg-offset-2 col-lg-4 btn-group" data-toggle="buttons">';
    echo '<label class = "btn btn-primary active" >';

    $enabledOptions = array(
        "type" => "input",
        "class" => 'form-control text-box-dark',
        "autocomplete" => "off",
        'div' => false,
        'label' => false,
        'error' => false,
    );

    echo $this->Form->input("Article.enabled", $enabledOptions);
    echo '</label>';
    echo '</div>';*/

    $active =
        (isset($this->request->data['Article']) &&
        isset($this->request->data['Article']['enabled']) &&
        !empty($this->request->data['Article']['enabled']) &&
            $this->request->data['Article']['enabled'] != "false" &&
            $this->request->data['Article']['enabled'] != "0") ? "active" : "";
?>
    <div class="btn-group col-lg-4 " data-toggle="buttons">
        <label class="btn btn-primary btn-lg btn-block <?php echo $active ?>">
            <input type="hidden" name="data[Article][enabled]" id="ArticleEnabled_" value="0">
            <input name="data[Article][enabled]" type="checkbox" autocomplete="off" > Enabled
        </label>
    </div>

    <?php


/********************************************************/

    echo '<br />';
    echo '<br />';

    echo '<div class="col-lg-12">';

    $setNotNull = isset($this->request->data['Article']) && isset($this->request->data['Article']['image_path']) && !empty($this->request->data['Article']['image_path']);
    $imagepath = $setNotNull ? $this->request->data['Article']['image_path'] :     Router::url(array(
        'controller' => 'filesystem',
        'action' => "default_image",
        "admin" => false
    ), true);

    echo '<div class="col-lg-3" style="margin-top: 15px;">';
    echo '<input type="hidden" name="data[Article][image_path]" id="ArticleImage_Path_" value="' . $imagepath .'">';
    echo $this->Html->image($imagepath,
        array(
            'name' => "data[Article][image_path]",
            'alt' => 'image',
            'class' => "img-thumbnail imagemod",
            'style' => 'width:255px; height:297px'));
    echo '</div>';

    echo '<div class="col-lg-8" style="margin-top: 15px;">';
    echo $this->Form->input("Article.content", array(
        "type" => "textarea",
        "class" => 'form-control text-box-dark',
        "placeholder" => "content",
        'div' => false,
        'label' => false,
        'error' => false,
        'row' => "50",
        'cols' => "30",
        'rows' => "6",
        'style' => "margin: 0px; width: 603px; height: 259px;",
        "required" => true,
        "row" => 50
    ));
    echo '</div>';


    echo '</div>';


    echo '</div>';
    echo '</fieldset>';

    echo $this->Form->end(array(
        "label" => "Save",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled"><li><input style="margin-right: .02em;" type="reset" value="Reset"></li>'.'<li>',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
</div>