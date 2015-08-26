/*!
 * SIACC - Sistema Interdisciplinar de Análise de Casos Clínicos - fn-login.js
 * http://siacc.regisls.net
 *
 * Copyright (c) 2011 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * Data: 20/12/2011 20:59
 * Data revisão: 17/12/2013 23:44
 * Revisão: 12
 * Tradução: OK
 */
 
var visitados = Array();
var volta = Array();
var analise = Array();
var visauto = Array();
var salvo = false;

function fntAtual(node)
{
    $("#hdnAtual").val(node.data.key);
    visitados.push(node.data.key);
}

function fntInicia(par)
{
    var pai = jQuery("#tree").dynatree("getActiveNode");
    
    var tree = $("#tree").dynatree("getTree");
    var node = tree.getNodeByKey(par);
    
    fntAtual(node);
    fntExibe(node.data.key);
}

function fntSalvaRespAtual()
{
    salvo = true;
    var tipo = $("#hdnAtual").val().split('_')[1];
    
    if ((tipo == "perg") || (tipo == "grupo-perg"))
    {
        // montagem dos arrays
        var arrnexer = new Array();
        var arrsexer = new Array();
        $("input[class='opcao-resposta']").each(function(i){
            if ($.inArray($(this).attr("id").split('_')[1], arrnexer) == -1)
            {
                arrnexer.push($(this).attr("id").split('_')[1]);
                arrsexer.push(0);
            }
        });
        
        $("input[class='opcao-resposta']").each(function(i){
            if ($(this).is(':checked'))
            {
                var pos = $.inArray($(this).attr("id").split('_')[1], arrnexer);
                arrsexer[pos] += parseInt($(this).val());
            }
        });
        
        if (arrnexer.length > 0)
        {
            var key = $("#hdnAtual").val().split('_')[3];
            for (var i = 0; i < arrnexer.length; i++)
            {
                var dados = "k=" + key + "&p=" + arrnexer[i] + "&s=" + arrsexer[i];
                $.ajax({
                    type: 'post',
                    url: 'ajaxrea.php',
                    async: false,
                    data: dados,
                    success: function(msg){
                        if (msg.indexOf('ERRO') == -1)
                        {
                            return true;
                        }
                        else
                        {
                            alert(msg);
                            return false;
                        }
                    },
                    error: function(http, text, err){
                        alert(text);
                        return false;
                    }
                });
            }
        }
    }
    else
    {
        var key = $("#hdnAtual").val().split('_')[3];
        var resp = 0;
        //alert("Deve salvar as respostas de uma seção");
        $("input[class='opcao-resposta']").each(function(){
            if ($(this).is(':checked'))
            {
                resp += parseInt($(this).val(), 10);
            }
        });
        if (resp > 0)
        {
            var dados = 's=' + resp + '&k=' + key;
            
            $.ajax({
                type: 'post',
                url: 'ajaxrea.php',
                async: false,
                data: dados,
                success: function(msg){
                    if (msg.indexOf('ERRO') == -1)
                    {
                        return true;
                    }
                    else
                    {
                        alert(msg);
                        return false;
                    }
                },
                error: function(http, text, err){
                    alert(text);
                    return false;
                }
            });
        }
        else
        {
            alert(traducoes.sRespExerContText);
            return false;
        }
    }
}

function fntVerificaSalto()
{
    var key = $("#hdnAtual").val().split('_')[3];
    var dados = 'k=' + key;
    var retorno = "";
    $.ajax({
        type: 'post',
        url: 'ajaxresolucaosalto.php',
        async: false,
        data: dados,
        success: function(msg){
            if (msg.indexOf('ERRO:') == -1)
            {
                if (msg != "0")
                {
                    if (jQuery.inArray(msg, visitados) == -1)
                    {
                        var tree = $("#tree").dynatree("getTree");
                        var node = tree.getNodeByKey($("#hdnAtual").val());
                        var nodeDest = tree.getNodeByKey(msg);
                        volta.push(node.data.key);
                        fntAtual(nodeDest);
                        retorno = nodeDest.data.key;
                    }
                    else
                    {
                        retorno = "-1";
                    }
                }
                else
                {
                    retorno = "-1";
                }
            }
            else
            {
                alert(msg);
                retorno = "-1";
            }
        },
        error: function(http, text, err){
            alert(text);
            retorno = "-1";
        }
    });
    return retorno;
}

function fntProximo()
{
    //verificar = (typeof(verificar) == "undefined" ? true : verificar);
    
    if (($("#hdnsave").val() == "S") && (!salvo))
    {
        var ok = fntSalvaRespAtual();
        if (ok === false)
        {
            salvo = false;
            return false;
        }
    }
    
    var nodeSalto = fntVerificaSalto();
    if (nodeSalto != "-1")
    {
        fntExibe(nodeSalto);
        return;
    }
    
    var tree = $("#tree").dynatree("getTree");
    var node = tree.getNodeByKey($("#hdnAtual").val());
    
    if (node.hasChildren())
    {
        var filhos = node.getChildren();
        var encontrou = false;
        
        for (var i = 0; i < filhos.length; i++)
        {
            var tiponodo = fntTipoNodo(filhos[i].data.key);
            var tipocont = fntTipoCont(filhos[i].data.key);
            if ((tiponodo == "agr") || ((tiponodo == "cont") && (tipocont == "an")) || ((tiponodo == "cont") && (tipocont == "exfis")) || ((tiponodo == "cont") && (tipocont == "aninv")))
            {
                if ($.inArray(filhos[i].data.key, visitados) == -1)
                {
                    encontrou = true;
                    volta.push(node.data.key);
                    fntAtual(filhos[i]);
                    fntExibe(filhos[i].data.key);
                    break;
                }
            }
            else
            {
                if (filhos[i].hasChildren())
                {
                    var netos = filhos[i].getChildren()
                    for (var j = 0; j < netos.length; j++)
                    {
                        if ($.inArray(netos[j].data.key, visitados) == -1)
                        {
                            encontrou = true;
                            volta.push(node.data.key);
                            fntAtual(netos[j]);
                            fntExibe(netos[j].data.key);
                            break;
                        }
                    }
                    if (encontrou)
                    {
                        break;
                    }
                }
            }
        }
        if (!encontrou)
        {
            if (volta.length != 0)
            {
                $("#hdnAtual").val(volta.pop());
                fntProximo();
            }
            else
            {
                alert(traducoes.sFimCaso2Text);
            }
        }
        
    }
    else
    {
        if (volta.length != 0)
        {
            $("#hdnAtual").val(volta.pop());
            fntProximo();
        }
        else
        {
            alert(traducoes.sFimCasoText);
        }
    }
}

function fntAnterior()
{
    visitados.pop();
    var ultimo = visitados[visitados.length-1];
    
    var tree = $("#tree").dynatree("getTree");
    var node = tree.getNodeByKey(ultimo);
    visitados.pop();
    
    while ((volta[volta.length-1] != node.parent.data.key) && (volta.length > 0))
    {
        volta.pop();
    }
    
    fntAtual(node);
    fntExibe(node.data.key);
}

function fntExibe(idnodo)
{
    salvo = false;
    //$("#exibir").html(conteudo);
    var dados = "k=" + idnodo;
    
    jQuery.ajax({
        type: "post",
        url: "ajaxbuscaparterescaso.php",
        data: dados,
        success: function(msg){
            //fntWorking(false);
            if (msg.indexOf('ERRO') == -1)
            {
                $("#titsec").html(getXMLValue(msg,"titulosecao"));
                $("#contsec").html(getXMLValue(msg,"conteudo"));
                $("#menusec").html(getXMLValue(msg, "menu"));
                $("#hdnsave").val(getXMLValue(msg, "save"));
                if (getXMLValue(msg, "saibamais") != "")
                {
                	$(".btnSaibaMais").show();
                	$("#divSaibaMaisResultado").html(getXMLValue(msg, "saibamais"));
                }
                else
                {
                	$(".btnSaibaMais").hide();
                	$("#divSaibaMaisResultado").html("");
                }
                if (getXMLValue(msg, "visitados") != "")
                {
                    var itens = getXMLValue(msg, "visitados").split(";");
                    for (var i = 0; i < itens.length; i++)
                    {
                        visauto.push(itens[i]);
                    }
                }
                if (getXMLValue(msg, "eval") != "")
                {
                    eval(getXMLValue(msg, "eval"));
                }
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

function fntMostraSaibaMais()
{
	$("#divSaibaMais").toggle();
	fntCentralizaDivTela("divSaibaMais");
}

function fntTipoNodo(nodo)
{
    return nodo.split('_')[0];
}

function fntTipoCont(nodo)
{
    return nodo.split('_')[1];
}

function fntGeraCaminhoVolta(possiveis)
{
    var atual = jQuery("#tree").dynatree("getTree").getNodeByKey(jQuery("#hdnAtual").val());
    var arr = Array();
    possiveis = possiveis.split(";");
    
    jQuery("#tree").dynatree("getRoot").visit(function(node){
        if (node.data.key != atual.data.key)
        {
            if (node.data.key.split('_')[0] != "cont")
            {
                if (atual.isDescendantOf(node))
                {
                    if (jQuery.inArray(node.data.key, possiveis) != -1)
                    {
                        arr.push(node.data.key);
                    }
                }
            }
        }
        else
        {
            return false;
        }
    });
    
    if (arr.length > 0)
    {
        volta = arr;
    }
}

function fntGeraVisitados(possiveis)
{
    var atual = jQuery("#tree").dynatree("getTree").getNodeByKey(jQuery("#hdnAtual").val());
    var arr = Array();
    possiveis = possiveis.split(";");
    
    jQuery("#tree").dynatree("getRoot").visit(function(node){
        if (node.data.key != atual.data.key)
        {
            if (jQuery.inArray(node.data.key, possiveis) != -1)
            {
                arr.push(node.data.key);
            }
        }
        else
        {
            arr.push(node.data.key);
            return false;
        }
    });
    
    if (arr.length > 0)
    {
        visitados = arr;
    }
}

function fntContaMarcadas()
{
    var g = new Array();
    jQuery(".opcao-resposta").each(function(){
        if (jQuery.inArray(jQuery(this).attr('name'), g) == -1)
        {
            g.push(jQuery(this).attr('name'));
        }
    });
    
    var ret = true;
    var i = 0;
    for (i = 0; i < g.length; i++)
    {
        if (jQuery("input[name='" + g[i] + "']:checked").length < 1)
            ret = false;
    }
    
    return ret;
}

function fntResponde()
{
    if (fntContaMarcadas() === false)
    {
        alert(traducoes.sCondVerRespText);
        return;
    }
    
    if (($("#hdnsave").val() == "S") && (!salvo))
    {
        var ok = fntSalvaRespAtual();
        if (ok === false)
        {
            salvo = false;
            alert(traducoes.sErrSalvPergText);
            return false;
        }
    }
    
    var dados = "chave=" + jQuery("#hdnAtual").val();
    
    jQuery.ajax({
        type: "post",
        url: "ajaxverificaacertos.php",
        data: dados,
        success: function(msg){
            jQuery('#divRespostasResultado').html(msg);
            jQuery('#divRespostas').toggle();
			fntCentralizaDivTela("divRespostas");
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntLimpaResolucao()
{
    if (jQuery("input[name='rdoApaga']:checked").val() == "T")
    {
        jQuery.ajax({
            type: "post",
            url: "actlimpapreview.php",
            success: function(msg){
                if (msg.indexOf('Erro') == -1)
                {
                    window.close();
                }
                else
                {
                    alert(text);
                    window.close();
                }
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
    else
    {
        window.close();
    }
}