/*!
 * SIACC - Sistema Interdiciplinar de Análise de Casos Clínicos - fn-login.js
 * http://siacc.regisls.net
 *
 * Copyright (c) 2011 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * Data: 01/09/2011 22:18 - Quinta-feira
 * Data Revisão: 17/12/2013 - Terça-feira
 * Revisão: 2
 * Tradução: OK
 */


// Funções diversas da página
function fntNovoCadastro()
{
    location.href = "vwnovousuario.php";
}

function fntCancela()
{
    //location.href = "/projeto";
    location.href = "index.php";
}

function fntLimpaForm()
{
    jQuery('.campo').each(function(){
        jQuery(this).attr("value", "");
    });
    jQuery('.campo:first').focus();
}

function fntValidaForm()
{
    var preenchido = true;
    
    jQuery('.req').each(function(){
        if (jQuery.trim(jQuery(this).val()) == "")
        {
            preenchido = false;
        }
    });
    
    return preenchido;
}

function fntSenhaIgual()
{
    if (jQuery('#txtSenha').val() == jQuery('#txtRepetirSenha').val())
        return true;
    else
        return false;
}

function fntSendForm()
{
    if (fntValidaForm() == true)
    {
        if (fntSenhaIgual() == true)
        {
            var string = "act=add";
            jQuery('.campo').each(function(){
                if (jQuery(this).attr("name").substr(0, 3) == "txt")
                {
                    string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + escape(jQuery(this).val())) : (jQuery(this).attr("name") + "=" + escape(jQuery(this).val()));
                }
                else
                {
                    string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + jQuery(this).val()) : (jQuery(this).attr("name") + "=" + jQuery(this).val());
                }
            });
            
            jQuery.ajax({
                type: "POST",
                url: "vwnovousuario.php",
                data: string,
                success: function(msg){
                    if (msg == "OK")
                    {
                        //location.href = "/projeto/ativacao.php";
                        location.href = "ativacao.php";
                    }
                    else
                    {
                        alert(msg);
                    }
                },
                error: function(http, text, err){
                    alert(text);
                }
            });
        }
        else
        {
            alert(traducoes.sSenhasDifText);
        }
    }
    else
    {
        alert(traducoes.sCamposObrigText);
    }
}

function fntMudaIdioma()
{
    setCookie("siacc_lang", jQuery("#selIdioma").val(), 5);
    location.href = "index.php";
}