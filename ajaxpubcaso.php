<?php
session_start();
include_once 'cls/conexao.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/caso.class.php';
include_once 'cls/log.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$u = unserialize($_SESSION['usu']);
		//$u = new Usuario();
		
		if ($u->TemPermissao(25))
		{
			if (($_POST['p'] == "false") || ($_POST['p'] == "true"))
			{
				if ($_POST['p'] == "true")
				{
					Log::RegistraLog("Publicou o caso clínico " . $_SESSION['caso']);
					$acao = true;
				}
				else
				{
					Log::RegistraLog("Despublicou o caso clínico " . $_SESSION['caso']);
					$acao = false;
				}
				
				$c = new Caso();
				$c->setCodigo($_SESSION['caso']);
				$ret = $c->PublicaCaso($acao);
				
				if ($ret)
				{
					echo("OK");
				}
				else
				{
					echo($c->getErro());
				}
			}
			else
			{
				echo("@lng[Dados informados inválidos]");
			}
		}
		else
		{
			echo("@lng[Você não tem permissões suficientes para realizar esta operação]");
		}
	}
	else
	{
		echo("@lng[Erro ao localizar caso para ser publicado]");
	}
}

Main();
?>