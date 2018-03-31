//....................... Loading page onclick link or button -----------------------------
function onclick_loadimg() {
    document.getElementById("loader").style.display = "block"; 
    setTimeout(function(){
        document.getElementById("loader").style.display = "none"; 
    }, 30000);
    
}

// .................... Loading Img after page refresh ...........................
document.onreadystatechange = function () {
    var state = document.readyState
    if (state == 'interactive') {
        document.getElementById('content').style.visibility = "visible";
        document.getElementById("loader").style.display = "block"; 
    } else if (state == 'complete') {
        setTimeout(function () {
            document.getElementById('interactive');
           // document.getElementById('load').style.visibility = "hidden";
           document.getElementById("loader").style.display = "none"; 
            document.getElementById('content').style.visibility = "visible";
        }, 1000);
    }
}
// ...................... Login Form disable or enbable submit button  ...................
$('#username, #password').bind('keyup', function() {
    if(allFilled()) $('#login').removeAttr('disabled');
});

function allFilled() {
    var filled = true;
    $('body input').each(function() {
        if($(this).val() == '') filled = false;
    });
    return filled;
}


// ...................... Payment Form disable or enbable submit button ...........................
$('#type_pay_id, #money, #date').change('keyup', function() {
    if(allFilled()) $('#save').removeAttr('disabled');
});

function allFilled() {
    var filled = true;
    $('input').each(function() {
        if($(this).val() == '') filled = false;
    });
    return filled;
}

// .............................. Recived Form disable or enbable submit button ....................
$('#tye_receive_id, #money, #date').change('keyup', function() {
    if(allFilled()) $('#save').removeAttr('disabled');
});

function allFilled() {
    var filled = true;
    $('input').each(function() {
        if($(this).val() == '') filled = false;
    });
    return filled;
}