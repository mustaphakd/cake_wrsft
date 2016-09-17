<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 8/31/2016
 * Time: 6:49 PM
 */
 ?>
<?php if(isset($message)) : ?>
<fieldset>
    <?php $heading =  $message['User']['username'] . "\u003c " . $message['email'] . ">," ; ?>
    <legend> From: <?php echo $heading . '<span class="col-lg-offset-2"></span>  ' ?> Subject: <?php echo $message['title'] ?> </legend>
    <br />Sent: <?php echo $message['date_sent'] . '<span class="col-lg-offset-1"></span>  ' ?> <small>confirmation#: <b><?php echo $message['confirmation'] ?></b></small>


    <table class="table table-condensed table-hover">
        <tbody>
            <tr>
                <td>
                    <?php echo $message['body'] ?>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>
<?php endif ?>

<div class="clearfix"> </div>
<a class="btn btn-block btn-primary" href="<?php if (isset($backlink)) { echo $backlink; }   ?>"> < Go Back</a>
<br />