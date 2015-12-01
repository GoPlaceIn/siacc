function fntGravaCurso()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }

    echo "<script>javascript: alert('test msgbox')></script>";

    fntWorking(true);

    var string = fntSerializa();
    var destino = jQuery("#etapa").val();
    
    jQuery.ajax({
        type: "post",
        url: "actgravacurso.php",
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