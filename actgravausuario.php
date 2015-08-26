<?php
session_start();
include_once 'cls/usuario.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	$cod = $_POST["c"];
	$nom = urldecode($_POST["n"]);
	$usu = urldecode($_POST["u"]);
	$ema = urldecode($_POST["e"]);
	$ins = $_POST["i"];
	$idi = $_POST["l"];
	$sen = urldecode($_POST["s"]);
	$ati = $_POST["a"];

	header('Content-Type: text/html; charset=iso-8859-1');

	try
	{
		$ret = "";
		
		$u = new Usuario();
		if ($cod != "") { $u->setCodigo($cod); }
		if ($nom != "") { $u->setNome($nom); }
		if ($usu != "") { $u->setUsuario($usu); }
		if ($ema != "") { $u->setEmail($ema); }
		if ($ins != "") { $u->setCodigoInstituicao($ins); }
		if ($idi != "") { $u->setCodIdioma($idi); }
		if ($sen != "") { $u->setSenha($sen); }
		if ($ati != "") { $u->setAtivo($ati); }
		if ($cod == "")
		{
			if($u->AdicionaUsuario())
			{
				$ret = "GRAVADO";
			}
			else
			{
				$ret = $u->getErro();
			}
		}
		else
		{
			if($u->AtualizaUsuario())
			{
				$ret = "GRAVADO";
			}
			else
			{
				$ret = $u->getErro();
			}
		}
		
		echo( Comuns::Idioma($ret) );
	}
	catch (Exception $ex)
	{
		echo( Comuns::Idioma($ex->getMessage()) );
	}
}

Main();
?>