
function jsonResponse(path, vars)
{
    
}


$(document).ready(function() {
    $('.modal').click(function(e) {
        e.preventDefault();

        var id = '#modal';
    
        $('#mod-content').html(
            request(
                $(e.target).data('path'), $(e.target).data('vars'), false
            )
        );
        
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
        
        $('#mask').css({'width':maskWidth,'height':maskHeight});
        $('#mask').fadeIn(100); 
        $('#mask').fadeTo("slow",0.3); 
        
        var winH = $(window).height();
        var winW = $(window).width();
        
        $(id).css('top',  winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);
        
        $(id).fadeIn(100); 
    });
      
    $('#modal #close').click(function (e) {
        
        e.preventDefault();
        $('#mask, #modal').hide();
        }); 
     
        $('#mask').click(function () {
        $(this).hide();
        $('#modal').hide();
    });
    
    $('.cansel-filter').click(function (e) {
        e.preventDefault();
        document.location.replace(window.location.pathname);
    });
    
    $('.status-filter').click(function(e) {
        var get = window.location.search;
        if (!e.target.checked) {
            re = new RegExp('[\\&|\\?]?status\\['+e.target.value+'\\]');
            //alert(get);
            get = get.replace(re, '');
            re = new RegExp('^\&');
            get = get.replace(re, '?');
        } else {
            if (get == '') sep = '?';
            else sep = '&';
            get += sep + 'status[' + e.target.value + ']';
        }
        window.location.replace(window.location.pathname + get);
    });
    
    $('.kyrjers-filter').click(function(e) {
        var get = window.location.search;
        if (!e.target.checked) {
            re = new RegExp('[\\&|\\?]?kyrjers\\['+e.target.value+'\\]');
            //alert(get);
            get = get.replace(re, '');
            re = new RegExp('^\&');
            get = get.replace(re, '?');
        } else {
            if (get == '') sep = '?';
            else sep = '&';
            get += sep + 'kyrjers[' + e.target.value + ']';
        }
        window.location.replace(window.location.pathname + get);
    });
    
    $('.date-filter').click(function(e) {
        console.log($('#date-min')[0].value);
        if ($('#date-min').value == '' || $('#date-max') == '') {
            alert('Введите минимальную и максимальную дату.');
        } else {
            var get = window.location.search;
            if (get == '') sep = '?';
            else sep = '&';
            get += sep + 'date_min=' + $('#date-min')[0].value + '&date_max=' + $('#date-max')[0].value;
            window.location.replace(window.location.pathname + get);
        }
    });
  
});  

function call(path, number) {
    if (number === undefined) number = '';
    var msg = $('.ajax_form' + number).serialize();
    console.log(msg);
    $.ajax({

        type: 'POST',
        url: path,
        data: msg,
        success: function(resp) {
            var notices = jQuery.parseJSON(resp);
            if (notices.notice != '') alert(notices.notice);
            if (notices.error != '') alert(notices.error);
            location.reload();
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
 }

function filter(name, value) {
    var get = window.location.search;
    if (get == '') sep = '?';
    else sep = '&';
    get += sep + 'filter[name]=' + name + '&filter[value]=' + value;
    window.location.replace(location.pathname + get);
 }