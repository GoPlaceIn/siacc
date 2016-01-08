<?php
//--utf8_encode --
include_once 'cls/usuario.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/grupo.class.php';
include_once 'cls/components/combobox.php';
include_once 'inc/comuns.inc.php';

function RenderOpcoes()
{
	$u = unserialize($_SESSION['usu']);
	
	$tpl = file_get_contents("tpl/frm-opcoeslogin.html");
	$grupos = null;
	
	foreach ($u->getGrupos() as $grupo)
	{
		$grupos .= (($grupos != "") ? (", " . $grupo) : $grupo);
	}
	
	$sql  = "select Codigo, Descricao from mesgrupousuario where Codigo IN(" . $grupos . ") and Codigo <> 3;";
	$cnn = Conexao2::getInstance();
	$cmd = $cnn->prepare($sql);
	$cmd->execute();
	$dsPerfis = $cmd->fetchAll(PDO::FETCH_OBJ);
	
	if ($grupos)
	{
		$cmbGrupos = new ComboBox();
		$cmbGrupos->ID("selPerfil");
		$cmbGrupos->setDataSet($dsPerfis);
		$cmbGrupos->setDataValueField("Codigo");
		$cmbGrupos->setDataTextField("Descricao");
		$cmbGrupos->setDefaultValue("0");
		$cmbGrupos->setDefaultText("@lng[Selecione]");
		$cmbGrupos->cssClass("campo req");
		
		$htmlCombo = $cmbGrupos->RenderHTML();
	}
	else
	{
		$htmlCombo = "<p>@lng[Não existem perfis associados ao seu usuário]</p>";
	}
	
	$tpl = str_replace("<!--Perfis-->", $htmlCombo, $tpl);
	
	echo( Comuns::Idioma($tpl) );
}

function fntBuscaPagina()
{
	$u = unserialize($_SESSION['usu']);
	$g = $_POST['selPerfil'];
	
	if ($u->TemGrupo($g))
	{
		$sql = "select PaginaInicial from mesgrupousuario where Codigo = :pCodigo";
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodigo", $g, PDO::PARAM_INT);
		$cmd->execute();
		
		return $cmd->fetchColumn();
	}
	else
	{
		return null;
	}
}

function Main()
{
	if ($_POST['selPerfil'])
	{
		$redir = fntBuscaPagina();
		
		if ($redir)
		{
			header("Location:" . $redir);
		}
		else
		{
			RenderOpcoes();
		}
	}
	else
	{
		RenderOpcoes();
	}
}

Main();
?>