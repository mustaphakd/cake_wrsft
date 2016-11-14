/**
 * Created by Mustapha on 5/27/2016.
 */

function controlsValueMatch(element , deuxieme)
{
    //debugger;
    var firstVal = element.value;
    var secondVal = deuxieme.value;

    if(firstVal != secondVal)
    {
        if (secondVal.length > 0)
        {
            deuxieme.setCustomValidity("Passwords Don't Match");
        }
    }
    else
        deuxieme.setCustomValidity('');
}




function cashierTotalObserver() {

    var observer = $('#CashierTotal1')[0]
    var observee = $('#CashierDuration')[0]
    var price = $('#cashier-price')[0]

    var unitPrice = price.textContent

    observer.value = Number.parseInt(observee.value) * Number.parseInt(unitPrice)
    $('#CashierTotal')[0].value = observer.value

    var currency = unitPrice.replace(Number.parseInt(unitPrice), '');
    $('#spnCurrency')[0].textContent = currency;




    observee.onchange = function(e){  //memo: leaks memory. keep reference to outer function scope. thus keep outer function alive

        var val = Number.parseInt(observee.value)
        if (val <= 0){
            observee.value = 1
            val = 1
        }
        observer.value = val * Number.parseInt(price.textContent)
        $('#CashierTotal')[0].value = observer.value
    }



}