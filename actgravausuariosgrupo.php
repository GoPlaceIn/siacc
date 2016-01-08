<?php
//--utf8_encode --
session_start();
include_once 'cls/grupo.class.php';
include_once 'cls/permissao.class.php';
include_once 'cls/usuario.class.php';
include_once 'inc/comuns.inc.php';

include_once 'Image.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	$grupo = (isset($_POST["cg"]) && is_numeric($_POST["cg"])) ? $_POST["cg"] : 0;
	$usuarios = (isset($_POST["u"])) ? $_POST["u"] : "";
	$msg = "";
	
	if ($grupo != 0)
	{
		if ($usuarios != "")
		{
			try
			{
				$g = new Grupo();
				$g->setCodigo($grupo);
				if ($g->DeletaTodosOsUsuarios())
				{
					$usuarios = split("-", $usuarios);
					foreach($usuarios as $usuario)
					{
						$g->AdicionaUsuarioAoGrupo($usuario);
					}
					return "GRAVOU";
				}
				else
				{
					$msg = "@lng[Não consegui excluir]";
				}
			}
			catch (Exception $ex)
			{
				throw new Exception($ex->getMessage(), $ex->getCode());
			}
		}
		else
		{
			$msg = "@lng[Usuarios não informados]";
		}
	}
	else
	{
		$msg = "@lng[Grupo não informado]";
	}
	
	echo(Comuns::Idioma($msg));
}

Main();

?>