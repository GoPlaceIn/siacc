/*!
 * SIACC - Sistema Interdisciplinar de Análise de Casos Clínicos - siacc.montagem.js
 * http://siacc.regisls.net
 *
 * Copyright (c) 2011 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * Data: 7/12/2011 22:24 - Quinta-feira
 * Data revisão: 17/12/2013 23:39
 * Revisão: 10
 * Tradução: OK
 */

function fntInicializaConfigs()
{
    alert(traducoes.sConfigDeText);
	
	var botoes = new Array();
	botoes[traducoes.sGravarText] = function() { fntSalvaConfigs(); };
	botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close"); };
	
	jQuery("#configs").dialog({
        autoOpen: false,
        width: 800,
        height: 550,
        title: traducoes.sConfigDeText,
        buttons: botoes,
        beforeclose: function(){
            fntLimpaTudo();
        }
    });
    
	var btnSalto = new Array();
	btnSalto[traducoes.sOkText] = function() { if (fntSetaOpcao()) { jQuery(this).dialog("close"); } };
	btnSalto[traducoes.sLimparText] = function() { fntLimpaTela(); };
	btnSalto[traducoes.sCancelarText] = function() { jQuery(this).dialog("close"); };
	
    jQuery("#divArvoreSalto").dialog({
        autoOpen: false,
        width: 500,
        height: 550,
        buttons: btnSalto
    });
    
	var btnExame = new Array();
	btnExame[traducoes.sOkText] = function() { if (fntSetaOpcoesExame()) { jQuery(this).dialog("close"); } };
	btnExame[traducoes.sLimparText] = function() { fntLimpaOpcaoExame(); };
	btnExame[traducoes.sCancelarText] = function() { jQuery(this).dialog("close"); };
	
    jQuery("#divArvoreExames").dialog({
        autoOpen: false,
        width: 500,
        height: 550,
        title: traducoes.sSelItemOptExaText,
        buttons: btnExame
    });
    
    jQuery("#tabs").tabs({
        selected: 0
    });
}

function fntLimpaTela()
{
    if (jQuery("#hidOpcao").val() == "des")
    {
        jQuery("#nodeDes").val("");
        jQuery("#nomenododes").html("");
    }
    
	try
	{
		var tree = jQuery("#treesalto").dynatree("getTree");
		tree.activateKey(tree.getRoot().getChildren()[0].data.key);
	}
	catch (e) { }
    jQuery("#nodeCond").val("");
    jQuery("#nomenodocond").html("");
    jQuery("#opcoes-perguntas-config").hide();
    jQuery("#selPerguntaConfig").html("");
    jQuery("#opcoes-resposta-config").html("");
}

function fntLimpaTudo()
{
    try
    {
        var tree = jQuery("#treesalto").dynatree("getTree");
        tree.activateKey(tree.getRoot().getChildren()[0].data.key);
    }
    catch (e) { }
    jQuery("#nodeDes").val("");
    jQuery("#nomenododes").html("");
    jQuery("#nodeCond").val("");
    jQuery("#nomenodocond").html("");
    jQuery("#opcoes-perguntas-config").hide();
    jQuery("#selPerguntaConfig").html("");
    jQuery("#opcoes-resposta-config").html("");
}

function fntLimpaOpcaoExame()
{
    var tree = jQuery("#treeexames").dynatree("getTree");
    tree.activateKey(tree.getRoot().getChildren()[0].data.key);
    jQuery("#txtConfig_3").val("");
    jQuery("#nomeconf3").html("");
}

function fntExibeOcultaConfs(xml)
{
    var confs = getXMLValue(xml, 'ArrConfs').split(";");
    
    jQuery(".caixa-config").each(function(){
        if (jQuery.inArray(jQuery(this).attr("id").split('-')[1], confs) != -1)
        {
            jQuery(this).css("display", "");
        }
        else
        {
            jQuery(this).css("display", "none");
        }
    });
}

// Função OK - revisada
function fntBuscaDetalhesNodo(idNodo, destino)
{
    //Modelo esperado: agr_optex_0_53D8B795E043603F643DD32E3B88FC40

    var ok = "hip;optex;resex;diag;trat;des;html;img;vid;aud;doc;perg;grupo-perg;";
    var arrdados = idNodo.split("_");

    var organizador = arrdados[0];
    var tipo = arrdados[1];

    if ((ok.indexOf(tipo+';') != -1) && (organizador == "agr"))
    {
        fntWorking(true);
        // Se foi clicado em um agrupador e é de um tipo que permite afiliação
        var dados = "idnodo=" + tipo;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxmontagemparte.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf('ERRO') == -1)
                {
                    jQuery("#" + destino).html(msg);
                    fntFormagaGrid();
                    jQuery("#configs").hide();
                    jQuery("#" + destino).dialog("open");
                    fntWorking(false);
                }
                else
                {
                    fntWorking(false);
                    alert(msg);
                }
            },
            error: function(http, text, err){
                fntWorking(false);
                alert(text);
            }
        });
    }
}

// Função OK - nova
function fntIrmaos(pai)
{
    var cont = 0;
    var filhos = pai.getChildren();
    
    if (filhos)
    {
        for (var i = 0; i < filhos.length; i++)
        {
            if (filhos[i].getLevel() == pai.getLevel() + 1)
                cont++;
        }
    }
    return ++cont;
}

function fntIrmaosMaisVelhos(pai, eu)
{
    var cont = 0;
    var filhos = pai.getChildren();
    
    if (filhos)
    {
        for (var i = 0; i < filhos.length; i++)
        {
            if ((filhos[i].getLevel() == pai.getLevel() + 1) && (filhos[i].data.key != eu.data.key))
            {
                cont++;
            }
            else
            {
                break;
            }
        }
    }
    //Retorna quantos nodos vem antes do que está sendo movido
    return ++cont;
}

// Função OK - revisada
function fntAddItemMontagem(tipo)
{
    var texto = Array();
	texto["an"] = traducoes.sECAnIdentText;
	texto["aninv"] = traducoes.sECAnInvesText;
	texto["exfis"] = traducoes.sECExaFisText;
	texto["hip"] = traducoes.sECHipDiagText;
	texto["optex"] = traducoes.sECOptExameText;
	texto["resex"] = traducoes.sECResExameText;
	texto["diag"] = traducoes.sECOptDiagText;
	texto["trat"] = traducoes.sECOptTratText;
	texto["des"] = traducoes.sECDesfText;
	texto["html"] = traducoes.sECContHTMLText;
	texto["img"] = traducoes.sECContIMGText;
	texto["vid"] = traducoes.sECContVIDText;
	texto["aud"] = traducoes.sECContAUDText;
	texto["doc"] = traducoes.sECContDOCText;
	texto["perg"] = traducoes.sECContEXEText;
	texto["grupo-perg"] = traducoes.sECContGrExeText;

	
	var pai = jQuery("#tree").dynatree("getActiveNode");
    if (!pai)
    {
        alert(traducoes.sSelItemText);
        return;
    }
    
    fntWorking(true);
    var org = (((tipo == 'an') || (tipo == 'aninv') || (tipo == 'exfis')) ? 'cont' : 'agr');
    var ordem = fntIrmaos(pai);
    
    var dados = "a=inc&org=" + org + "&item=" + tipo + "&pai=" + pai.data.key + "&ord=" + ordem;
    
    jQuery.ajax({
        type: 'post',
        url: 'ajaxsalvaitemmontagemcaso.php',
        data: dados,
        success:function(msg){
            if (msg.indexOf('ERRO') != -1)
            {
                alert(msg);
            }
            else
            {
                var childnode = pai.addChild({
                    title: texto[tipo],
                    key: msg
                });
            }
        },
        error:function(http, text, err){
            alert(http + ' ' + text + ' ' + err);
        }
    });
    fntWorking(false);
}

// Função OK - revisada
function fntRemoverItemMontagem()
{
    var nodo = jQuery("#tree").dynatree("getActiveNode");

    if (!nodo)
        return;
    
    if (nodo.data.key.substr(0, 4) == 'raiz')
    {
        alert(traducoes.sMsgDelNodRaizText);
        return;
    }

    if (nodo.hasChildren())
    {
        var msg = traducoes.sConfRemItemText.replace('@title', nodo.data.title).replace('@countChildren', nodo.countChildren());
		if (!confirm(msg))
            return;
    }
    else
    {
        var msg = traducoes.sConfRemItemZrText.replace('@title', nodo.data.title);
		if (!confirm(msg))
            return;
    }

    fntWorking(true);
    jQuery.ajax({
        type: "post",
        url: "ajaxsalvaitemmontagemcaso.php",
        data: "a=rem&nodo=" + nodo.data.key,
        success: function(msg){
            if (msg.indexOf('ERRO') == -1)
            {
                nodo.remove();
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
    fntWorking(false);
}

// Função OK - nova
function fntAtualilzaPosicao(chave, chavepai)
{
    //alert(chave + ' ' + chavepai);
    //alert("posAnterior: " + jQuery("#posAtual").val() + "; posNova: " + jQuery("#posNova").val());
    fntWorking(true);
    var dados = "a=mov&nodo=" + chave + 
                "&nodopai=" + chavepai + 
                "&posant=" + jQuery("#posAtual").val() + 
                "&posnova=" + jQuery("#posNova").val();
    
    jQuery.ajax({
        type: "post",
        url: "ajaxsalvaitemmontagemcaso.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf('ERRO') != -1)
            {
                location.href = location.href;
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
    
    jQuery("#posAtual").val("");
    jQuery("#posNova").val("");
    fntWorking(false);
}

function fntPodeInserir(nodopai, tipo, conteudo)
{
    //agr_optex_0_53D8B795E043603F643DD32E3B88FC40
    var filhos = nodopai.getChildren();
    
    if (filhos)
    {
        for (var i = 0; i < filhos.length; i++)
        {
            if (filhos[i].getLevel() == nodopai.getLevel()+1)
            {
                var composicao = filhos[i].data.key.split("_");
                if ((composicao[0] == "cont") && (composicao[1] == tipo) && (composicao[2] == conteudo))
                {
                    return false;
                }
            }
        }
        return true;
    }
    else
    {
        return true;
    }
}

function fntAddFolha()
{
    var nodo = jQuery("#tree").dynatree("getActiveNode");

    if (!nodo)
    {
        alert(traducoes.sSelItmAddCntText);
        return;
    }

    var valIdPai = nodo.id;
    var jaTem = "";
    var ord = fntIrmaos(nodo)-1;
    fntWorking(true);
    
    jQuery("input[class='item_arvore']:checked").each(function(){
        var idChk = jQuery(this).attr("id").split("_");
        var des = jQuery("#spn_"+idChk[1]+"_"+idChk[2]).text();
        var add = true;
        
        if (fntPodeInserir(nodo, idChk[1], idChk[2]))
        {
            ord++;
            var dados = "a=inc&org=cont&item=" + idChk[1] + "&pai=" + nodo.data.key + "&ord=" + ord + "&cont=" + idChk[2];
            jQuery.ajax({
                type: 'post',
                url: 'ajaxsalvaitemmontagemcaso.php',
                data: dados,
                success:function(msg){
                    if (msg.indexOf('ERRO') != -1)
                    {
                        fntWorking(false);
                        alert(msg);
                    }
                    else
                    {
                        var childnode = nodo.addChild({
                            title: des,
                            key: msg
                        });
                    }
                },
                error:function(http, text, err){
                    fntWorking(false);
                    alert(http + ' ' + text + ' ' + err);
                }
            });
        }
        else
        {
            jaTem += "\r\n" + des;
        }
    });
    fntWorking(false);
    if (jaTem != "")
    {
        alert(traducoes.sItmJaTinhaText + "\r\n\r\n" + jaTem);
    }
    
    jQuery("input[class='item_arvore']:checked").attr("checked", false);
}

function fntMostraConfigs()
{
    var nodo = jQuery("#tree").dynatree("getActiveNode");
    if (!nodo)
    {
        alert(traducoes.sSelItmConfText);
        return;
    }
    
    if (nodo.data.key.indexOf('raiz') == 0)
    {
        alert(traducoes.sItmRaizConfText);
        return;
    }
    
    fntWorking(true);
    var dados = "a=retpar&nodo=" + nodo.data.key;
    jQuery.ajax({
        type: 'post',
        url: 'ajaxsalvaitemmontagemcaso.php',
        data: dados,
        success:function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
                if (msg != "BRANCO")
                {
                    fntFillForm(msg, 'configs');
                }
                else
                {
                    fntLimpaForm(Array(), 'configs');
                }
                fntExibeOcultaConfs(msg);
                jQuery("#detnodos").hide();
                //jQuery("#configs").show();
                jQuery("#configs").dialog({ title: traducoes.sConfItemText + ' "' + nodo.data.title + '"' });
                jQuery("#nomenodoatual").html(nodo.data.title);
                if (jQuery("#txtConfig_3").val() != "")
                {
                    var node = jQuery("#tree").dynatree("getTree").getNodeByKey(jQuery("#txtConfig_3").val());
                    jQuery("#nomeconf3").html(node.data.title);
                }
                jQuery("#configs").dialog("open");
                fntWorking(false);
            }
            else
            {
                fntWorking(false);
                alert(msg);
            }
        },
        error:function(http, text, err){
            fntWorking(false);
            alert(http + ' ' + text + ' ' + err);
        }
    });
}

function fntSalvaConfigs()
{
    var nodo = jQuery("#tree").dynatree("getActiveNode");
    if (!nodo)
    {
        alert(traducoes.sSelItmConfText);
        return;
    }
    fntWorking(true);
    var string = fntSerializa("tab-configs", true);
    string = "a=par&" + string + "&nodo=" + nodo.data.key;
    jQuery.ajax({
        type: 'post',
        url: 'ajaxsalvaitemmontagemcaso.php',
        data: string,
        success:function(msg){
            if (msg.indexOf('ERRO') != -1)
            {
                fntWorking(false);
                alert(msg);
            }
            else
            {
                fntWorking(false);
                alert(traducoes.sConfSalvoOKText);
            }
        },
        error:function(http, text, err){
            fntWorking(false);
            alert(http + ' ' + text + ' ' + err);
        }
    });
}

function fntVoltaTelaOpcoes()
{
    location.href = 'vwcaso.php';
}

function fntArvoreSalto(opcao)
{
    if ((opcao == 'cond') && (jQuery("#nodeDes").val() == ''))
    {
        alert(traducoes.sSelPriItmDestText);
        return false;
    }
    
    var dados = "tip=tree&id=treesalto";
    jQuery.ajax({
        type: "post",
        url: "ajaxtreesalto.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
                jQuery("#divArvoreSalto").html(msg);
                jQuery("#hidOpcao").val(opcao);
                fntInstanciaArvoreSalto();
                fntExibeArvoreSalto();
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

function fntArvoreExames()
{
    var dados = "tip=tree&id=treeexames";
    jQuery.ajax({
        type: "post",
        url: "ajaxtreesalto.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
                jQuery("#divArvoreExames").html(msg);
                fntInstanciaArvoreExames();
                fntExibeArvoreExames();
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

function fntInstanciaArvoreSalto()
{
    jQuery("#treesalto").dynatree({
        selectMode: 1
    });
}

function fntInstanciaArvoreExames()
{
    jQuery("#treeexames").dynatree({
        selectMode: 1
    });
}

function fntExibeArvoreSalto()
{
    if (jQuery("#nodeDes").val() != "")
    {
        var tree = jQuery("#treesalto").dynatree("getTree");
        tree.activateKey(jQuery("#nodeDes").val());
        var node = tree.getNodeByKey(jQuery("#nodeDes").val());
        node.data.select = true;
        node.toggleExpand();
    }
    jQuery("#divArvoreSalto").dialog("open");
}

function fntExibeArvoreExames()
{
    fntWorking(true);
    if (jQuery("#txtConfig_3").val() != "")
    {
        var tree = jQuery("#treeexames").dynatree("getTree");
        tree.activateKey(jQuery("#txtConfig_3").val());
        var node = tree.getNodeByKey(jQuery("#txtConfig_3").val());
        node.data.select = true;
        node.toggleExpand();
    }
    jQuery("#divArvoreExames").dialog("open");
    fntWorking(false);
}

function fntSetaOpcao()
{
    if (jQuery("#hidOpcao").val() == "des")
    {
        return fntSetaDestino();
    }
    else if (jQuery("#hidOpcao").val() == "cond")
    {
        return fntSetaCondicao();
    }
}
function fntSetaDestino()
{
    var nodo = jQuery("#treesalto").dynatree("getActiveNode");
    if (!nodo)
    {
        alert(traducoes.sSelItmDestText);
        return false;
    }
    
    if (nodo.data.key.split('_')[0] == "raiz")
    {
        return true;
    }
    
    if (nodo.data.key.split('_')[0] == "cont")
    {
        alert(traducoes.sSelAgruText);
        return false;
    }
    
    jQuery("#nodeDes").val(nodo.data.key);
    jQuery("#nomenododes").html(nodo.data.title);
    return true;
}

function fntSetaCondicao()
{
    var nodo = jQuery("#treesalto").dynatree("getActiveNode");
    if (!nodo)
    {
        alert(traducoes.sSelItmDestText);
        return false;
    }
    
    var arrComposicao = nodo.data.key.split('_');
    if (arrComposicao[0] == "raiz")
    {
        return true;
    }
    
    if (arrComposicao[0] == "cont")
    {
        alert(traducoes.sSelContText);
        return false;
    }
    
    jQuery("#nodeCond").val(nodo.data.key);
    jQuery("#nomenodocond").html(nodo.data.title);
    if ((arrComposicao[1] == 'perg') || (arrComposicao[1] == 'grupo-perg'))
    {
        fntBuscaPerguntas(nodo.data.key);
    }
    else
    {
        jQuery("#opcoes-perguntas-config").hide();
        jQuery("#selPerguntaConfig").html("");
        fntBuscaOpcoes(nodo.data.key);
    }
    
    return true;
}

function fntSetaOpcoesExame()
{
    var nodo = jQuery("#treeexames").dynatree("getActiveNode");
    if (!nodo)
    {
        alert(traducoes.sSelItmOptExText);
        return false;
    }
    
	alert(nodo.data.key);
	
    if (nodo.data.key.split('_')[1] == "raiz")
    {
        return true;
    }
    
    if (nodo.data.key.split('_')[1] != "optex")
    {
        alert(traducoes.sSelItmOptExText);
        return false;
    }
    
    jQuery("#txtConfig_3").val(nodo.data.key);
    jQuery("#nomeconf3").html(nodo.data.title);
    return true;
}

function fntPreBuscaOpcoes()
{
    if (jQuery("#selPerguntaConfig").val() != "-1")
    {
        fntBuscaOpcoes(jQuery("#nodeCond").val(), jQuery("#selPerguntaConfig").val());
    }
    else
    {
        jQuery("#opcoes-resposta-config").html("");
    }
}

function fntBuscaOpcoes(nodo, perg)
{
    var dados = "tip=opts&nodo=" + nodo;
    
    if (typeof(perg) != "undefined")
        dados += "&perg=" + perg;
    
    jQuery.ajax({
        type: 'post',
        url: "ajaxtreesalto.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO:") == -1)
            {
                jQuery("#opcoes-resposta-config").html(getXMLValue(msg, 'conteudo'));
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

function fntBuscaPerguntas(nodo)
{
    var dados = "tip=pergs&nodo=" + nodo;
    
    jQuery.ajax({
        type: 'post',
        url: "ajaxtreesalto.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO:") == -1)
            {
                jQuery("#selPerguntaConfig").html(msg);
                jQuery("#opcoes-perguntas-config").show();
                jQuery("#opcoes-resposta-config").html("");
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

function fntSalvaDesvio()
{
    if (jQuery("#nodeDes").val() != "")
    {
        var salvar = true;
        var nodo = jQuery("#tree").dynatree("getActiveNode");
        var dados = "nodoatual=" + nodo.data.key;
        dados += "&nododes=" + jQuery("#nodeDes").val();
        
        //verificar se tem condição
        if (jQuery("#nodeCond").val() != "")
        {
            dados += "&nodocond=" + jQuery("#nodeCond").val();
            var tipo = jQuery("#nodeCond").val().split('_');
            if ((tipo[1] == "perg") || (tipo[1] == "grupo-perg"))
            {
                if ((jQuery("#selPerguntaConfig").val() != "") && (jQuery("#selPerguntaConfig").val() != "-1"))
                {
                    dados += "&perg=" + jQuery("#selPerguntaConfig").val();
                    
                    var soma = 0;
                    jQuery("input[class='opcao-resposta']:checked").each(function(){
                        soma += parseInt(jQuery(this).val());
                    });
                    
                    if (soma != 0)
                    {
                        dados += "&resp=" + soma;
                    }
                    else
                    {
                        alert(traducoes.sSelOptRespText);
                        salvar = false;
                    }
                }
                else
                {
                    alert(traducoes.sSelPergText);
                    salvar = false;
                }
            }
            else
            {
                var soma = 0;
                jQuery("input[class='opcao-resposta']:checked").each(function(){
                    soma += parseInt(jQuery(this).val());
                });
                
                if (soma != 0)
                {
                    dados += "&resp=" + soma;
                }
                else
                {
                    alert(traducoes.sSelOptRespText);
                    salvar = false;
                }
            }
        }
        
        if (salvar)
        {
            dados = "tip=salvacond&" + dados;
            jQuery.ajax({
                type: 'post',
                url: "ajaxtreesalto.php",
                data: dados,
                success: function(msg){
                    if (msg.indexOf("ERRO:") == -1)
                    {
                        jQuery("#divDesviosSalvos").html(msg);
                        fntFormagaGrid();
                        fntLimpaTudo();
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
    }
    else
    {
        alert(traducoes.sCondSelItmDText);
    }
}

function fntMudaPrioridade(maismenos, ori, des)
{
    var dados = "tip=mudaprior&mm=" + maismenos + "&chaveOri=" + ori + "&chaveDest=" + des;
    jQuery.ajax({
        type: 'post',
        url: "ajaxtreesalto.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO:") == -1)
            {
                jQuery("#divDesviosSalvos").html(msg);
                fntFormagaGrid();
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

function fntDeletaSalto(ori, des)
{
    if (confirm(traducoes.sConfDelDesCText))
    {
        var dados = "tip=delsalto&chaveOri=" + ori + "&chaveDest=" + des;
        jQuery.ajax({
            type: 'post',
            url: "ajaxtreesalto.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO:") == -1)
                {
                    jQuery("#divDesviosSalvos").html(msg);
                    fntFormagaGrid();
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
}

function fntMarcaDesmarca(id)
{
    return true;
}

function fntVincularAnexoitem()
{
    if (jQuery("#selConteudos").val() != "")
    {
        var nodo = jQuery("#tree").dynatree("getActiveNode");
        if (!nodo)
        {
            alert(traducoes.sSelItmContComText);
            return;
        }
        
        var dados = "tip=vincanexo&item=" + nodo.data.key + "&cont=" + jQuery("#selConteudos").val();
        jQuery.ajax({
            type: 'post',
            url: "ajaxtreesalto.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO:") == -1)
                {
                    jQuery("#divAnexosSalvos").html(msg);
                    fntFormagaGrid();
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
        alert(traducoes.sSelPrimContText);
    }
}

function fntDeletaAnexo(i, c)
{
    if (confirm(traducoes.sConfDelMatCmpText))
    {
        var dados = "tip=delanexo&item=" + i + "&cont=" + c;
        jQuery.ajax({
            type: 'post',
            url: "ajaxtreesalto.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO:") == -1)
                {
                    jQuery("#divAnexosSalvos").html(msg);
                    fntFormagaGrid();
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
}