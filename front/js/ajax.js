function request(path, vars, as)
{   
    var path = path || document.location;
    var vars = vars || '';
    console.log(as);
    var response = NaN;
    $.ajax({
        type: 'POST',
        url:  path,
        data: vars,
        global: false,
        async: as,
        success: function(resp) {
            response = resp;
        },

        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
    return response;

}

function empty(mixed_var)
{
    return (
        mixed_var === "" || mixed_var === 0  || mixed_var === "0" || mixed_var === undefined ||

        mixed_var === null || mixed_var === false  ||  ( is_array(mixed_var) && mixed_var.length === 0 ) );
}
