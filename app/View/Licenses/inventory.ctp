<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 9/20/2016
 * Time: 7:18 AM
 *
 * todo: future revision should display product image & name + version description. And not product description.
 */
//$this->footerOptions = array("footerAlignment" => "fixed");
echo '<div class="payment-online-form-left">';
$counter = 0;
if (isset($versions) && !empty($versions)){

 foreach($versions as $version){
       if ($counter == 0){
           echo '<div class="row" >';
       }
       echo '<div class="col-md-4" >';
       echo '    <h2><small>'. $version['Product']['name']  .'</small></h2>';
       echo '    <dl class="dl-horizontal">';
       echo '        <dt>Version</dt>';
       echo '        <dd>'. $version['Version']['name'] .'</dd>';
       echo '        <dt>Monthly Cost</dt>';
       echo '        <dd>'. $version['Version']['price'] .'</dd>';
       echo '        <span>'. $version['Version']['description'] .'</span>';
       echo '    </dl>';
       echo $this->Form->create(null, array('admin' => false));
       echo $this->Form->hidden(
           'Version.id',
           array(
               'value' => bin2hex($version['Version']['id']),
               'secure' => false
       ));
       echo $this->Form->end(array(
           "label" => "Purchase",
           "div" => false,
           "before" => '<ul class="payment-sendbtns list-unstyled"><li>',
           "after" => '</li></ul>' //<div class="clearfix" ></div>
       ));
       echo '</div>';
       unset($version);

       if ($counter == 2){
           echo '</div>';
           $counter = -1;
       }
       $counter++;
   }
}else{
    echo '<div class="col-md-6" >';
    echo    '<strong><span class="label label-primary"> There is not any product available at the moment.</span><strong>';
    echo '</div>';
}
if ($counter != 0){
    echo '</div>';
}
echo '</div>' ;
echo '<div class="clearfix" ></div> <br /><div style="margin-bottom: 10px;"></div>';