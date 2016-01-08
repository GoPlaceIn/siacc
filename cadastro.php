<?php
//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/conexao.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/permissao.class.php';
include_once 'cls/grupo.class.php';
include_once 'cls/classes.class.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/area.class.php';
include_once 'cls/tipoexame.class.php';
include_once 'cls/grupopergunta.class.php';
include_once 'cls/instituicao.class.php';
include_once 'cls/log.class.php';

include_once 'cls/components/botao.class.php';

function Main()
{
	$codTPL = $_GET["t"];
	$codReg = $_GET["r"];
	$editar = false;
	$u = unserialize($_SESSION["usu"]);

	if ( ! is_numeric( $codTPL ) )
	{
		$msg = "Ação inválida";
		header("Location:index.php?msg=" . $msg);
	}

	//Verifica se veio um código para ser editado
	if (isset($codReg) && ($codReg != ""))
	{
		$codReg = base64_decode($codReg);
		$editar = true;
	}

	$cnn = new Conexao();

	$sql = "SELECT Arquivo FROM mestemplates WHERE Codigo = 3;";
	$rs = $cnn->Consulta($sql);
	$tpl_p = file_get_contents(mysql_result($rs, 0, "Arquivo"));
	$tpl_p = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl_p);
	
	$tpl_p = str_replace("<!--Mensagem-->", (isset($mensagem) && $mensagem != "") ? base64_decode($mensagem) : "", $tpl_p);
	
	$sql  = "SELECT Classe, jsLoad, CodPermissao, linkSalva, linkVolta ";
	$sql .= "FROM mestemplates WHERE Codigo = " . $codTPL . ";";
	
	$rs = $cnn->Consulta($sql);

	if ( $rs != 0 )
	{
		// Classe que será instanciada e permissão necessária para acessar a tela
		$classe = mysql_result($rs, 0, "Classe");
		$permissao = mysql_result($rs, 0, "CodPermissao");
		$funload = mysql_result($rs, 0, "jsLoad");

		if ($u->TemPermissao($permissao))
		{
			$frm = new $classe;
			
			if ($editar)
			{
				// Se vier um comando de edição de registro, monta o form com os dados do registro solicitado
				Log::RegistraLog("Acessou a tela de " . $frm->RetornaDescricaoTela('cadastro') . " para editar o registro " . $codReg);
				$tpl = $frm->FormEdita($codReg);
			}
			else
			{
				// Senão, monta um formulário em branco
				Log::RegistraLog("Acessou a tela de " . $frm->RetornaDescricaoTela('cadastro') . " para inserir um novo registro");
				$tpl = $frm->FormNovo();
			}
			
			if ((!is_null($funload)) && ($funload != ''))
			{
				$tpl_p = str_replace('<!--javaonload-->', $funload, $tpl_p);
			}
			else
			{
				$tpl_p = str_replace('<!--javaonload-->', '', $tpl_p);
			}
			
			$botoes  = Botao::BotaoSalvar(mysql_result($rs, 0, "linkSalva"));
			$botoes .= Botao::BotaoVoltar(mysql_result($rs, 0, "linkVolta"));
			$tpl_p = str_replace("<!--itens-toolbar-->", $botoes, $tpl_p);
		}
		else
		{
			$msg = base64_encode("@lng[Você não tem permissão para acessar esta tela]");
			header("Location:interna.php?msg=" . $msg);
		}
	}
	else
	{
		$msg = "@lng[Página inválida]";
		header("Location:index.php?msg=" . $msg);
	}

	$tpl_p = str_replace("##Formulario##", $tpl, $tpl_p);
	header('Content-Type: text/html; charset=iso-8859-1');
	echo( Comuns::Idioma($tpl_p) );
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}
?>