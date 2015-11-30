function fntGravaInstituicao()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }

    fntWorking(true);

    var string = fntSerializa();
    var destino = jQuery("#etapa").val();
    
    jQuery.ajax({
        type: "post",
        url: "actgravainstituicao.php",
        data: string,
        success: function(msg){
            fntWorking(false);
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}