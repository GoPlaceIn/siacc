/*!
 * SIACC - Sistema Interdiciplinar de Análise de Casos Clínicos - fn-forms.js
 * http://siacc.regisls.net
 *
 * Copyright (c) 2011 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * Data: 01/09/2011 22:18 - Quinta-feira
 * Data revisão: 17/12/2013 22:57 - Terça-feira
 * Revisão: 4
 * Tradução: OK
 */

function fntSerializa(tela, optvazio)
{
    optvazio = (typeof(optvazio) == "undefined" ? false : optvazio);
    
    var string = "";
    if (typeof(tela) == "undefined")
    {
        jQuery('.campo').not("#divRelacoes").each(function(){
            if (jQuery(this).attr("name").substr(0, 3) == "txt")
            {
                string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + escape(jQuery(this).val())) : (jQuery(this).attr("name") + "=" + escape(jQuery(this).val()));
            }
            else
            {
                if (jQuery(this).attr("name").substr(0, 3) == "chk")
                {
                    if (jQuery(this).attr("checked"))
                    {
                        string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + jQuery(this).val()) : (jQuery(this).attr("name") + "=" + jQuery(this).val());
                    }
                    else
                    {
                        if (optvazio)
                        {
                            string += (string != "") ? ("&" + jQuery(this).attr("name") + "=") : (jQuery(this).attr("name") + "=");
                        }
                    }
                }
                else
                {
                    string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + jQuery(this).val()) : (jQuery(this).attr("name") + "=" + jQuery(this).val());
                }
            }
        });
    }
    else
    {
        jQuery("#"+tela).find(".campo").not("#divRelacoes").each(function(){
            if (jQuery(this).attr("name").substr(0, 3) == "txt")
            {
                string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + escape(jQuery(this).val())) : (jQuery(this).attr("name") + "=" + escape(jQuery(this).val()));
            }
            else
            {
                if (jQuery(this).attr("name").substr(0, 3) == "chk")
                {
                    if (jQuery(this).attr("checked"))
                    {
                        string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + jQuery(this).val()) : (jQuery(this).attr("name") + "=" + jQuery(this).val());
                    }
                    else
                    {
                        if (optvazio)
                        {
                            string += (string != "") ? ("&" + jQuery(this).attr("name") + "=") : (jQuery(this).attr("name") + "=");
                        }
                    }
                }
                else
                {
                    string += (string != "") ? ("&" + jQuery(this).attr("name") + "=" + jQuery(this).val()) : (jQuery(this).attr("name") + "=" + jQuery(this).val());
                }
            }
        });
    }
    
    /* Casos especiais de caracteres */
    string = string.replace(/\+/g, '%2B');
    return string;
}

function fntValidaObrigatorios(tela)
{
    var erro = false;

    if (typeof(tela) == "undefined")
    {
        jQuery(".campo").each(function(){
            if (jQuery(this).hasClass("requerido"))
            {
                if (jQuery.trim(jQuery(this).val()) == "")
                {
                    jQuery(this).addClass("campo-falta");
                    erro = true;
                }
                else
                {
                    jQuery(this).removeClass("campo-falta");
                }
            }
        });
    }
    else
    {
        jQuery("#" + tela).find(".campo").each(function(){
            if (jQuery(this).hasClass("requerido"))
            {
                if (jQuery.trim(jQuery(this).val()) == "")
                {
                    jQuery(this).addClass("campo-falta");
                    erro = true;
                }
                else
                {
                    jQuery(this).removeClass("campo-falta");
                }
            }
        });
    }
    
    if (erro == true)
    {
        alert(traducoes.sValidaCamposText);
        return false;
    }
    else
    {
        return true;
    }
}

function fntFillForm(XML, tela)
{
    if (typeof(tela) == "undefined")
    {
        jQuery(".campo").not("#etapa").each(function(){
            switch(jQuery(this).attr("id").substr(0, 3))
            {
                case "sel":
                    if (getXMLValue(XML, jQuery(this).attr("id")).indexOf('<option') != -1)
                    {
                        jQuery("#" + jQuery(this).attr("id")).html(getXMLValue(XML, jQuery(this).attr("id")));
                    }
                    else
                    {
                        jQuery("#" + jQuery(this).attr("id")).val(getXMLValue(XML, jQuery(this).attr("id")));
                    }
                    break;
                case "div":
                    jQuery("#" + jQuery(this).attr("id")).html(getXMLValue(XML, jQuery(this).attr("id")));
                    break;
                case "chk":
                    if ((getXMLValue(XML, jQuery(this).attr("id")) == "1") || (getXMLValue(XML, jQuery(this).attr("id")) == "on") || (getXMLValue(XML, jQuery(this).attr("id")) == "true"))
                        jQuery("#" + jQuery(this).attr("id")).attr("checked", true);
                    else
                        jQuery("#" + jQuery(this).attr("id")).attr("checked", false);
                    break;
                default:
                    jQuery("#" + jQuery(this).attr("id")).val(getXMLValue(XML, jQuery(this).attr("id")));
                    break;
            }
        });
    }
    else
    {
        jQuery("#" + tela).find(".campo").not("#etapa").each(function(){
            switch(jQuery(this).attr("id").substr(0, 3))
            {
                case "sel":
                    if (getXMLValue(XML, jQuery(this).attr("id")).indexOf('<option') != -1)
                    {
                        jQuery("#" + jQuery(this).attr("id")).html(getXMLValue(XML, jQuery(this).attr("id")));
                    }
                    else
                    {
                        jQuery("#" + jQuery(this).attr("id")).val(getXMLValue(XML, jQuery(this).attr("id")));
                    }
                    break;
                case "div":
                    jQuery("#" + jQuery(this).attr("id")).html(getXMLValue(XML, jQuery(this).attr("id")));
                    break;
                case "chk":
                    if ((getXMLValue(XML, jQuery(this).attr("id")) == "1") || (getXMLValue(XML, jQuery(this).attr("id")) == "on") || (getXMLValue(XML, jQuery(this).attr("id")) == "true"))
                        jQuery("#" + jQuery(this).attr("id")).attr("checked", true);
                    else
                        jQuery("#" + jQuery(this).attr("id")).attr("checked", false);
                    break;
                default:
                    jQuery("#" + jQuery(this).attr("id")).val(getXMLValue(XML, jQuery(this).attr("id")));
                    break;
            }
        });
    }
}

function fntLimpaForm(excessao, tela)
{
	if (typeof(tela) == "undefined")
    {
        jQuery(".campo").each(function(){
            if (jQuery.inArray(jQuery(this).attr("id"), excessao) == -1)
            {
                switch(jQuery(this).attr("id").substr(0, 3))
                {
                    case "sel":
                        jQuery(this)[0].selectedIndex = 0;
                        break;
                    case "div":
                        jQuery("#" + jQuery(this).attr("id")).html("");
                        break;
                    case "chk":
                        jQuery("#" + jQuery(this).attr("id")).attr("checked", false);
                        break;
                    default:
                        jQuery("#" + jQuery(this).attr("id")).val("");
                        break;
                }
            }
        });
    }
    else
    {
        jQuery("#" + tela).find(".campo").each(function(){
            if (jQuery.inArray(jQuery(this).attr("id"), excessao) == -1)
            {
                switch(jQuery(this).attr("id").substr(0, 3))
                {
                    case "sel":
                        jQuery(this)[0].selectedIndex = 0;
                        break;
                    case "div":
                        jQuery("#" + jQuery(this).attr("id")).html("");
                        break;
                    case "chk":
                        jQuery("#" + jQuery(this).attr("id")).attr("checked", false);
                        break;
                    default:
                        jQuery("#" + jQuery(this).attr("id")).val("");
                        break;
                }
            }
        });
    }
}