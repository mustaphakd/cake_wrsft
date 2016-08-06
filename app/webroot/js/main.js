/**
 * Created by Mustapha on 5/27/2016.
 */

function controlsValueMatch(element , deuxieme)
{
    debugger;
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
