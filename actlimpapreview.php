<?php
//--utf8_encode --
session_start();

include_once 'cls/resolucao.class.php';
include_once 'cls/usuario.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	$u = unserialize($_SESSION['usu']);
	
	$res = new Resolucao();
	$res->setCodcaso($_SESSION['casores']);
	$res->setCodUsuario($u->getCodigo());
	$msg = "";
	
	if ($u->TemGrupo(1) || ($u->TemGrupo(4)))
	{
		if (Caso::ConsultaSituacao($_SESSION['casores']) == 0)
		{
			if (!$res->LimpaResolucao())
			{
				$msg = "@lng[Erro ao limpar histórico de resoluções.]" . " " . $res->getErro();
			}
			else
			{
				$msg = "OK";
			}
		}
		else
		{
			$msg = "@lng[Erro. Este caso está publicado e não é possível limpar suas resoluções]";
		}
	}
	
	echo(Comuns::Idioma($msg));
}

Main();
?>