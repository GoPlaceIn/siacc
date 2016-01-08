<?php
//--utf8_encode --
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/tipopergunta.class.php';
include_once 'cls/usuario.class.php';

function Main()
{
	try
	{
		$n = new NivelPergunta();

		$nivel = $n->ListaRecordSet();
		if (($nivel != 0) && (mysql_num_rows($nivel) > 0))
		{
			$strNiveis .= "<>";
		}
	}
	catch (Exception $ex)
	{
		$msg = base64_encode($ex->getMessage());
		header("Location:vwerro.php?m=" . $msg);
	}
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