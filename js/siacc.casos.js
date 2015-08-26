/*!
 * SIACC - Sistema Interdiciplinar de Análise de Casos Clínicos
 * http://siacc.regisls.net
 *
 * Copyright (c) 2011 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * fn-casos.js
 * Data: 01/09/2011 22:16 - Quinta-feira
 * Data revisão: 17/12/2013 22:54 - Terça-feira
 * Revisão: 35
 * Tradução: OK
 */

// traduzido até a linha 312
 
var addBase = "";//forma base para o durante da tela
var addBaseCompleto = "";//forma completa para quando a tela é trocada

// Funções diversas da página
function fntLoadTela(tela, local)
{
    var dados = "t=" + tela;

    fntWorking(true);

    //Passa o local	para resgatar depois
    if(local!=null)
    {
    	dados += "&localUpdate=" + local;
    }
    if(local == "sec")
    {
    	jQuery(".pri").hide();
    	jQuery(".sec").show();
    }
    else
    {
    	jQuery(".pri").show();
    	jQuery(".sec").hide();
    }

    ecad = typeof(ecad) != "undefined" ? ecad : "";
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: "ajaxcasoparte.php",
        data: dados,
        success: function(msg){
            
            //Se local for nulo faz o de sempre...
            if(getXMLValue(msg, "localUpdate") != "")
            {
    			jQuery("#dinamico").find(("."+getXMLValue(msg, "localUpdate"))).html(
    				((getXMLValue(msg, "localUpdate") == "sec") ? getXMLValue(msg, "conteudo") : jQuery(getXMLValue(msg, "conteudo")).find(("."+getXMLValue(msg, "localUpdate"))).html())
    			);
	            jQuery("#toolbar > .cont-sup > ul").html(getXMLValue(msg, "menu"));
	            jQuery("#caminho").html(getXMLValue(msg, "caminho"));
                fntInicializaEditor('300px', '160px');
	            fntFormagaGrid();
            }
            else
            {
                fntLimpaTela();           
	            jQuery("#dinamico").html(getXMLValue(msg, "conteudo"));
	            jQuery("#toolbar > .cont-sup > ul").html(getXMLValue(msg, "menu"));
	            jQuery("#caminho").html(getXMLValue(msg, "caminho"));

	            //Start das áeras de backup para reiniciar
	            addBase = jQuery(".dlg:not(#dlg-add-anexos)").html();
	            addBaseCompleto = jQuery(".dlg:not(#dlg-add-anexos)").clone();
	            //Start das funções por aqui e não pelo arquivo .html
	            fntFormagaGrid();
	            fntInicializaAbas();
                fntInicializaEditor('300px', '160px');
                fntInicializaDialogo(traducoes.sAddRegText);
            }
            fntWorking(false);
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}
//fora de uso
function fntLimpaTela()
{
    /*
    jQuery("body").children(":gt(3)").remove();
    
    jQuery("div[class='dlg']").dialog("destroy");
    jQuery(".ui-dialog").each(function(){
        jQuery(this).remove();
    });
    */
}

//function fntLoadItem(tela, reg)
//{
//    var url = tela + "&r=" + reg;
//    var field = 'cad' + tela;
//    fntLoadTela(url, field);
//}

function fntLoadItemDetalhes(tela, reg)
{
    var url = tela + "&d=1";
    
    if (typeof(reg) != "undefined")
        url += "&r=" + reg;
        
    fntLoadTela(url, 'sec');
}

//funcao para menu e caminho
function fntLoadMenuCaminho(tela){
	var dados = "t=" + tela;
    ecad = typeof(ecad) != "undefined" ? ecad : "";
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: "ajaxcasoparte.php",
        data: dados,
        success: function(msg){
            jQuery("#toolbar > .cont-sup > ul").html(getXMLValue(msg, "menu"));
            jQuery("#caminho").html(getXMLValue(msg, "caminho"));
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}
function fntVoltar(tela){
	//no voltar a tela principal (agora uma div) é apresentada e a div detalhes volta a ficar oculta
	jQuery(".pri").show();
	jQuery(".sec").hide();
	jQuery("div[id^='dlg']").each(function(){
		jQuery(this).dialog().remove();
	});
	fntLoadMenuCaminho(jQuery("#etapa").val());
	//como todo os dialogos foram removidos, agora recoloco ele depois da div principal do arquivo...
	jQuery(".pri").after(addBaseCompleto);
	//rodo as funções básicas
	fntInicializaAbas();
	fntInicializaEditor('300px', '160px');
    fntInicializaDialogo(traducoes.sAddRegText);
}

function fntTelaInicial()
{
    var local = window.location;
    
    location.href = local;
}

function fntCancelarEdicao()
{
    fntLoadTela( jQuery("#etapa").val() );
}

function fntGravaEtapaCaso()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }

    //fntWorking(true);

    var string = fntSerializa();
    var destino = jQuery("#etapa").val();
    
    jQuery.ajax({
        type: "post",
        url: "actgravacaso.php",
        data: string,
        success: function(msg){
            fntWorking(false);
            if(destino == "basicos")
            {
            	if (msg.indexOf("OK") == 0)
            	{
            		alert(traducoes.sSalvoOKText);
	                jQuery("#dlg-add-" + destino).dialog("close");
	                //Retirar o load da tela toda e só atualizar a tabela (id do local)
	                if(window.location.href.indexOf("?act=new") >= 0)
	                	location.href = "vwcaso.php?cod=" + msg.substring(2);
	                else
	                	fntLoadTela(destino, 'itenscad');
            	}
                else
                {
                    alert(msg);
                }
            }
            else if (msg == "OK")
            {
            	alert(traducoes.sSalvoOKText);
                jQuery("#dlg-add-" + destino).dialog("close");
                fntLoadTela(destino, 'itenscad');
            }
            else
            {
                alert(msg);
            }
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}

function fntInicializaEditor(altura, largura)
{
	//TIAGO URIARTT - toda vez que o tiny é iniciado remove tudo. Bosta de Tiny
	jQuery('textarea.tinymce').each(function(){
		try{
		    jQuery(this).tinymce().remove();
		}catch(e){}
	});
    jQuery('textarea.tinymce').tinymce({
        script_url : 'js/tiny_mce/tiny_mce.js',
        convert_urls : false,
        theme : "advanced",
        plugins : "style,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        //height : altura,
        //width: largura,
        readonly: 0,
        language: 'pt',
        
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        //theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        external_image_list_url : "loadmidia.php?type=img"
    });
}

function fntMostraAcaoTexto(id)
{
    jQuery.ajax({
        type: 'post',
        url: 'ajaxlistaconteudos.php',
        success: function(msg){
            jQuery("#selURL").html(msg);
        },
        error: function(x, y, z){
            alert('Erro: ' + x + ' ' + y + ' ' + z);
        }
    })
    
    jQuery("#hdnSelectedTextArea").val(id);
    jQuery("#selAcoes").val('');
    jQuery("#selURL").val('');
    jQuery('#divOpcoesAcao').toggle();
    fntCentralizaDivTela("#divOpcoesAcao");
}

function fntAddAcaoTexto()
{
    var act = jQuery("#selAcoes").val();
    var url = jQuery("#selURL").val();
    var funcao = "";
    switch(act)
    {
        case 'click':
            funcao = "fntMostraPopUp('" + url + "');";
            break;
        case '':
            return;
    }
    
    if ($('#'+$("#hdnSelectedTextArea").val()).tinymce().selection.getContent({format : 'text'}) != '')
    {
        $('#'+$("#hdnSelectedTextArea").val()).tinymce().execCommand('mceReplaceContent',false,'<a href="javascript:void(0);" onclick="javascript:' + funcao + '">{$selection}</a>');
        $('#divOpcoesAcao').toggle();
    }
    else
    {
        jQuery("#selAcoes").val('');
        jQuery("#txtURL").val('');
        $('#divOpcoesAcao').toggle();
    }
}

function fntMostraPopUp(url)
{
    return;
}

function fntInicializaDialogo(titulo)
{
    titulo = ((typeof(titulo) == "undefined") ? traducoes.sAddRegText : titulo);
    var jaTem = false;
    //TIAGO URIARTT - segue vendo se tem ou não o dialogo da etapa
    jQuery("div[id^='dlg']").each(function(){
    	if(jQuery(this).data("dialog"))
    		if(jQuery(this).attr("id") == ("#dlg-add-" + jQuery("#etapa").val()))
    			jaTem = true;
    });
    if(jaTem)
    {/*Ja tem*/}
    else
    {//não tem
		var botoes = {};
		botoes[traducoes.sSalvarText] = function() { fntGravaEtapaCaso(); };
		botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close");  };
        
		jQuery(".dlg:not(#dlg-add-anexos)").dialog({
		    autoOpen: false,
		    cache: false,
		    width: 800,
		    height: 550,
		    title: traducoes.sAddEditRegText,
		    buttons: botoes
        });
    }
}

function fntGravaRelacoes()
{
    return true;
}

function fntRelacoes(reg)
{
    var dados = "tipo=" + jQuery("#etapa").val() + "&r=" + reg
    
    jQuery.ajax({
        type: "post",
        url: "ajaxrelacoes.php",
        data: dados,
        success: function(msg){
            jQuery("#relacoes").html(getXMLValue(msg, "relacoes"));
            jQuery("#dlg-rel-" + jQuery("#etapa").val()).dialog('open');
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntInicializaAbas()
{
    jQuery("#tabs").tabs({
        selected: 0
    });
}

function fntExibeCadastro(idCad)
{
    if (typeof(idCad) == "undefined")
    {
         jQuery(".dlg").dialog("open");
    }
    else
    {
        jQuery("#" + idCad).css("display", "");
        jQuery("#cmdNovo").css("display", "none");
    }
}

function fntExibeCadastroEtapa(cod)
{
    var dados = "t=" + jQuery("input[name='etapa']").val() + "&dlg=1";
    
    if (typeof(cod) != "undefined")
        dados += "&r=" + cod;
    
    jQuery.ajax({
        type: "post",
        url: "ajaxcasoparte.php",
        data: dados,
        success: function(msg){
            //TIAGO URIARTT - Sempre no durante usar a inicialização base do local de cadastro
            jQuery("#dlg-add-" + jQuery("#etapa").val()).html(addBase);
            fntFillForm(msg, ("dlg-add-" + jQuery("#etapa").val()));
            //TIAGO URIARTT - Como está limpa, tem que rodar as abas e a porra do tiny
            fntInicializaAbas();
            fntInicializaEditor('300px', '160px');
            jQuery("#dlg-add-" + jQuery("#etapa").val()).dialog('open');
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntInicializaDialogoUPImagens()
{
    var botoes = {}
	botoes[traducoes.sEnviarText] = function() { document.getElementById("frameup").contentWindow.fntChamaUp(); };
	botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close");  };
	
	jQuery("#divUploadExame").dialog({
		autoOpen: false,
		width: 800,
		height: 470,
		title: traducoes.sProcImgText,
		buttons: botoes
    });
}
function fntInicializaDialogoUPDocumentos()
{
    var botoes = {}
	botoes[traducoes.sEnviarText] = function() { document.getElementById("frameupdoc").contentWindow.fntCarregaDocumentoSistemaInterna(); };
	botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close");  };

    jQuery("#divUploadDocExame").dialog({
		autoOpen: false,
		width: 800,
		height: 470,
		title: traducoes.sProcDocText,
		buttons: botoes
    });
}

function fntMostraOpcoesUpload()
{
    jQuery("#divUploadExame").dialog("open");
}

function fntMostraOpcoesUploadDoc()
{
    jQuery("#divUploadDocExame").dialog("open");
}

function fntFazUploadImagem()
{
    if(jQuery("#realupload").val() != "")
    {
        jQuery("#enviando").css("display", "");
        jQuery("#frmUploadImage").submit();
    }
    else if (jQuery("input[name^='chkUsar']:checked").length > 0)
    {
        var string = fntSerializa("divResultadoPesquisa");
        string += "&txtTipo=exame";
        jQuery.ajax({
            type: "post",
            url: "actgetimagemweb.php",
            data: string,
            success: function(msg){
                if (msg.indexOf("ERRO") == -1)
                {
                	alert(msg);
                    fntWorking(false);
                    fntListaArquivos();
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
    else if (jQuery("input[name^='chkDasMidias']:checked").length > 0)
    {
    	var string = fntSerializa("frmCarregaDasMidias");
        jQuery.ajax({
            type: "post",
            url: "actuploadexame.php",
            data: string,
            success: function(msg){
                if (msg.indexOf("ERRO") == -1)
                {
                	alert(msg);
                    fntWorking(false);
                    fntListaArquivos();
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
    else
    {
        alert(traducoes.sNenhumItemText);
    }
}

function fntFazAtualizacaoItemExame()
{
    jQuery("#enviando").css("display", "");
    jQuery("#frmAtualizaImage").submit();
}

function fntPreview()
{
    jQuery("#fakeupload").attr("value", jQuery("#realupload").val().substring(jQuery("#realupload").val().lastIndexOf("\\")+1));
}

function fntListaArquivos(ext)
{
    var pai = window.parent.document;
    var ext = ext || 'N';
    
    jQuery.ajax({
        type: "post",
        url: "ajaxlistaanexos.php",
        data: "context=" + ext,
        success: function(msg){
            if (ext == 'N')
            {
                jQuery("#lista-imgs", pai).html(getXMLValue(msg, "imgs"));
                jQuery("#lista-docs", pai).html(getXMLValue(msg, "docs"));
            }
            else
            {
                jQuery("#concad").html(msg);
            }
            fntFormagaGridParent(pai);
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntReloadConteudos()
{
    var pai = window.parent.document;
    
    jQuery.ajax({
        type: "post",
        url: "ajaxreloadconteudos.php",
        success: function(msg){
            alert(msg);
            jQuery("#concad", pai).html(getXMLValue(msg, "cont"));
            fntFormagaGridParent(pai);
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntSalvaTextoGuia(acao)
{
    fntWorking(true);
    var dados = "act=" + acao + "&txtPerguntaGuia=" + escape(jQuery("#txtPerguntaGuia").val())
    
    jQuery.ajax({
        type: "post",
        url: "ajaxcasosacoesextras.php",
        data: dados,
        success: function(msg){
            fntWorking(false);
            if (msg != "")
                alert(msg);
            else
                alert(traducoes.sSalvoOKText);
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}

function fntExcluiObjetivo(r)
{
    if (confirm(traducoes.sConfDelObjText))
    {
        var dados = "etapa=objetivos&id=" + r;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdelcaso.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") >= 0)
                    alert(msg);
                else
                {
                	alert(traducoes.sDelSucessoText);
                	fntLoadTela("objetivos", "itenscad");
                }
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}

function fntDeletaImgExame(r)
{
    if (confirm(traducoes.sConfDelImgText))
    {
        var dados = "act=delimgexame&r=" + r;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxcasosacoesextras.php",
            data: dados,
            success: function(msg){
                if (msg != "")
                    alert(msg);
                else
                {
                	alert(traducoes.sDelSucessoText);
                    fntListaArquivos();
                }
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}
function fntDeletaDocExame(r)
{
    if (confirm(traducoes.sConfDelDocText))
    {
        var dados = "act=deldocexame&r=" + r;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxcasosacoesextras.php",
            data: dados,
            success: function(msg){
                if (msg != "")
                    alert(msg);
                else
                {
                	alert(traducoes.sDelSucessoText);
                    fntListaArquivos();
                }
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}
function fntDeletaTratamento(id)
{
    if (confirm(traducoes.sConfDelTraText))
    {
        var dados = "etapa=tratamentos&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdelcaso.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") != 0)
                {
                    alert(traducoes.sDelSucessoText);
                    fntLoadTela("tratamentos", "itenscad");
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

function fntDeletaDiagnostico(id)
{
    if (confirm(traducoes.sConfDelDiaText))
    {
        var dados = "etapa=diagnosticos&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdelcaso.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") != 0)
                {
                    alert(traducoes.sDelSucessoText);
                    fntLoadTela("diagnosticos", "itenscad");
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

function fntDeletaDesfecho(id)
{
    if (confirm(traducoes.sConfDelDesText))
    {
        var dados = "etapa=desfechos&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdelcaso.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") != 0)
                {
                    alert(traducoes.sDelSucessoText);
                    fntLoadTela("desfechos", "itenscad");
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

function fntDeletaConteudosHipertexto(id)
{
    if (confirm(traducoes.sConfDelHtmText))
    {
        var dados = "etapa=conteudos&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdelcaso.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") != 0)
                {
                    alert(traducoes.sDelSucessoText);
                    fntLoadTela("conteudos", "itenscad");
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

function fntDeletaHipotese(id)
{
    if (confirm(traducoes.sConfDelHipText))
    {
        var dados = "etapa=hipoteses&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdelcaso.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") != 0)
                {
                    alert(traducoes.sDelSucessoText);
                    fntLoadTela("hipoteses", "itenscad");
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

function fntDeletaExame(id)
{
    if (confirm(traducoes.sConfDelExaText))
    {
        var dados = "etapa=exames&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdelcaso.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") != 0)
                {
                    alert(traducoes.sDelSucessoText);
                    fntLoadTela("exames", "itenscad");
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

function fntSalvaResultadosExame()
{
    fntWorking(true);
    var string = fntSerializa("divfilho");
    
    string = "act=salvaresexame&" + string;
    jQuery.ajax({
        type: "post",
        url: "ajaxcasosacoesextras.php",
        data: string,
        success: function(msg){
            fntWorking(false);
            if (msg != "")
                alert(msg);
            else
                alert(traducoes.sSalvoOKText);
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}

function fntAtualizaItemExame()
{
    document.getElementById("atualizaimgexm").contentWindow.fntChamaAtualizacao();
}

function fntRetornoAtualizacaoItemExame(msg, reg)
{
    if (msg == "OK")
    {
        fntLoadItemDetalhes('exames', reg);
    }
    else
    {
        fntLoadItemDetalhes('atualizaexame', reg);
        alert(msg);
    }
}

function fntGravaOrdenacao()
{
    var itens = "";
    var destino = jQuery("#etapa").val();
    
    jQuery("ul[id='sortable']").children('li').each(function(){
        itens += "item[]=" + jQuery(this).attr("id") + "&";
    });
    itens = "etapa=" + destino + "&" + itens.substring(0, itens.length-1);
    
    jQuery.ajax({
        type: "post",
        url: "actgravacaso.php",
        data: itens,
        success: function(msg){
            if (msg == "OK")
            {
                alert(traducoes.sSalvoOKText);
                fntLoadTela(destino);
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

function fntInstanciaEfeitosExameFisico()
{
    jQuery("#txtExaFisGeral").focus(function(){
        jQuery("#marca-corpo").fadeIn(800);
        jQuery("#selAtual").val("midGeral");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisGeral").blur(function(){
        jQuery("#marca-corpo").fadeOut(1000);
    });
    
    jQuery("#txtExaFisCabeca").focus(function(){
        jQuery("#marca-cabeca").fadeIn(800);
        jQuery("#selAtual").val("midCabeca");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisCabeca").blur(function(){
        jQuery("#marca-cabeca").fadeOut(1000);
    });
    
    jQuery("#txtExaFisAusPulmonar").focus(function(){
        jQuery("#marca-pulmao").fadeIn(800);
        jQuery("#selAtual").val("midAusPulmonar");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisAusPulmonar").blur(function(){
        jQuery("#marca-pulmao").fadeOut(1000);
    });
    
    jQuery("#txtExaFisPescoco").focus(function(){
        jQuery("#marca-pescoco").fadeIn(800);
        jQuery("#selAtual").val("midPescoco");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisPescoco").blur(function(){
        jQuery("#marca-pescoco").fadeOut(1000);
    });
    
    jQuery("#txtExaFisAusCardiaca").focus(function(){
        jQuery("#marca-coracao").fadeIn(800);
        jQuery("#selAtual").val("midAusCardiaca");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisAusCardiaca").blur(function(){
        jQuery("#marca-coracao").fadeOut(1000);
    });
    
    jQuery("#txtExaFisAbdomen").focus(function(){
        jQuery("#marca-abdomen").fadeIn(800);
        jQuery("#selAtual").val("midAbdomen");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisAbdomen").blur(function(){
        jQuery("#marca-abdomen").fadeOut(1000);
    });
    
    jQuery("#txtExaFisExtrem").focus(function(){
        jQuery("div[id^='marca-extremidades']").fadeIn(800);
        jQuery("#selAtual").val("midExtrem");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisExtrem").blur(function(){
        jQuery("div[id^='marca-extremidades']").fadeOut(1000);
    });
    
    jQuery("#txtExaFisPele").focus(function(){
        jQuery("div[id^='marca-pele']").fadeIn(800);
        jQuery("#selAtual").val("midPele");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisPele").blur(function(){
        jQuery("div[id^='marca-pele']").fadeOut(1000);
    });
    
    jQuery("#txtExaFisSinVit").focus(function(){
        jQuery("div[id^='marca-sinais']").fadeIn(800);
        jQuery("#marca-coracao").fadeIn(800);
        jQuery("#selAtual").val("midSinVit");
        fntRevelaMidiasEtapa();
    });
    jQuery("#txtExaFisSinVit").blur(function(){
        jQuery("div[id^='marca-sinais']").fadeOut(1000);
        jQuery("#marca-coracao").fadeOut(1000);
    });
    
    jQuery(".chkmidias").click(function(){
        fntAtualizaMidiasEtapaExame();
    });
    
}

function fntAtualizaMidiasEtapaExame()
{
    var total = 0;
    jQuery("input[name='chkMidia[]']:checked").each(function(){
        total += parseInt(jQuery(this).val(), 10);
    });
    
    jQuery("#"+jQuery("#selAtual").val()).val(total);
}

function fntRevelaMidiasEtapa()
{
    var valor = jQuery("#"+jQuery("#selAtual").val()).val();
    var titulo = "";
    
    switch(jQuery("#selAtual").val())
    {
        case "midGeral":
            titulo = traducoes.sTitEFEstGerText;
            break;
        case "midCabeca":
            titulo = tradcoes.sTitEFCabecaText;
            break;
        case "midPescoco":
            titulo = traducoes.sTitEFPescText;
            break;
        case "midAusPulmonar":
            titulo = traducoes.sTitEFAusPulText;
            break;
        case "midAusCardiaca":
            titulo = traducoes.sTitEFAusCarText;
            break;
        case "midAbdomen":
            titulo = traducoes.sTitEFAbdText;
            break;
        case "midExtrem":
            titulo = traducoes.sTitEFExtText;
            break;
        case "midPele":
            titulo = traducoes.sTitEFPeleText;
            break;
        case "midSinVit":
            titulo = traducoes.sTitEFSinVitText;
            break;
    }
    jQuery("#titmidias").html(traducoes.sMidiasText + " (" + titulo + ")");
    
    
    if (valor == 0)
        jQuery("input[name='chkMidia[]']:checked").each(function(){
            jQuery(this).attr("checked", false);
        });
    else
        jQuery("input[name='chkMidia[]']").each(function(){
            if ((valor & parseInt(jQuery(this).val(), 10)) > 0)
                jQuery(this).attr("checked", true);
            else
                jQuery(this).attr("checked", false);
        });
}

function fntGravaConfiguracoes()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }
    
    var dados = fntSerializa();
    
    jQuery.ajax({
        type: "post",
        url: "actgravaconfigs.php",
        data: dados,
        success: function(msg){
            if (msg == "OK")
            {
                alert(traducoes.sSalvoOKText);
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

function fntCopiaDescricaoPadrao()
{
    if (jQuery("#selTipoExame").val() != "")
    {
        jQuery("#txtDescricao").val(jQuery("#selTipoExame option:selected").text());
    }
}

function fntPublicaCaso()
{
    if (confirm(traducoes.sConfPubCasoText))
    {
        fntWorking(true);
        var dados = "p=true";
        jQuery.ajax({
            type: "post",
            url: "ajaxpubcaso.php",
            data: dados,
            success: function(msg){
                fntWorking(false);
                if (msg == "OK")
                {
                    alert(traducoes.sPubOKText);
                    fntTelaInicial();
                }
                else
                {
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

function fntDespublicaCaso()
{
    if (confirm(traducoes.sConfDePubCasoText))
    {
        fntWorking(true);
        var dados = "p=false";
        jQuery.ajax({
            type: "post",
            url: "ajaxpubcaso.php",
            data: dados,
            success: function(msg){
                fntWorking(false);
                if (msg == "OK")
                {
                    alert(traducoes.sCasoPutText);
                    fntTelaInicial();
                }
                else
                {
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

function fntNovaVersao()
{
    if (confirm(traducoes.sConfGeraVerText))
    {
        fntWorking(true);
        dados = "act=nvc";  // nova versão do caso
        
        jQuery.ajax({
            type: "post",
            url: "ajaxcasosacoesextras.php",
            data: dados,
            success: function(msg){
                fntWorking(false);
                if (msg == "OK")
                {
                    alert(traducoes.sGeraVerOKText);
                    fntTelaInicial();
                }
                else
                {
                    alert(msg);
                }
            },
            error: function(http, text, err){
                fntWorking(false);
                alert(text);
            }
        });
        
        fntWorking(false);
    }
}

function fntContExames()
{
    var botoes = {};
	botoes[traducoes.sFinalizarText] = function() { jQuery(this).dialog("close"); };
	jQuery("#dlg-add-anexos").dialog({
	    autoOpen: false,
	    cache: false,
	    width: 800,
	    height: 550,
	    title: traducoes.sAnexosText,
	    buttons: botoes
    });
    
    jQuery("#dlg-add-anexos").dialog('open');
}

function fntBuscaExamesBateria()
{
    if (jQuery("#selBaterias").val() != "")
    {
        var dados = "nb=" + jQuery("#selBaterias").val();
        
        jQuery.ajax({
            type: "post",
            url: "ajaxexamesbateria.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") == -1)
                {
                    jQuery("#selExames").html(msg);
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

function fntSalvaConteudosExames()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }

    fntWorking(true);

    var string = fntSerializa();
    string = string += "&act=svce";
    
    jQuery.ajax({
        type: "post",
        url: "ajaxcasosacoesextras.php",
        data: string,
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
            	alert(traducoes.sSalvoOKText);
            	jQuery("#divResultado").html(msg);
            }
            else
            {
            	alert(msg)
                fntWorking(false);
            }
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}

function fntDeletaConteudosExames(cont)
{
    fntWorking(true);

    jQuery.ajax({
        type: "post",
        url: "ajaxcasosacoesextras.php",
        data: ("act=rvce&selConteudo="+cont),
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
            	alert(traducoes.sDelSucessoText);
            	jQuery("#divResultado").html(msg);
            }
            else
            {
            	alert(msg)
                fntWorking(false);
            }
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}

function fntPreviewCaso(c, t)
{
    c = c || jQuery("hdnCodCaso").val();
    t = t || jQuery("input[name='rdoTipoPreview']:checked").val();
    
    var janela = window.open("vwresolucao-offline.php?m=pre&c=" + c + "&t=" + t);
}

function fntRedirect(t)
{
    t = 'vw'+t+'.php';
    location.href = t;
}

function fntCarregaImagemSistema()
{
    document.getElementById("upImagem").contentWindow.fntCarregaImagemSistemaInterna();
}

function fntCarregaAudioSistema()
{
    document.getElementById("upAudio").contentWindow.fntCarregaAudioSistemaInterna();
}

function fntCarregaVideoSistema()
{
    document.getElementById("upVideo").contentWindow.fntCarregaVideoSistemaInterna();
}

function fntCarregaDocumentoSistema()
{
    document.getElementById("upDocumento").contentWindow.fntCarregaDocumentoSistemaInterna();
}

function fntCarregaImagemSistemaBase()
{
    var tab = jQuery("#tabs").tabs('option', 'selected');
    
    if (tab == 0)
    {
        jQuery("#txtTipo").val("conteudo");
        jQuery("#frmUploadImage").submit();
    }
    else if (tab == 1)
    {
        if (jQuery("input[name^='chkUsar']:checked").length > 0)
        {
            var string = fntSerializa("divResultadoPesquisa");
            jQuery.ajax({
                type: "post",
                url: "actgetimagemweb.php",
                data: string,
                success: function(msg){
                    if (msg.indexOf("ERRO") == -1)
                    {
                        jQuery("#divResultado").html(msg);
                        fntFormagaGrid();
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
        else
        {
            alert(traducoes.sNenhumItemText);
        }
    }
}

function fntCarregaAudioSistemaBase()
{
    jQuery("#txtTipo").val("conteudo");
    jQuery("#frmUploadAudio").submit();
}

function fntCarregaVideoSistemaBase()
{
    jQuery("#txtTipo").val("conteudo");
    jQuery("#frmUploadVideo").submit();
}

function fntCarregaDocumentoSistemaBase()
{
    if(jQuery("#frmUploadDocumento").find("#realupload").val() != "")
    {
    	jQuery("#txtTipo").val("documento");
        jQuery("#frmUploadDocumento").submit();
    }
    else if (jQuery("#frmCarregaDasMidiasDoc").find("input[name^='chkDasMidias']:checked").length > 0)
    {
    	var string = fntSerializa("frmCarregaDasMidiasDoc");
        jQuery.ajax({
            type: "post",
            url: "actuploaddocumento.php",
            data: string,
            success: function(msg){
                if (msg.indexOf("ERRO") == -1)
                {
                	alert(msg);
                    fntWorking(false);
                    fntListaArquivos();
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
    else
    {
        alert(traducoes.sNenhumItemText);
    }
}

function fntTelaUploadImg(tipo, exame)
{
    fntFechaTelasExtras();
	fntDefineTamanhoTela("#boxUpload");
    fntCentralizaDivTela("#boxUpload");
    jQuery("#boxUpload").draggable({
        handle: ".titlebar"
    }).show();
    document.getElementById("upImagem").contentWindow.fntSetaTipoImagem(tipo, exame);
}

function fntTelaUploadAudio(tipo, exame)
{
    fntFechaTelasExtras();
    fntCentralizaDivTela("#boxUploadAudio");
    jQuery("#boxUploadAudio").draggable({
        handle: ".titlebar"
    }).show();
    document.getElementById("upAudio").contentWindow.fntSetaTipoAudio(tipo);
}

function fntTelaUploadVideo(tipo, exame)
{
    fntFechaTelasExtras();
    fntCentralizaDivTela("#boxUploadVideo");
    jQuery("#boxUploadVideo").draggable({
        handle: ".titlebar"
    }).show();
    document.getElementById("upVideo").contentWindow.fntSetaTipoVideo(tipo, exame);
}

function fntTelaUploadDocumento(tipo, exame)
{
    fntFechaTelasExtras();
    fntCentralizaDivTela("#boxUploadDocumento");
    jQuery("#boxUploadDocumento").draggable({
        handle: ".titlebar"
    }).show();
    document.getElementById("upDocumento").contentWindow.fntSetaTipoDocumento(tipo);
}

function fntPreviewImagem(url, local)
{
    var tipo = jQuery("#"+url).val().substr(jQuery("#"+url).val().lastIndexOf(".")+1);
    if ((tipo == 'jpg') || (tipo == 'gif') || (tipo == 'png'))
    {
        jQuery("#"+local).html('<img src="' + jQuery("#"+url).val() + '" />');
    }
    else
    {
        jQuery("#"+local).html('');
        alert(traducoes.sArqInvalidoText);
    }
}

function fntFechaUP(id)
{
    jQuery("#"+id).hide();
}

function fntFechaViewImagem()
{
    jQuery("#boxViewImagem").find("#content").html('');
    jQuery("#boxViewImagem").hide();
}

function fntViewImagem(cod)
{
    fntFechaTelasExtras();
    jQuery("#boxViewImagem").find("#content").html('<img class="img-preview-grande" src="viewimagem.php?img=' + cod + '" alt="' + traducoes.sTitleImgText + '" title="' + traducoes.sTitleImgText + '">');
    jQuery("#boxViewImagem").show();
    fntCentralizaDivTela("#boxViewImagem");
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
                alert(getXMLValue(msg, "player"));
				
				var strRetorno = '';
                strRetorno += '<p><strong>' + traducoes.sDescricaoText + ':</strong> ' + getXMLValue(msg, "descricao") + '</p>';
                strRetorno += '<p><strong>' + traducoes.sComplementoText + ':</strong> ' + getXMLValue(msg, "complemento") + '</p>';
                strRetorno += getXMLValue(msg, "player");
            	jQuery("#boxViewImagem").find("#content").html(strRetorno);
                jQuery("#boxViewImagem").show();
                fntCentralizaDivTela("#boxViewImagem");
            }
            else
            {
                alert(msg);
            }
        },
        error: function(x, y, z){
            alert(traducoes.sOcorreuErroText + ': ' + x + ' ' + y + ' ' + z);
        }
    });
}
function fntAtualizaMidia(midia)
{
	var dados = "img=" + midia;
    jQuery.ajax({
        type: 'post',
        url: 'vwuploaddetalhe.php',
        data: dados,
        success: function(msg)
        {
            if (msg.indexOf('ERRO') == -1)
            {
                jQuery("#boxAtualizaMidia").find("#content").html(msg);
                jQuery("#boxAtualizaMidia").show();
                fntCentralizaDivTela("#boxAtualizaMidia");
            }
            else
            {
                alert(msg);
            }
        },
        error: function(x, y, z){
            alert(traducoes.sOcorreuErroText + ': ' + x + ' ' + y + ' ' + z);
        }
    });
}

function fntRemoveMidia(idMidia){
	if (confirm(traducoes.sConfDelMidText))
	{
	    var dados = "act=delmidia&img=" + idMidia;
	    
	    jQuery.ajax({
	        type: "post",
	        url: "ajaxcasosacoesextras.php",
	        data: dados,
	        success: function(msg){
	            if (msg.indexOf('ERRO') == -1)
	            {
	                alert(traducoes.sDelSucessoText);
	                fntLoadTela('conteudos','itenscad');
	            }
	            else
	            	alert(msg);
	        },
	        error: function(http, text, err){
	            alert(text);
	        }
	    });
	}
}

function fntAtualizaMidiaSistema()
{
	jQuery.ajax({
        type: 'post',
        url: 'actatualizamidia.php',
        data: fntSerializa("boxAtualizaMidia"),
        success: function(msg)
        {
            if (msg.indexOf('ERRO') == -1)
            {
                alert(traducoes.sAlteradoOKText);
                fntFechaUP('boxAtualizaMidia');
                fntLoadTela('conteudos','itenscad');
            }
            else
            {
            	alert(msg);
            }
        },
        error: function(x, y, z){
            alert(traducoes.sOcorreuErroText + ': ' + x + ' ' + y + ' ' + z);
        }
    });
}

function fntWS_PopulaTipos()
{
    // chama no load da página
    fntWorking(true, true);
    jQuery.ajax({
        type: "post",
        url: "ajaxws.php",
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
                fntWorking(false, true);
                if (jQuery.trim(msg) != "")
                {
                    jQuery("#selTipos").html(msg);
                }
                else
                {
                    jQuery("#selTipos").html('<option value="">' + traducoes.sErrCarregaText + '</option>')
                }
            }
            else
            {
                fntWorking(false, true);
                jQuery("#consultasbanco").hide();
                jQuery("#erroconsulta").show()
                jQuery("#erroconsulta").html(msg);
            }
        },
        error: function(http, text, err){
            fntWorking(false, true);
            alert(text);
        }
    });
}

function fntWS_PopulaTiposItens()
{
    //chama no change do tipos
    fntWorking(true, true);
    var dados = "r=subtipos&selTipos=" + jQuery("#selTipos").val();
    jQuery.ajax({
        type: "post",
        url: "ajaxws.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
                jQuery("#selSubTipos").html(msg);
                fntWorking(false, true);
            }
            else
            {
                fntWorking(false, true);
                alert(msg);
            }
        },
        error: function(http, text, err){
            fntWorking(false, true);
            alert(text);
        }
    });
}

function fntWS_ListaPesquisa()
{
    var erro = "";
    
    // chama do click do pesquisar
    if (jQuery.trim(jQuery("#txtPalavraChave").val()) == "")
    {
        erro = traducoes.sFaltaPalChaText;
    }
    
    if (jQuery("#selTipos").val() == "")
    {
        erro += "\n\r" + traducoes.sFaltaTipPesText;
    }
    
    if (jQuery("#selSubTipos").val() == "")
    {
        erro += "\n\r" + traducoes.sFaltaEspPesText;
    }
    
    if (erro != "")
    {
        alert(erro)
        return;
    }
    
    jQuery("#divResultadoPesquisa").html('<center>Pesquisando...</center>')
    fntWorking(true, true);
    var dados = "r=imagens&type_key=" + escape(jQuery('#selTipos option:selected').text()) + "&selSubTipos=" + jQuery("#selSubTipos").val();
    dados += (jQuery.trim(jQuery("#txtPalavraChave").val()) != "") ? "&txtPalavraChave=" + jQuery("#txtPalavraChave").val() : "";
    dados += "&nmax=" + jQuery("#txtNResultados").val();
    
    jQuery.ajax({
        type: "post",
        url: "ajaxws.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
                jQuery("#divResultadoPesquisa").html(msg);
                fntWorking(false, true);
            }
            else
            {
                fntWorking(false, true);
                alert(msg);
            }
        },
        error: function(http, text, err){
            fntWorking(false, true);
            alert(text);
        }
    });
}

function fntAlternaSelecaoImagem()
{
    jQuery("input[name='chkUsar']").each(function(){
        if (jQuery(this).is(":checked"))
        {
            jQuery(this).parent().css("background-color", "#00009F");
            jQuery(this).parent().css("color", "#ffffff");
        }
        else
        {
            jQuery(this).parent().css("background-color", "#ffffff");
            jQuery(this).parent().css("color", "#000000");
        }
    });
}

/*funçao para fechar todas as possíveis telas antes de abrir outra*/
function fntFechaTelasExtras()
{
	jQuery(".boxUpload").hide();
	jQuery(".boxView").hide();
}

/*fntGravaUsuariosCasoColaboradores*/
function fntGravaUsuariosCasoColaboradores()
{
    var dados = "";
    var usuarios = Array();
    jQuery("#selUDG > option ").each(function(i){
        usuarios[i] = jQuery(this).val();
    });
    
    dados += "&u=" + usuarios.join("-");
    
    jQuery.ajax({
        type: "POST",
        url: "actgravacolaborador.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("GRAVOU") >= 0)
            {
                alert(traducoes.sSalvoOKText);
            }
            else
            {
                alert(msg);
            }
        },
        error: function(http, text, err){
            alert(text + ' ' + err);
        }
    });
}

function fntFechaValoresReferencia()
{
    jQuery("#val-ref-item").hide();
}

function fntBuscaValores(te, cc)
{
    fntWorking(true);
    var dados = "act=vre&te=" + te + "&cc=" + cc;
    jQuery.ajax({
        type: "POST",
        url: "ajaxcasosacoesextras.php",
        data: dados,
        success: function(msg){
            fntWorking(false);
            if (msg.indexOf("ERRO") == -1)
            {
                jQuery("#val-ref-content").html(msg);
                jQuery("#val-ref-item").show();
            }
            else
            {
                alert(msg);
            }
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text + ' ' + err);
        }
    });
}

function fntInstanciaPreview(c)
{
    var botoes = {};
	botoes[traducoes.sOkText] = function() { jQuery(this).dialog("close"); fntPreviewCaso(c); };
	botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close"); jQuery(this).dialog("destroy");  };
	
	jQuery("#divTipoPreview").dialog({
	    cache: false,
	    width: 300,
	    height: 190,
	    title: "Modo de visualização",
	    buttons: botoes
    });
}

function fntURLCaso()
{
	if (jQuery("#chkExigeLogin").is(":checked"))
	{
		var url = location.href;
		var codcaso = url.split('?cod=')[1];
		var sitebase = url.substring(0, url.lastIndexOf('/')+1) + 'vwresolucao-offline.php?c=' + codcaso;
		jQuery("#spnURLCaso").html(sitebase);
		jQuery("#spnURL").fadeIn();
	}
	else
	{
		jQuery("#spnURLCaso").html("");
		jQuery("#spnURL").fadeOut();
	}
}