<?php
session_start();
include_once 'cls/grupo.class.php';
include_once 'cls/permissao.class.php';
include_once 'cls/usuario.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$grupo = (isset($_POST["cg"]) && is_numeric($_POST["cg"])) ? $_POST["cg"] : 0;
	$permissoes = (isset($_POST["p"]) && (trim($_POST["cg"]) != "")) ? $_POST["p"] : "";

	if ($grupo != 0)
	{
		if ($permissoes != "")
		{
			try
			{
				$g = new Grupo();
				$g->setCodigo($grupo);
				if ($g->DeletaTodasPermissoes())
				{
					$permissoes = split("-", $permissoes);
					foreach($permissoes as $perm)
					{
						$g->AdicionaPermissaoGrupoUsuario($perm);
					}
				}
				echo("OK");
			}
			catch (Exception $ex)
			{
				throw new Exception($ex->getMessage(), $ex->getCode());
			}
		}
		else
		{
			$g = new Grupo();
			$g->setCodigo($grupo);
			if ($g->DeletaTodasPermissoes())
			{
				echo("OK");
			}
			else
			{
				echo("Erro");
			}
		}
	}
	else
	{
		echo(Comuns::Idioma("@lng[Grupo não informado]"));
	}
}

Main();

?>