/*!
 * SIACC - Sistema Interdisciplinar de Análise de Casos Clínicos
 * http://siacc.regisls.net
 *
 * Copyright (c) 2013 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * fn-aluno.js
 * Data: 05/11/2013 20:39 - Terça-feira
 * Revisão: 10
 */

var passou = false;

function ArrayContains(array, chave)
{
    for (var i = 0; i < array.length; i++)
    {
        if (array[i] == chave)
            return true;
    }
    return false;
}

function fntLoadCaso(c, r)
{
    var url = 'vwresolucao-offline.php?c=' + c;
    //var url = 'resolve.php?c=' + c;
    if (r != "")
        url += '&r=' + r;
    
    location.href = url;
}

function fntAvancar()
{
    var url = 'resolve.php?d=f';
    location.href = url;
}

function fntNavega(d)
{
    passou = true;
    jQuery("#d").val(d);
    jQuery("#frmResolucao").submit();
}

function fntVerificaEnvio()
{
    if (!passou)
    {
        jQuery("#d").val('n');
    }
}

function fntVolta(k)
{
    var url = 'resolve.php?k=' + k + '&d=p';
    location.href = url;
}

function fntMarcaDesmarca(id)
{
    if (jQuery("#" + id).is(":checked"))
    {
        jQuery("#" + id).parent().parent().addClass("marcado");
    }
    else
    {
        jQuery("#" + id).parent().parent().removeClass("marcado");
    }
}

function fntMostraConteudo(id)
{
    if (jQuery("div[id='"+id+"']").css("display") == "none")
    {
        jQuery("div[id='"+id+"']").css("display", "block");
        jQuery("img[id='img-"+id+"']").attr("src", "img/menos.png");
        jQuery("img[id='img-"+id+"']").attr("alt", traducoes.sOculDetalText);
        jQuery("img[id='img-"+id+"']").attr("title", traducoes.sOculDetalText);
    }
    else
    {
        jQuery("div[id='"+id+"']").css("display", "none");
        jQuery("img[id='img-"+id+"']").attr("src", "img/mais.png");
        jQuery("img[id='img-"+id+"']").attr("alt", traducoes.sExibDetalText);
        jQuery("img[id='img-"+id+"']").attr("title", traducoes.sExibDetalText);
    }
}

function fntVerifica()
{
    var marcados = "";
    
    jQuery("input[class='opcao-resposta']:checked").each(function(){
        marcados += jQuery(this).attr("name") + "=" + jQuery(this).val() + "&";
    });
    
    if (marcados == "")
    {
        alert(traducoes.sNenhumMarcText);
        return;
    }
    else
    {
        jQuery("#hdnaf").val("S");
        marcados = marcados.substring(0, marcados.length-1) + "&k=" + jQuery("#hdnk").val();
        
        jQuery.ajax({
            type: "post",
            url: "vr.php",
            data: marcados,
            success: function(msg){
                jQuery(".organizador").empty();
                jQuery(".organizador").append(msg);
            },
            error: function(http, text, err){
                alert(msg);
            }
        });
    }
}

/*
function fntVerificaEtapa()
{
    var marcados = "";
    var perguntas = new Array();
    
    jQuery("input[name^='rdoAlternativa_']").each(function(){
        if (!ArrayContains(perguntas, jQuery(this).attr("name")))
        {
            perguntas[perguntas.length] = jQuery(this).attr("name");
        }
    });
    
    for (var i = 0; i < perguntas.length; i++)
    {
        if (jQuery("input[name='" + perguntas[i] + "']:checked").length == 0)
        {
            alert("Você não repondeu todas as perguntas");
            return false;
        }
    }
    
    jQuery("input[name^='rdoAlternativa_']:checked").each(function(){
        marcados += jQuery(this).attr("name") + "=" + jQuery(this).val() + "&";
    });
    
    if (marcados == "")
    {
        alert("Você não marcou nenhuma alternativa. Marque as alternativas e então verifique novamente.");
        return;
    }
    else
    {
        jQuery("#hdnaf").val("S");
        marcados = marcados.substring(0, marcados.length-1) + "&k=" + jQuery("#hdnk").val();
        
        jQuery.ajax({
            type: "post",
            url: "vr.php",
            data: marcados,
            success: function(msg){
                jQuery(".organizador").html(getXMLValue(msg, "texto"));
                var imgs = getXMLValue(msg, "imgs").split(",");
                for (var i = 0; i < imgs.length; i++)
                {
                    var obj = imgs[i].split("_");
                    if (obj[1] == 's')
                        jQuery("#img_perg_" + obj[0]).attr("src", "img/correto.png");
                    else
                        jQuery("#img_perg_" + obj[0]).attr("src", "img/incorreto.png");
                }
            },
            error: function(http, text, err){
                alert(msg);
            }
        });
    }
}
*/

function fntVerificaTrat()
{
    var marcados = "";
    
    jQuery("input[class='opcao-resposta']:checked").each(function(){
        marcados += ((marcados != "") ? "&" : "") + jQuery(this).attr("name") + "=" + jQuery(this).val();
    });
    
    if (marcados == "")
    {
        alert(traducoes.sNenhumMarcText);
        return;
    }
    else
    {
        jQuery("#hdnaf").val("S");
        marcados += "&k=" + jQuery("#hdnk").val();
        
        jQuery.ajax({
            type: "post",
            url: "vr.php",
            data: marcados,
            success: function(msg){
                jQuery("span[id^='rt_']").each(function(){
                    var cod = jQuery(this).attr("id").split("_")[1];
                    jQuery(this).attr("class", getXMLValue(msg, jQuery(this).attr("id")));
                    if (getXMLValue(msg, ("just_des_" + cod)) != "")
                    {
                        jQuery("#just_des_" + cod).html(getXMLValue(msg, ("just_des_" + cod)));
                        jQuery("#spnJust_" + cod).css("display", "");
                    }
                    else
                    {
                        jQuery("#just_des_" + cod).html("");
                        jQuery("#spnJust_" + cod).css("display", "none");
                    }
                });
            },
            error: function(http, text, err){
                alert(msg);
            }
        });
    }
}

function fntInstanciaToolTip()
{
    var hideDelay = 800;
    var currentID;
    var hideTimer = null;

    // One instance that's reused to show info for the current person
    var container = $('<div id="efiPopupContainer" style="z-index:4000;">'
            + '<table width="" border="0" cellspacing="0" cellpadding="0" align="center" class="efiPopupPopup">'
            + '<tr>'
            + '   <td class="corner topLeft"></td>'
            + '   <td class="top"></td>'
            + '   <td class="corner topRight"></td>'
            + '</tr>'
            + '<tr>'
            + '   <td class="left">&nbsp;</td>'
            + '   <td><div id="efiPopupContent"></div></td>'
            + '   <td class="right">&nbsp;</td>'
            + '</tr>'
            + '<tr>'
            + '   <td class="corner bottomLeft">&nbsp;</td>'
            + '   <td class="bottom">&nbsp;</td>'
            + '   <td class="corner bottomRight"></td>'
            + '</tr>'
            + '</table>'
            + '</div>');

    jQuery('body').append(container);

    jQuery('.efi-trigger').live('mouseover', function(){
        if (hideTimer)
            clearTimeout(hideTimer);
            
        var configs = jQuery(this).attr('rel').split(',');
        var parte = configs[0];
        var idpos = "#" + configs[1];
        
        var pos = jQuery(idpos).offset();
        var width = jQuery(idpos).width();
        container.css({
            left: (pos.left + width) + 'px',
            top: pos.top - 5 + 'px'
        });
        
        //$('#personPopupContent').html('alçsjdflajflasjf');

        jQuery.ajax({
            type: 'post',
            url: 'ajaxexamefisico.php',
            data: 'p=' + parte,
            success: function(data)
            {
                if (data.indexOf('ERRO') >= 0)
                {
                    alert(data);
                }
                else
                {
                    jQuery('#efiPopupContent').html(data);
                }
            },
            error: function(x, y, z){
                jQuery('#efiPopupContent').html("kakfkafh");
            }
        });

        container.css('display', 'block');
    });

    jQuery('.efi-trigger').live('mouseout', function(){
        if (hideTimer)
            clearTimeout(hideTimer);
        hideTimer = setTimeout(function(){
            container.css('display', 'none');
        }, hideDelay);
    });

    // Allow mouse over of details without hiding details
    jQuery('#efiPopupContainer').mouseover(function(){
        if (hideTimer)
            clearTimeout(hideTimer);
    });

    // Hide after mouseout
    jQuery('#efiPopupContainer').mouseout(function(){
        if (hideTimer)
            clearTimeout(hideTimer);
        
        hideTimer = setTimeout(function(){
            container.css('display', 'none');
        }, hideDelay);
    });
}

function fntSair()
{
    location.href = 'actlogoff.php';
}

function fntHome()
{
    location.href = 'aluno.php';
}

function fntApresentaConteudo(c)
{
    jQuery("#mais-conteudo-"+c).slideToggle('slow');
    if (jQuery("#lnk-conteudo-" + c).hasClass("cor-avermelhada"))
    {
        jQuery("#lnk-conteudo-" + c).removeClass("cor-avermelhada");
        jQuery("#lnk-conteudo-" + c).addClass("cor-branca");
    }
    else
    {
        jQuery("#lnk-conteudo-" + c).removeClass("cor-branca");
        jQuery("#lnk-conteudo-" + c).addClass("cor-avermelhada");
    }
}

function fntAO()
{
    alert(traducoes.sRespEtapaText);
}

function fntMaxiMini(id)
{
    try {
        jQuery("div[id='just_des_" + id + "']").css("display", "none");
        jQuery("#spnJust_" + id + " > a").removeClass("sel");
        
        jQuery("div[id='mais_des_" + id + "']").css("display", "none");
        jQuery("#spnMaisInfo_" + id + " > a").removeClass("sel");
        
    } catch(ex) { alert(ex); }
    
    jQuery("#trat_des_" + id).toggle();
    jQuery("#spnAbreFecha_" + id + " > a").html((jQuery("#spnAbreFecha_" + id + " > a").text() == traducoes.sEsconderText ? traducoes.sDetalhesText : traducoes.sEsconderText));
    if (jQuery("#trat_des_" + id).css("display") != "none")
        jQuery("#spnAbreFecha_" + id + " > a").addClass("sel");
    else
        jQuery("#spnAbreFecha_" + id + " > a").removeClass("sel");
}

function fntCAT(id)
{
    jQuery("div[id='trat_des_" + id + "']").css("display", "none");
    jQuery("#spnAbreFecha_" + id + " > a").html(traducoes.sDetalhesText);
    jQuery("#spnAbreFecha_" + id + " > a").removeClass("sel");
    
    jQuery("div[id='just_des_" + id + "']").css("display", "none");
    jQuery("#spnJust_" + id + " > a").removeClass("sel");
    
    jQuery("#mais_des_" + id).toggle();
    if (jQuery("#mais_des_" + id).css("display") != "none")
        jQuery("#spnMaisInfo_" + id + " > a").addClass("sel");
    else
        jQuery("#spnMaisInfo_" + id + " > a").removeClass("sel");
}

function fntJustTrat(id)
{
    jQuery("div[id='trat_des_" + id + "']").css("display", "none");
    jQuery("#spnAbreFecha_" + id + " > a").html(traducoes.sDetalhesText);
    jQuery("#spnAbreFecha_" + id + " > a").removeClass("sel");
    
    jQuery("div[id='mais_des_" + id + "']").css("display", "none");
    jQuery("#spnMaisInfo_" + id + " > a").removeClass("sel");
    
    jQuery("#just_des_" + id).toggle();
    if (jQuery("#just_des_" + id).css("display") != "none")
        jQuery("#spnJust_" + id + " > a").addClass("sel");
    else
        jQuery("#spnJust_" + id + " > a").removeClass("sel");
}

function fntCarregaMidias(midias)
{
    var dados = "midias=" + midias;
    jQuery.ajax({
        type: 'post',
        url: 'ajaxmidiasexamefisico.php',
        data: dados,
        success: function(data)
        {
            if (data.indexOf('ERRO') == -1)
            {
                jQuery('#galeria').html(data);
            }
            else
            {
                alert(data);
            }
        },
        error: function(x, y, z){
            jQuery('#efiPopupContent').html("kakfkafh");
        }
    });
}

function fntLoadMidia(midia)
{
    var dados = "midia=" + midia;
    jQuery.ajax({
        type: 'post',
        url: 'player.php',
        data: dados,
        success: function(msg)
        {
            if (msg.indexOf('ERRO') == -1)
            {
                jQuery("#view-midia").html(getXMLValue(msg, "btnfechar") + "<br />" + getXMLValue(msg, "player"));
                jQuery("#desc-midia").html(getXMLValue(msg, "descricao"));
                jQuery("#comp-midia").html(getXMLValue(msg, "complemento"));
            }
            else
            {
                alert(msg);
            }
        },
        error: function(x, y, z){
            alert("aconteceu um erro: " + x + ' ' + y + ' ' + z);
        }
    });
}

function fntDetItem(tipo, item, alt)
{
    if (tipo == 'j')
    {
        if (jQuery('#jus-' + item + '-' + alt).css("display") == "none")
            jQuery('#jus-' + item + '-' + alt).css("display", "");
        else
            jQuery('#jus-' + item + '-' + alt).css("display", "none");
    }
    else if (tipo == 'c')
    {
        if (jQuery('#contadi-' + item + '-' + alt).css("display") == "none")
            jQuery('#contadi-' + item + '-' + alt).css("display", "");
        else
            jQuery('#contadi-' + item + '-' + alt).css("display", "none");
    }
}

function fntMostraResumo()
{
    location.href = 'vwresumo.php';
}

function fntMostraOculta(id)
{
    if (jQuery("#"+id).css("display") == "none")
    {
        jQuery("#"+id).css("display", "");
    }
    else
    {
        jQuery("#"+id).css("display", "none");
    }
}

function fntFormataGridsResumo()
{
    //jQuery(".listadados tr:even").not("tr[class='head'], tr[id^='jus-'], tr[id^='contadi-']").addClass("escuro");
    jQuery(".listadados tr[class='norm']:even").addClass("escuro");
    jQuery(".listadados tr").not("tr[class='head']").mouseover(function(){
        jQuery(this).addClass("over");
    });
    jQuery(".listadados tr").not("tr[class='head']").mouseout(function(){
        jQuery(this).removeClass("over");
    });
}

function fntFechaMidia()
{
    jQuery('#view-midia').html('<strong>' + traducoes.sSelItemMidiaText + '</strong>');
    jQuery("#desc-midia").html('');
    jQuery("#comp-midia").html('');
}

function fntMostraPopUp(url)
{
    jQuery.ajax({
        type: 'GET',
        url: url,
        success: function(msg){
            jQuery("#divPopUpContent").html(msg);
            jQuery("#divPopUpConteudo").toggle();
            fntCentralizaDivTela("#divPopUpConteudo");
        },
        error: function(x, y, z){
            alert('Erro: ' + x + ' ' + y + ' ' + z);
            jQuery("#divPopUpContent").html(msg);
            jQuery("#divPopUpConteudo").toggle();
        }
    });
}

function frmSenha_btnEnviar_click()
{
    if ((jQuery.trim(jQuery("#txtSenha1").val()) == "") || (jQuery.trim(jQuery("#txtSenha2").val()) == ""))
    {
        alert(traducoes.sValidaSenha1Text);
        return;
    }
    
    if (jQuery("#txtSenha1").val() != jQuery("#txtSenha2").val())
    {
        alert(traducoes.sValidaSenha2Text);
        return;
    }
    
    jQuery("#frmSenha").submit();
}

function frmSenha_btnCancelar_click()
{
    location.href = "aluno.php";
}