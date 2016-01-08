<?php

//--utf8_encode --
session_start();
include_once 'cls/midia.class.php';
include_once 'inc/comuns.inc.php';

if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
{
	$mid = new Midia();
	$mid->setCodCaso($_SESSION['caso']);
	$mid->setCodMidia(base64_decode($_POST['img']));
	$mid->setDescricao((($_POST['txtDescricao'] != "") ? urldecode($_POST['txtDescricao']) : null));
	$mid->setComplemento((($_POST['txtComplemento'] != "") ? urldecode($_POST['txtComplemento']) : null));
	$mid->setURL((($_POST['txtURL'] != "") ? urldecode($_POST['txtURL']) : null));
	$mid->setLargura((($_POST['txtLargura'] != "") ? urldecode($_POST['txtLargura']) : null));
	$mid->setAltura((($_POST['txtAltura'] != "") ? urldecode($_POST['txtAltura']) : null));	
	if($mid->Atualiza())
	{
		echo("@lng[Dados atualizado com sucesso!]");
	}
	else
	{
		echo("@lng[ERRO ao atualizar os dados!]");
	}
}
else
{
	echo("@lng[ERRO Não foi possível atualizar os dados.]");	
}
?>