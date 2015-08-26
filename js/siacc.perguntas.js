/*!
 * SIACC - Sistema Interdisciplinar de Análise de Casos Clínicos - fn-perguntas.js
 * http://siacc.regisls.net
 *
 * Copyright (c) 2011 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * Data: 01/09/2011 22:19 - Quinta-feira
 * Data revisão: 17/12/2013 23:12 - Terça-feira
 * Revisão: 9
 * Tradução: OK
 */

function InicializaFormPerguntaE1()
{
    jQuery("#cmdGravar").click(function(){
        fntGravaE1();
    });
}

function InicializaListaPerguntas()
{
    fntFormagaGrid();
}

function InicializaListaAlternativas()
{
	jQuery("#tabs").tabs({
        selected: 0
    });
	fntWS_PopulaTipos();
	
	jQuery("#selTipos").change(function(){
        fntWS_PopulaTiposItens();
    })
    
    jQuery("#btnProcurar").click(function(){
        fntWS_ListaPesquisa();
    });
    
    jQuery("input[name='chkUsar']").click(function(){
        fntAlternaSelecaoImagem();
    });
    var objTipo = "tipo-" + jQuery("#hidTipo").val();
    jQuery("div[id^='tipo-']").not("div[id='"+objTipo+"']").css("display", "none");
    //jQuery("#" + objTipo).css("display", "");

    if (jQuery("#hidOcultar").val() == "N")
    {
        fntEditaAlternativa();
    }

    jQuery('textarea.tinymce').tinymce({
        script_url : 'js/tiny_mce/tiny_mce.js',
        theme : "advanced",
        plugins : "style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        height : 200,
        width: 320,
        readonly: 0,
        language: 'pt',
        
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,advhr,|,print,|,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        //theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
    });

    jQuery("#realupload").change(function(){
        fntPreview();
    });
    
    jQuery("#addAlt").click(function(){
        fntNovaAlternativa();
    });
    
    jQuery("#selConsequencia").change(function(){
        if (jQuery(this).val() > 1)
            jQuery("#conseq").css("display", "");
        else
            jQuery("#conseq").css("display", "none");
    });
    
    jQuery("#selValorConsequencia").change(function(){
        if (jQuery("#selValorConsequencia").val() == -2)
        {
            fntAbreTelaPesquisaPergunta();
        }
    });
    
    jQuery("#cmdProcurar").click(function(){
        var form = "term=" + jQuery("#term").val() + "&cls=" + jQuery("#selClassePergunta").val() + "&tip=" + jQuery("#selTipoPergunta").val();
        
        jQuery.ajax({
            type: "GET",
            url: "ajaxperguntas.php",
            data: form,
            success: function(msg){
                jQuery("#ret").html(msg);
            },
            error: function(http, text, err){
                alert(text + " " + err + " " + http);
            }
        });
    });
    
    jQuery("div[id='colesq']").sortable({
    	 handle : "img[class='areaDrag']"
    	,items : "div[class='box-alternativa']:not(div[id='addAlt'])"
    	,stop: function(event, ui) { 
    		var arrSeq = new Array();
    		jQuery("div[class='box-alternativa']:not(div[id='addAlt'])").each(function(i,v){
    			arrSeq.push(jQuery(this).attr('id').substr(3));
    			jQuery(this).find("span[class='spnLocalOrdem']").html((i+1));
    		});
    		//alert(arrSeq.join(','));
    		jQuery.ajax({
    			type: "POST",
    			url: "actalternativa.php?act=novaordem",
    			data: ("ids=" + arrSeq.join(',')),
    			success: function(msg){
    			    if (msg == "OK")
    			    {
    			        //alert('Atualização realizada!');
    			        //location.href = 'vwalternativas.php';
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
    });
}

function fntLimpa()
{
    jQuery("#fakeupload").val("");
    jQuery("#realupload").val("");
    jQuery("#txtTextoAdicional").val("");
    jQuery("#txtExplicacao").val("");
    jQuery("#txtAlternativa").val("");
    jQuery("#selCorretoTxt")[0].selectedIndex = 0;
    jQuery("#txtJustTxt").val("");
    jQuery("#hidSeq").val("");
}

function fntGravaE1()
{
    jQuery("#act").val("aW5z");
    var act = jQuery("#act").val();
    var cod = jQuery("#txtCodigo").val()
    var txt = escape(jQuery("#txtDescricao").val());
    var cls = jQuery("#selClasse").val();
    var niv = jQuery("#selNivel").val();
    var ati = jQuery("#selAtivo").val();
    var tip = jQuery("#selTipo").val();
    var exp = escape(jQuery("#txtExplicacaoGeral").val());
    
    var form = "act=" + act + "&txtCodigo=" + cod + "&txtDescricao=" + txt + "&selClasse=" + cls + "&selNivel=" + niv + "&selAtivo=" + ati + "&selTipo=" + tip + "&txtExplicacaoGeral=" + exp;
    jQuery("#act").val("");

    jQuery.ajax({
        type: "POST",
        url: "actpergunta.php",
        data: form,
        success: function(msg){
            if (msg == "OK")
            {
                location.href = 'vwalternativas.php';
            }
            else
            {
                jQuery("#ret").html(msg);
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaAlternativa()
{
    var erro = new Array();

    if (jQuery("#hidTipo").val() == "1")
    {
    	var form = "1";
    	
    	if((jQuery("#hidSeq").val() == "") && (jQuery("#hidSeqBanco").val() == ""))
    	{
	    	if((jQuery("#realupload").val() == "") && (jQuery("input[name^='chkUsar']:checked").length == 0))
	        {
	            erro.push(traducoes.sImgNaoSelText);
	        }
    	}
    	
    	if (jQuery("input[name^='chkUsar']:checked").length > 1)
        {
    		erro.push(traducoes.sImgSoUmaText);
        }
    	
    	if(jQuery("input[name^='chkUsar']:checked").length == 0)
    	{
	        if ((jQuery("#selCorreta").val() != "0") && (jQuery("#selCorreta").val() != "1"))
	        {
	            erro.push(traducoes.sCertoOuErrText);
	        }
	        
	        if (jQuery("#txtExplicacao").val() == "")
	        {
	            erro.push(traducoes.sCampoJustText);
	        }
    	}
    	else
    	{
    		if ((jQuery("#selCorretaBanco").val() != "0") && (jQuery("#selCorretaBanco").val() != "1"))
	        {
	            erro.push(traducoes.sCertoOuErrText);
	        }
	        
	        if (jQuery("#txtExplicacaoBanco").val() == "")
	        {
	            erro.push(traducoes.sCampoJustText);
	        }
    	}
    }
    else if ((jQuery("#hidTipo").val() == "2") || (jQuery("#hidTipo").val() == "3"))
    {
        var form = "2";
        if (jQuery("#txtAlternativa").val() == "")
        {
            erro.push(traducoes.sInfAlternaText);
        }
        
        if ((jQuery("#selCorretoTxt").val() != "0") && (jQuery("#selCorretoTxt").val() != "1"))
        {
            erro.push(traducoes.sCertoOuErrText)
        }

        if (jQuery("#txtJustTxt").val() == "")
        {
            erro.push(traducoes.sCampoJustText);
        }
    }
    
    if (erro.length > 0)
    {
        var msg = "";
        for(var i = 0; i < erro.length; i++)
        {
            msg += erro[i] + ";\n ";
        }
        alert(traducoes.sVerInfosText+ "\r\n " + msg);
    }
    else
    {
        if ((jQuery("#hidTipo").val() == "1") && (jQuery("input[name^='chkUsar']:checked").length > 0))
        {
        	var string = fntSerializa("divResultadoPesquisa");
        	string += "&txtTextoAdicional=" + escape(jQuery("#txtTextoAdicionalBanco").val());
        	string += "&selCorreta=" + jQuery("#selCorretaBanco").val();
        	string += "&txtExplicacao=" + escape(jQuery("#txtExplicacaoBanco").val());
        	string += "&hdnOrigem=banco"
            jQuery.ajax({
                type: "post",
                url: "actalternativa.php",
                data: string,
                success: function(msg){
                    alert("Salvo com sucesso");
            		document.location.reload(true);
                }
            });
        }
        else
        {     	
	        jQuery("#frmAlternativa-" + form).attr("method", "post");
	        jQuery("#frmAlternativa-" + form).attr("action", "actalternativa.php");
	        jQuery("#frmAlternativa-" + form).submit();
        }
    }
}

function fntCarregaAlternativa(a, s)
{
    var url = "vwalternativas.php?p=" + a + "&s=" + s;
    
    fntNavega(url);
}

function fntEditaAlternativa()
{
    switch(jQuery("#hidTipo").val())
    {
        case "1":
            jQuery("#tipo-1").css("display", "");
            break;
        case "2":
        case "3":
            jQuery("#tipo-2").css("display", "");
            break;
    }
}


function fntNovaAlternativa()
{
    fntLimpa();
    switch(jQuery("#hidTipo").val())
    {
        case "1":
            jQuery("#tipo-1").css("display", "");
            break;
        case "2":
        case "3":
            jQuery("#tipo-2").css("display", "");
            break;
    }
}

function fntPreview()
{
    jQuery("#fakeupload").attr("value", jQuery("#realupload").val().substring(jQuery("#realupload").val().lastIndexOf("\\")+1));
}

function fntAbreTelaPesquisaPergunta()
{
    jQuery("#find-window").dialog('open');
}

function fntAddPerguntaCombo(c, t)
{
    jQuery("#selValorConsequencia").append(jQuery("<option></option>").attr("value", c).text(t));
}

function fntDeletaNivelDificuldade(id)
{
    if (confirm(traducoes.sConfDelNivDifText))
    {
        var dados = "etapa=niveldif&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdel.php",
            data: dados,
            success: function(msg){
                alert(msg);
                document.location.reload(true);
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}

function fntDeletaGrupoPergunta(id)
{
    if (confirm(traducoes.sConfDelAgPText))
    {
        var dados = "etapa=grupopergunta&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdel.php",
            data: dados,
            success: function(msg){
                alert(msg);
                document.location.reload(true);
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}

function fntExcluiClassePergunta(id)
{
    if (confirm(traducoes.sConfDelClPText))
    {
        var dados = "etapa=classepergunta&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdel.php",
            data: dados,
            success: function(msg){
                alert(msg);
                document.location.reload(true);
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}

function fntExcluiTipoExame(id)
{
    if (confirm(traducoes.sConfDelTExText))
    {
        var dados = "etapa=tipoexame&id=" + id;
        
        jQuery.ajax({
            type: "post",
            url: "ajaxdel.php",
            data: dados,
            success: function(msg){
                alert(msg);
                document.location.reload(true);
            },
            error: function(http, text, err){
                alert(text);
            }
        });
    }
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
                //alert(msg);
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
        erro += "\r\n" + traducoes.sFaltaTipPesText;
    }
    
    if (jQuery("#selSubTipos").val() == "")
    {
        erro += "\r\n" + traducoes.sFaltaEspPesText;
    }
    
    if (erro != "")
    {
        alert(erro)
        return;
    }
    
    jQuery("#divResultadoPesquisa").html('<center>' + traducoes.sPesquisandoText + '...</center>')
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
    jQuery("input[name='chkUsar[]']").each(function(){
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