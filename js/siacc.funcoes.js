/*!
 * SIACC - Sistema Interdiciplinar de Análise de Casos Clínicos - funcoes.js
 * http://siacc.regisls.net
 *
 * Copyright (c) 2011 Regis Leandro Sebastiani
 * http://www.regisls.net
 *
 * Data: 01/09/2011 22:19 - Quinta-feira
 * Data revisão: 04/02/2013 23:19 - Segunda-feira
 * Revisão: 22
 */

function enableSubMenus()
{
    var lis = document.getElementsByTagName('li');
    for (var i = 0, li; li = lis[i]; i++)
    {
        var link = li.getElementsByTagName('a')[0];
        if (link)
        {
            link.onfocus = function()
            {
                var ul = this.parentNode.getElementsByTagName('ul')[0];
                if (ul)
                ul.style.display = 'block';
            }

            var ul = link.parentNode.getElementsByTagName('ul')[0];
            if (ul)
            {
                var ullinks = ul.getElementsByTagName('a');
                var ullinksqty = ullinks.length;
                var lastItem = ullinks[ullinksqty - 1];

                if (lastItem)
                {
                    lastItem.onblur = function()
                    {
                        this.parentNode.parentNode.style.display = 'none';
                    }

                    lastItem.parentNode.onblur = function()
                    {
                        this.parentNode.style.display = '';
                    }
                }
            }
        }
    }
}
window.onload = enableSubMenus;

function fntNavega(url)
{
    location.href = url;
}

function fntVoltar()
{
    history.back();
}

function fntInitGerenciaGrupo()
{
    jQuery("#selGrupos").change(function(){
        fntCarregaPermissoesGrupo();
    });
}

function fntInitUsuariosGrupos()
{
    jQuery("#selGrupos").change(function(){
        fntCarregaUsuarios();
        fntCarregaUsuariosGrupo();
    });
    
    jQuery("#addUser").click(function(){
        fntMoveUsuarioIn();
    });

    jQuery("#remUser").click(function(){
        fntMoveUsuarioOut();
    });

    jQuery("#addAllUser").click(function(){
        fntMoveTodosIn();
    });
    
    jQuery("#remAllUser").click(function(){
        fntMoveTodosOut();
    });
}

function fntInitUsuariosColaborador()
{
	jQuery("#selGrupos").change(function(){
		fntCarregaUsuariosGrupoSel();
        //fntCarregaUsuariosCasoColaborador();
    });
	
	jQuery("#addUser").click(function(){
        fntMoveUsuarioIn();
    });

    jQuery("#remUser").click(function(){
        fntMoveUsuarioOut();
    });

    jQuery("#addAllUser").click(function(){
        fntMoveTodosIn();
    });
    
    jQuery("#remAllUser").click(function(){
        fntMoveTodosOut();
    });
    
    fntCarregaUsuariosCasoColaborador();
}

function fntMoveUsuarioIn()
{
    jQuery("#selTU").copyOptions("#selUDG", "selected", true);
    jQuery("#selTU").removeOption(/./, true);
    jQuery("#selUDG").sortOptions(true);
}

function fntMoveUsuarioOut()
{
    jQuery("#selUDG").copyOptions("#selTU", "selected", true);
    jQuery("#selUDG").removeOption(/./, true);
    jQuery("#selTU").sortOptions(true);
}

function fntMoveTodosIn()
{
    jQuery("#selTU").copyOptions("#selUDG", "all", true);
    jQuery("#selTU").removeOption(/./);
    jQuery("#selUDG").sortOptions(true);
}

function fntMoveTodosOut()
{
    jQuery("#selUDG").copyOptions("#selTU", "all", true);
    jQuery("#selUDG").removeOption(/./);
    jQuery("#selTU").sortOptions(true);
}

function fntGravaUsuario()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }

    var codigo = jQuery.trim(jQuery("#txtCodigo").val());
    var nome = escape(jQuery.trim(jQuery("#txtNome").val()));
    var usuario = escape(jQuery.trim(jQuery("#txtUsuario").val()));
    var email = escape(jQuery.trim(jQuery("#txtEmail").val()));
    var instit = jQuery("#selInstituicao").val();
    var idioma = jQuery("#selIdioma").val();
    var senha = escape(jQuery.trim(jQuery("#txtSenha").val()));
    var senhadois = escape(jQuery.trim(jQuery("#txtSenhaDois").val()));
    var ativo = jQuery("#selAtivo").val();
    
    var dados = "c=" + codigo + "&n=" + nome + "&u=" + usuario + "&e=" + email + "&i=" + instit + "&l=" + idioma + "&s=" + senha + "&a=" + ativo;
    
    jQuery.ajax({
        type: "POST",
        url: "actgravausuario.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=1';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntExcluiUsuario(c)
{
    
    if (confirm(traducoes.sConfDelUsuText))
    {
        var dados="act=eus&r=" + c;
        
        jQuery.ajax({
            type: "POST",
            url: "ajaxcasosacoesextras.php",
            data: dados,
            success: function(msg){
                if (msg == "ERR100")
                {
                    if (confirm(traducoes.sUsuComDepText))
                    {
                        fntAlteraStatus('AAAB', c);
                    }
                }
                else
                {
                    alert(traducoes.sDelSucessoText);
                    location.href = 'listagem.php?t=1';
                }
            }, 
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}

function fntGravaPermissao()
{
    var codigo = jQuery.trim(jQuery("#txtCodigo").val());
    var descricao = escape(jQuery.trim(jQuery("#txtDescricao").val()));
    
    var dados = "c=" + codigo + "&d=" + descricao;
    
    jQuery.ajax({
        type: "POST",
        url: "actgravapermissao.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
                alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=4';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaGrupoUsu()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }

    var codigo = jQuery.trim(jQuery("#txtCodigo").val());
    var descricao = escape(jQuery.trim(jQuery("#txtDescricao").val()));
    
    var dados = "c=" + codigo + "&d=" + descricao;
    
    jQuery.ajax({
        type: "POST",
        url: "actgravagrupousu.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=5';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaGrupoPergunta()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }
    
    fntWorking(true);
    
    var dados = fntSerializa();
    
    jQuery.ajax({
        type: "POST",
        url: "actgravaagrupadores.php",
        data: dados,
        success: function(msg){
            fntWorking(false);
            if (msg != "OK")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=12';
            }
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}

function fntGravaClassePergunta()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }
    
    var codigo = jQuery.trim(jQuery("#txtCodigo").val());
    var descricao = escape(jQuery.trim(jQuery("#txtDescricao").val()));
    var complemento = escape(jQuery.trim(jQuery("#txtComplemento").val()));
    
    var dados = "c=" + codigo + "&d=" + descricao + "&com=" + complemento;

    jQuery.ajax({
        type: "POST",
        url: "actgravaclasse.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=6';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaPermissoesGrupo()
{
    if (jQuery("select[id='selGrupos']:selected").length == 0)
    {
        alert(traducoes.sSelGrupoUsuText);
        return;
    }
    
    var perm = jQuery("input[name='selPermissoes[]']:checked");
    
    if (perm.length == 0)
    {
        if (!confirm(traducoes.sConfPerGrUsu1Text + ' ' + jQuery("select[id='selGrupos'] option:selected").text() + '. ' + traducoes.sConfContText))
        {
            return;
        }
    }
    
    fntWorking(true);
    var permg = "";
    for (var i = 0; i < perm.length; i++)
    {
        permg += (permg == "") ? perm[i].value : "-" + perm[i].value;
    }
    
    var dados = "cg=" + jQuery("select[id='selGrupos']").val() + "&p=" + permg;
    
    jQuery.ajax({
        type: "POST",
        url: "actgravapermissoesgrupo.php",
        data: dados,
        success: function(msg){
            fntWorking(false);
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
            fntWorking(false);
            alert(text + ' ' + err);
        }
    });
}

function fntGravaUsuariosGrupo()
{
    var dados = "cg=" + jQuery("select[id='selGrupos']").val();
    var usuarios = Array();
    jQuery("#selUDG > option ").each(function(i){
        usuarios[i] = jQuery(this).val();
    });
    
    dados += "&u=" + usuarios.join("-");
    
    jQuery.ajax({
        type: "POST",
        url: "actgravausuariosgrupo.php",
        data: dados,
        success: function(msg){
            if (msg == "GRAVOU")
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

function fntGravaNivelPergunta()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }

    var codigo = jQuery.trim(jQuery("#txtCodigo").val());
    var descricao = escape(jQuery.trim(jQuery("#txtDescricao").val()));
    
    var dados = "c=" + codigo + "&d=" + descricao;
    
    jQuery.ajax({
        type: "POST",
        url: "actgravanivelpergunta.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=7';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaAreaConhecimento()
{
    var codigo = jQuery.trim(jQuery("#txtCodigo").val());
    var descricao = escape(jQuery.trim(jQuery("#txtDescricao").val()));
    var pai = jQuery.trim(jQuery("#selAreaPai").val());
    
    var dados = "c=" + codigo + "&d=" + descricao;

    if (pai != -1)
    {
        dados += "&p=" + pai;
    }
    
    jQuery.ajax({
        type: "POST",
        url: "actgravaarea.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=9';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaTipoExame()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }
    
    var dados = fntSerializa();
    
    jQuery.ajax({
        type: "post",
        url: "actgravatipoexame.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=11';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaComponenteExame()
{
    if (fntValidaObrigatorios("divcomp") == false)
    {
        return 0;
    }
    
    var dados = fntSerializa();
    alert(dados);
    jQuery.ajax({
        type: "post",
        url: "actgravacomponenteexame.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                fntAbreComponentes(jQuery("#hdnCodigoExame").val(), true);
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaValorReferencia()
{
    if (fntValidaObrigatorios("divvlrref") == false)
    {
        return 0;
    }
    
    var erro = false;
    
    if (!jQuery("input[id='chkSemAgrupador']").is(":checked"))
    {
        if (jQuery("input[id='txtAgrupador']").val() == "")
        {
            erro = true;
        }
    }
    
    switch(jQuery("select[id='selTipoValor']").val())
    {
        case "1":
            if ((jQuery("input[id='txtValMin']").val() == "") || (jQuery("input[id='txtValMax']").val() == ""))
                erro = true;
            break;
        case "2":
        case "6":
            if (jQuery("input[id='txtValMin']").val() == "")
                erro = true;
            break;
        case "3":
        case "5":
            if (jQuery("input[id='txtValMax']").val() == "")
                erro = true;
            break;
        case "4":
            if (jQuery("input[id='txtValIgual']").val() == "")
                erro = true;
            break;
    }
    
    if (erro)
    {
        alert(traducoes.sValidaCamposText)
        return 0;
    }
    
    var dados = fntSerializa();
    
    jQuery.ajax({
        type: "post",
        url: "actgravavalorref.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
                alert(traducoes.sSalvoOKText);
                fntAbreValorRef(jQuery("#hdnCodigoExame").val(), jQuery("#hdnCodigoCompo").val(), true);
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaInstituicao()
{
    if (fntValidaObrigatorios() == false)
    {
        return 0;
    }
    
    var dados = fntSerializa("divInstituicoes", true);
    
	alert(dados);
	
    jQuery.ajax({
        type: "post",
        url: "actgravainstituicao.php",
        data: dados,
        success: function(msg){
            if (msg != "GRAVADO")
            {
                alert(msg);
            }
            else
            {
				alert(traducoes.sSalvoOKText);
                location.href = 'listagem.php?t=13';
            }
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntGravaTraducao(id)
{
    if (jQuery("#exp_" + id).val() == jQuery("#h_exp_" + id).val())
        return;
    
    if (jQuery("#selIdioma").val() < 1)
    {
        alert(traducoes.sSelIdiomaText);
        return;
    }
    
    var dados = "langid=" + jQuery("#selIdioma").val() + "&expid=" + id + "&trad=" + jQuery("#exp_" + id).val();
    
    jQuery.ajax({
        type: "POST",
        url: "ajaxtraducao.php",
        data: dados,
        success: function(msg){
            if (msg.indexOf("ERRO") == -1)
            {
                jQuery(".info-percentual").html(msg);
                jQuery("#h_exp_" + id).val(jQuery("#exp_" + id).val());
            }
            else
                alert(traducoes.sErrInesText + msg);
        },
        error: function(http, text, err){
            alert(text + ' ' + err);
        }
    });
}

function fntCarregaPermissoesGrupo()
{
    var grupo = jQuery("#selGrupos").val();
    grupo = "cg=" + grupo;
    
    jQuery.ajax({
        type: "POST",
        url: "ajaxpermissoesgrupo.php",
        data: grupo,
        success: function(msg){
            if (msg != "ERRO")
            {
                jQuery("#divPermissoes").html(msg);
                jQuery('#selPermissoes').toChecklist();
            }
            else
            {
                alert(traducoes.sErrInesText);
            }
        },
        error: function(http, text, err){
            alert(text + ' ' + err);
        }
    });
}

function fntCarregaUsuarios()
{
    if (jQuery("#selGrupos").val() == "")
    {
        jQuery("#selTU").find('option').remove();
        jQuery("#selUDG").find('option').remove();
        return;
    }
    
    var grupo = "cg=" + jQuery("#selGrupos").val() + "&m=1";

    jQuery.ajax({
        type: "POST",
        url: "ajaxusuariosgrupo.php",
        data: grupo,
        success: function(msg){
            if (msg != "ERRO")
            {
                jQuery("#selTU").html(msg);
            }
            else
            {
                alert(traducoes.sErrInesText);
            }
        },
        error: function(http, text, err){
            alert(text + ' ' + err);
        }
    });
}

function fntCarregaUsuariosGrupo()
{
    if (jQuery("#selGrupos").val() == "")
    {
        jQuery("#selTU").find('option').remove();
        jQuery("#selUDG").find('option').remove();
        return;
    }
    
    var grupo = "cg=" + jQuery("#selGrupos").val() + "&m=2";

    jQuery.ajax({
        type: "POST",
        url: "ajaxusuariosgrupo.php",
        data: grupo,
        success: function(msg){
            if (msg != "ERRO")
            {
                jQuery("#selUDG").html(msg);
            }
            else
            {
                alert(traducoes.sErrInesText);
            }
        },
        error: function(http, text, err){
            alert(text + ' ' + err);
        }
    });
}

function fntCarregaUsuariosGrupoSel()
{
    if (jQuery("#selGrupos").val() == "")
    {
        jQuery("#selTU").find('option').remove();
        jQuery("#selUDG").find('option').remove();
        return;
    }
    
    var grupo = "cg=" + jQuery("#selGrupos").val() + "&m=2";

    jQuery.ajax({
        type: "POST",
        url: "ajaxusuariosgrupo.php",
        data: grupo,
        success: function(msg){
            if (msg != "ERRO")
            {
                jQuery("#selTU").html(msg);
            }
            else
            {
                alert(traducoes.sErrInesText);
            }
        },
        error: function(http, text, err){
            alert(text + ' ' + err);
        }
    });
}

function fntCarregaUsuariosCasoColaborador()
{
	jQuery.ajax({
        type: "POST",
        url: "ajaxusuarioscolaborador.php",
        success: function(msg){
            if (msg != "ERRO")
            {
                jQuery("#selUDG").html(msg);
            }
            else
            {
                alert(traducoes.sErrInesText);
            }
        },
        error: function(http, text, err){
            alert(text + ' ' + err);
        }
    });
}

function fntBuscaTraducoes()
{
    if (jQuery("#selIdioma").val() != "0")
        location.href = 'vwidiomas.php?id=' + jQuery("#selIdioma").val();
    else
        location.href = 'vwidiomas.php';
}

function fntFormagaGrid()
{
    jQuery(".listadados tr:even").not("tr[class='head']").addClass("escuro");
    jQuery(".listadados tr").not("tr[class='head']").mouseover(function(){
        jQuery(this).addClass("over");
    });
    jQuery(".listadados tr").not("tr[class='head']").mouseout(function(){
        jQuery(this).removeClass("over");
    });
}

function fntFormagaGridParent(pai)
{
    jQuery(".listadados tr:even", pai).not("tr[class='head']").addClass("escuro");
    jQuery(".listadados tr", pai).not("tr[class='head']").mouseover(function(){
        jQuery(this).addClass("over");
    });
    jQuery(".listadados tr", pai).not("tr[class='head']").mouseout(function(){
        jQuery(this).removeClass("over");
    });
}

function fntAlteraStatus(loc, reg)
{
    var dados = "t=" + loc + "&r=" + reg;
    
    jQuery.ajax({
        type: "POST",
        url: "ajaxalterastatusregistro.php",
        data: dados,
        success: function(msg){
            if ((msg == 0) || (msg == 1))
            {
                var atual = jQuery("img[id='" + reg + "']").attr("src");
                
                if (atual == "img/active.png")
                {
                    jQuery("img[id='" + reg + "']").attr("src", "img/inative.png");
                    jQuery("img[id='" + reg + "']").attr("alt", traducoes.sTitRegInaText);
                    jQuery("img[id='" + reg + "']").attr("title", traducoes.sTitRegInaText);
                }
                else
                {
                    jQuery("img[id='" + reg + "']").attr("src", "img/active.png");
                    jQuery("img[id='" + reg + "']").attr("alt", traducoes.sTitRegAtiText);
                    jQuery("img[id='" + reg + "']").attr("title", traducoes.sTitRegInaText);
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

function getXMLValue(xml, tag)
{
    if (xml.indexOf("<" + tag + ">") != -1)
    {
        var inicio = xml.indexOf("<" + tag + ">") + tag.length + 2;
        var fim = xml.indexOf("</" + tag + ">");
        
        return xml.substring(inicio, fim);
    }
    else
    {
        return "";
    }
}

/* Componentes dos exames */
function fntAbreComponentes(cod, jaaberto)
{
    jaaberto = typeof(jaaberto) == "undefined" ? false : jaaberto;
    var dados = "c=" + cod;
    
    jQuery.ajax({
        type: "POST",
        url: "ajaxcomponentesexame.php",
        data: dados,
        success: function(msg){
            jQuery("#divcomp").html(msg);
            fntFormagaGrid();
            jQuery("#componentes").sortable({
                handle : "img[class='areaDrag']",
                items : "tr:not(tr[class='head'])"
                ,stop: function(event, ui) { 
            		var arrSeq = new Array();
            		jQuery("table[id='componentes'] tr:not(tr[class='head'])").each(function(i,v){
            			arrSeq.push(jQuery(this).attr('id'));
            		});
            		jQuery.ajax({
            			type: "POST",
            			url: "actgravacomponenteexame.php",
            			data: ("act=novaordem&ids=" + arrSeq.join(',')),
            			success: function(msg){
            			    if (msg == "OK")
            			    {
            			        jQuery("table[id='componentes'] tr:not(tr[class='head'])").each(function(i,v){
            			            jQuery(this).removeClass();
            			        });
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
            });
            if (!jaaberto)
                jQuery("#divcomp").dialog("open");
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntAbreValorRef(codexame, codcompo, jaaberto)
{
    jaaberto = typeof(jaaberto) == "undefined" ? false : jaaberto;
    var dados = "e=" + codexame + "&c=" + codcompo;

    jQuery.ajax({
        type: "POST",
        url: "ajaxvlrsreferencia.php",
        data: dados,
        success: function(msg){
            jQuery("#divvlrref").html(msg);
            fntFormagaGrid();
            
            if (!jaaberto)
                jQuery("#divvlrref").dialog("open");
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntEditaComponente(cod, reg)
{
    var dados = "c=" + cod + "&r=" + reg;

    jQuery.ajax({
        type: "POST",
        url: "ajaxcomponentesexame.php",
        data: dados,
        success: function(msg){
            jQuery("#divcomp").html(msg);
            fntFormagaGrid();
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntMoverComponente(cod, reg)
{
    var dados = "c=" + cod + "&r=" + reg;

    jQuery.ajax({
        type: "POST",
        url: "ajaxcomponentesexame.php",
        data: dados,
        success: function(msg){
            jQuery("#divcomp").html(msg);
            fntFormagaGrid();
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntEditaValorRef(codexame, codcompo, reg)
{
    var dados = "e=" + codexame + "&c=" + codcompo + "&r=" + reg;

    jQuery.ajax({
        type: "POST",
        url: "ajaxvlrsreferencia.php",
        data: dados,
        success: function(msg){
            jQuery("#divvlrref").html(msg);
            jQuery("#selTipoValor").trigger("change");
            fntTestaAgrupador();
            fntFormagaGrid();
        },
        error: function(http, text, err){
            alert(text);
        }
    });
}

function fntDeletaComponente(cod, reg)
{
    if (confirm(traducoes.sCOnfDelRegText))
    {
        var dados = "c=" + cod + "&r=" + reg;

        jQuery.ajax({
            type: "POST",
            url: "ajaxdelcomponentesexame.php",
            data: dados,
            success: function(msg){
                if (msg == "OK")
                {
                	alert(traducoes.sDelSucessoText);
                    fntAbreComponentes(cod, true);
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

function fntDeletaValorRef(codexame, codcomp, reg)
{
    if (confirm(traducoes.sCOnfDelRegText))
    {
        var dados = "e=" + codexame + "&c=" + codcomp + "&r=" + reg;

        jQuery.ajax({
            type: "POST",
            url: "ajaxdelvalorref.php",
            data: dados,
            success: function(msg){
                if (msg == "OK")
                {
                	alert(traducoes.sDelSucessoText);
                    fntAbreValorRef(codexame, codcomp, true);
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

function fntExcluiGrupoUsuario(reg)
{
    if (confirm(traducoes.sConfDelGUsText))
    {
    	var dados="act=egrpusu&r=" + reg;
        
        jQuery.ajax({
            type: "POST",
            url: "ajaxcasosacoesextras.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("SUCESSO") == -1)
                {
                    alert(msg);
                }
                else
                {
                	alert(traducoes.sDelSucessoText);
                    location.href = 'listagem.php?t=5';
                }
            }, 
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}

function fntExcluiPermissao(reg)
{
    if (confirm(traducoes.sConfDelPerText))
    {
    	var dados="act=delperm&r=" + reg;
        
        jQuery.ajax({
            type: "POST",
            url: "ajaxcasosacoesextras.php",
            data: dados,
            success: function(msg){
                if (msg.indexOf("ERRO") >= 0)
                {
                    alert(msg);
                }
                else
                {
                	alert(traducoes.sDelSucessoText);
                    location.href = 'listagem.php?t=4';
                }
            }, 
            error: function(http, text, err){
                alert(text);
            }
        });
    }
}

function fntTestaAgrupador()
{
    if (jQuery("input[id='chkSemAgrupador']").is(":checked"))
    {
        jQuery("div[id='divAgrupador']").hide();
    }
    else
    {
        jQuery("div[id='divAgrupador']").show();
    }
}

function fntTestaTipoValor()
{
    switch(jQuery("select[id='selTipoValor']").val())
    {
        case "1":
            /* Entre */
            jQuery("div[id='cmpValMin']").show();
            jQuery("div[id='cmpValMax']").show();
            jQuery("div[id='cmpValIgual']").hide();
            break;
        case "2":
        case "6":
            /* Maior que */
            jQuery("div[id='cmpValMin']").show();
            jQuery("div[id='cmpValMax']").hide();
            jQuery("div[id='cmpValIgual']").hide();
            break;
        case "3":
        case "5":
            /* Menor que */
            jQuery("div[id='cmpValMin']").hide();
            jQuery("div[id='cmpValMax']").show();
            jQuery("div[id='cmpValIgual']").hide();
            break;
        case "4":
            /* Igual a */
            jQuery("div[id='cmpValMin']").hide();
            jQuery("div[id='cmpValMax']").hide();
            jQuery("div[id='cmpValIgual']").show();
            break;
    }
}

function fntInicializaDialogosTE()
{
    var botoes = {};
	botoes[traducoes.sSalvarText] = function() { fntGravaComponenteExame(); };
	botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close");  };
	
	jQuery("#divcomp").dialog({
		autoOpen: false,
		width: 600,
		height: 400,
		title: traducoes.sTitCompExaText,
		buttons: botoes
    });
}

function fntInicializaDialogosVR()
{
    var botoes = {};
	botoes[traducoes.sSalvarText] = function() { fntGravaValorReferencia(); };
	botoes[traducoes.sFinalizarText] = function() { jQuery(this).dialog("close"); };
	botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close"); };
	
	jQuery("#divvlrref").dialog({
		autoOpen: false,
		width: 600,
		height: 400,
		title: traducoes.sValRefText,
		buttons: botoes
    });
}

function fntInicializaDialogos()
{
    fntInicializaDialogosTE();
    fntInicializaDialogosVR();
}

function fntJanela(div, largura, altura)
{
    if (jQuery("div[id='" + div + "']").hasClass("janela"))
    {
        jQuery("div[id='" + div + "']").css("width", largura + "px");
        jQuery("div[id='" + div + "']").css("height", altura + "px");

        var largtela = jQuery(window).width();
        var alttela = jQuery(window).height();
        
        var left = parseInt(((largtela - largura)/2), 10);
        var top = parseInt(((alttela - altura)/2), 10);
        
        jQuery("div[id='" + div + "']").css("top", top);
        jQuery("div[id='" + div + "']").css("left", left);
        
        
        
        jQuery("div[class='janela-titulo']").css(
            "width",
            (parseInt(largura, 10) - parseInt(14)) + "px"
        );
        
        jQuery("div[class='janela-conteudo']").css(
            "width",
            (parseInt(largura, 10) - parseInt(14)) + "px"
        );
        jQuery("div[class='janela-conteudo']").css(
            "height",
            (parseInt(altura, 10) - parseInt(40)) + "px"
        );
        
        
        jQuery("div[id='" + div + "']").show();
    }
}

function fntFechaJanela(div)
{
    if (jQuery("div[id='" + div + "']").hasClass("janela"))
    {
        jQuery("div[id='" + div + "']").hide();
    }
}

function fntPesquisarAcessos()
{
    jQuery("#frmAcessos").submit();
}

function fntInicializaConsultaAcessos()
{
	var idioma = getCookie("siacc_lang_sigla");
	if ((idioma == null) || (idioma == "") || (idioma == "undefined"))
		idioma = "pt-BR";
	
	var s = document.createElement('script');
	s.setAttribute('type', 'text/javascript');
	s.setAttribute('src', 'js/ui/jquery.ui.datepicker-' + idioma + '.js');
	document.getElementsByTagName('head').item(0).appendChild(s);
	
	jQuery("#txtUsuario").autocomplete({
        source: "ajaxusuarios.php",
        minLength: 2,
        select: function(event, ui) {
            jQuery('#idusuario').val(ui.item.id);
        }
    });
    
    jQuery("#txtUsuario").blur(function(){
        if (jQuery(this).val() == "")
            jQuery('#idusuario').val("");
    });
    
    jQuery("input[id^='txtDt']").datepicker({
        regional: ""+idioma
    });
    
    fntFormagaGrid();
}

function fntNavegaPaginacaoAcessos(pagina)
{
    jQuery("#hidPagina").val(pagina);
    jQuery("#frmAcessos").submit();
}

function fntDetalhesAcesso(id)
{
    jQuery("#hidAcesso").val(id);

    jQuery("#frmAcessos").attr("action", "vwdetalhesacesso.php");
    jQuery("#frmAcessos").submit();
}

function fntVoltarAcessos()
{
    jQuery("#frmAcessos").submit();
}

function fntWorking(mostrar, inframe)
{
    if (inframe == "undefined" || inframe == false)
        inframe = false;
    
    if (!inframe)
    {
        if (mostrar)
            jQuery("#working").css("visibility", "visible");
        else
            jQuery("#working").css("visibility", "hidden");
    }
    else
    {
        var pai = window.parent.document;
        if (mostrar)
            jQuery("#working", pai).css("visibility", "visible");
        else
            jQuery("#working", pai).css("visibility", "hidden");
    }
}

function fntSalvaAgrupamento()
{
    fntWorking(true);
    
    var questoes = "";
    
    jQuery("input[name^='chkPerguntas']:checked").each(function(){
        questoes += (questoes == "" ? "" : ";") + jQuery(this).val();
    });
    questoes = "perg=" + questoes;
    
    jQuery.ajax({
        type: "POST",
        url: "ajaxgravaagrupamento.php",
        data: questoes,
        success: function(msg){
            fntWorking(false);
            if (msg == "OK")
                alert(traducoes.sSalvoOKText);
            else
                alert(msg);
        },
        error: function(http, text, err){
            fntWorking(false);
            alert(text);
        }
    });
}

/*irá centralizar o div enviado em top*/
function getWidth() {
	return document.body.clientWidth && document.body.clientWidth > 0 ? document.body.clientWidth :
		window.innerWidth && window.innerWidth > 0 ? window.innerWidth : /* Non IE */
		document.documentElement.clientWidth && document.documentElement.clientWidth > 0 ? document.documentElement.clientWidth : /* IE 6+ */
		document.body.clientWidth && document.body.clientWidth > 0 ? document.body.clientWidth : -1; /* IE 4 */
}
function getHeight() {
	return window.innerHeight && window.innerHeight > 0 ? window.innerHeight : /* Non IE */
		document.documentElement.clientHeight && document.documentElement.clientHeight > 0 ? document.documentElement.clientHeight : /* IE 6+ */
		document.body.clientHeight && document.body.clientHeight > 0 ? document.body.clientHeight : -1; /* IE 4 */
}
function fntCentralizaDivTela(idDiv)
{
	var intTop = 0;
	var intScroll = parseInt(jQuery(document).scrollTop(), 10);
	var intAltDiv = parseInt(jQuery(idDiv).height(), 10);
	var intAltDoc = parseInt(getHeight(), 10);
	
	if(intAltDiv < intAltDoc)
		intTop = ((intAltDoc-intAltDiv)/2) + intScroll;
	
	var intLeft = parseInt((getWidth() - parseInt(jQuery(idDiv).width(), 10)) / 2, 10)
	
	jQuery(idDiv).css({top:intTop, left:intLeft});
}
	
function fntDefineTamanhoTela(idDiv)
{
	var largura = (jQuery(window).width() - 100);
	var altura = (jQuery(window).height() - 100);
	jQuery(idDiv).css({
		width: largura,
		height: altura
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
	
	//plugins : "style,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	
    jQuery('textarea.tinymce').tinymce({
        script_url : 'js/tiny_mce/tiny_mce.js',
        convert_urls : false,
        theme : "advanced",
        plugins : "style,table,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        height : altura,
        width: largura,
        readonly: 0,
        language: 'pt',
        
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        //theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
    });
}

function fntHelp()
{
    window.open('help/help.pdf', 'SIACCHelp');
    window.focus();
}

function fntFiltros()
{
	var botoes = {};
	botoes[traducoes.sOkText] = function() { jQuery(this).dialog("close"); fntEnviarFiltro(); };
	botoes[traducoes.sLimparText] = function() { fntLimpaForm(new Array(""), "divfiltro"); fntEnviarFiltro(); jQuery(this).dialog("close"); };
	botoes[traducoes.sCancelarText] = function() { jQuery(this).dialog("close"); jQuery(this).dialog("destroy"); };
	
	jQuery("#divfiltro").dialog({
	    cache: false,
	    width: 600,
	    height: 250,
	    title: traducoes.sTitFiltrosText,
		modal: true,
	    buttons: botoes
    });
}

function fntEnviarFiltro()
{
	var filtros = fntSerializa("divfiltro", true);
	
	/* ver se deve adicionar os filtros */
	var addfiltros = false;
	var arrfiltros = filtros.split("&");
	for (var i = 0; i < arrfiltros.length; i++)
	{
		var dados = arrfiltros[i].split("=");
		if (dados[1] != "")
		{
			addfiltros = true;
			break;
		}
	}
	
	var url = location.href;
	url = url.substring(0, (url.indexOf("&") > -1 ? url.indexOf("&") : url.length));
	
	location.href = url + (addfiltros ? ("&" + filtros) : "");
}

function fntNavegaTab(index)
{
	var url = location.href
	if (url.indexOf("&p=") > -1)
		url = url.substring(0, (url.indexOf("&") > -1 ? url.lastIndexOf("&") : url.length));
	location.href = url + "&p=" + index;
}

function setCookie(c_name,value,exdays)
{
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name)
{
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++)
    {
        x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x = x.replace(/^\s+|\s+$/g,"");
        if (x == c_name)
        {
            return unescape(y);
        }
    }
}

function fntMostraAcoes(id) {
    jQuery("#" + id).fadeToggle("fast");
}

function fntTrocaSenhaInterna()
{
	var botoesTrocaSenha = {};
	botoesTrocaSenha[traducoes.sOkText] = function() { fntGravaAlteracaoSenha(); };
	botoesTrocaSenha[traducoes.sCancelarText] = function() { jQuery(this).dialog("close");  };
	
	jQuery("#divFormPass").dialog({
		autoOpen: true,
		width: 200,
		height: 260,
		title: traducoes.sTrocaSenhaText,
		buttons: botoesTrocaSenha
    });
}

function fntGravaAlteracaoSenha() {
	var pA = jQuery.trim(jQuery("#txtSenhaAtual").val());
	var pN = jQuery.trim(jQuery("#txtNovaSenha").val());
	var pC = jQuery.trim(jQuery("#txtNovaSenha2").val());
	
	if ((pA == "") || (pN == "") || (pC == ""))
	{
		alert("Preencha todos os campos do formulário");
	}
	else
	{
		if (pN != pC)
		{
			alert("As senhas digitadas não são iguais");
		}
		else
		{
			fntWorking(true)
			
			var dados = "pA=" + escape(pA) + "&pN=" + escape(pN) + "&pC=" + escape(pC);
			jQuery.ajax({
				type: "POST",
				url: "ajaxtrocapass.php",
				data: dados,
				success: function(msg){
					if (msg != "OK")
					{
						fntWorking(false);
						alert(msg);
					}
					else
					{
						jQuery("#txtSenhaAtual").val("");
						jQuery("#txtNovaSenha").val("");
						jQuery("#txtNovaSenha2").val("");
						fntWorking(false);
						alert(traducoes.sSenhaTrocaOK);
						jQuery("#divFormPass").dialog("close");
						fntMostraAcoes('optsConta');
					}
				},
				error: function(http, text, err){
					alert(text);
				}
			});
		}
	}
}