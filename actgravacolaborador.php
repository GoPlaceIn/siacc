<?php
session_start();
include_once('cls/caso.class.php');
include_once('inc/comuns.inc.php');

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	$usuarios = (isset($_POST["u"])) ? $_POST["u"] : "";
	$msg = "";

	if (isset($_SESSION['caso']) && ($_SESSION['caso'] != 0))
	{
		if ($usuarios != "")
		{
			try
			{
				$c = new Caso();
				$c->setCodigo($_SESSION['caso']);
				if ($c->DeletaTodosOsColaboradores())
				{
					$usuarios = split("-", $usuarios);
					foreach($usuarios as $usuario)
					{
						$c->AdicionaColaboradorAoCaso($usuario);
					}
					echo("GRAVOU");
				}
				else
				{
					$msg = "@lng[Não foi possível excluír o colaborador.]";
				}
			}
			catch (Exception $ex)
			{
				throw new Exception($ex->getMessage(), $ex->getCode());
			}
		}
		else
		{
			$msg = "@lng[Usuários não informados]";
		}
	}
	else
	{
		$msg = "@lng[Caso não identificado.]";
	}
	
	echo(Comuns::Idioma($msg));
}

Main();

?>