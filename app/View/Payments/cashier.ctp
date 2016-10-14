<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 9/20/2016
 * Time: 12:43 PM
 */

?>

<div class="payment-online-form-left">
    <?php
    echo $this->Form->create(null, array("admin" => false, "controller" => "payments", "action" => "checkout", "url" => array("controller" => "payments")));
    echo '<fieldset>';
    echo    '<legend>Cashier Front Queue: <strong>'. $this->request->data['Cashier']['title'].'</strong></legend>'
        .'<br /><br />'
        . '<div class="col-lg-offset-2 col-lg-6">'


        .'<div class="row">';
    echo $this->Form->label(
        'Cashier.description',
        'Description' ,
        array(
            'for' => 'cashier-description',
            "aria-describedby" => "cashierdesc_spn",
        ));
    echo '<div class="input-group input-group-lg">';
    echo $this->Html->tag(
        'p',
        $this->request->data['Cashier']['description'],
        array(
            'id' => 'cashier-description',
            'class' => 'input-group-lg'
        )
    );
    echo '</div>';
    //echo $this->Form->hidden('Cashier.description', array('secure' => false)); //, 'value' => $this->request->data['Cashier']['description'])
    echo '</div>';

    echo '<br />';
    echo '<br />';


    echo '<div class="row">';
    echo $this->Form->label(
        'Cashier.price',
        'Price' ,
        array(
            'for' => 'cashier-price',
            "aria-describedby" => "cashierprix_spn",
        ));
    echo '<div class="input-group input-group-lg">';
    echo $this->Html->tag(
        'p',
        $this->request->data['Cashier']['price'],
        array(
            'id' => 'cashier-price',
            'class' => 'input-group-lg'
        )
    );
    echo '</div>';
    echo $this->Form->hidden('Cashier.price', array('secure' => false)); //, 'value' => $this->request->data['Cashier']['description'])
    echo '</div>';

    echo '<br />';
    echo '<br />';



    echo '<div class="row">';
    echo '<div  class="input-group input-group-md">'
        .'<span class="input-group-addon" id="cashierduration_spn" style="text-align: left;">Duration in months  </span>';
    echo $this->Form->input("Cashier.duration", array(
        "type" => "number",
        "class" => 'form-control text-box-dark large-input',
        "placeholder" => "Number of months",
        'div' => false,
        'label' => false,
        'error' => false,
        "aria-describedby" => "cashierduration_spn",
        "required" => true
    ));
    echo '</div>';
    echo '</div>';

    echo '<br />';
    echo '<br />';

    echo '<div class="row">';
    echo '<div  class="input-group input-group-md">'
        .'<span class="input-group-addon" id="cashiertotal_spn" style="text-align: left;">Total  </span>';
    echo $this->Form->input('Cashier.total1', array(
        "type" => "number",
        "class" => 'form-control text-box-dark large-input',
        "placeholder" => "Total is automatic",
        'div' => false,
        'label' => false,
        'disabled' => true,
        'error' => false,
        "aria-describedby" => "cashiertotal_spn",
        "required" => true
    ));
    echo '<span id="spnCurrency" class="spn-currency"></span></div>';
    echo $this->Form->hidden('Cashier.total', array('secure' => false));
    echo '</div>';



    echo '</div>';
    echo '</fieldset>';

    echo $this->Form->end(array(
        "label" => "Checkout",
        "div" => "row",
        "before" => '<ul class="payment-sendbtns list-unstyled">'.
        '<li><a style="margin-right: .02em;border-radius:0px;" class="btn btn-block btn-primary" href="'.
            $this->request->referer()
            .'"> Cancel</a></li>'
        .'<li style="margin-left:5px;">',
        "after" => '</li></ul><div class="clearfix"> </div>'
    ))

    ?>
    <script>
        $(document).ready(function() {
            cashierTotalObserver()
        });
    </script>
</div>