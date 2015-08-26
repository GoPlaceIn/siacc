<?php
session_start();
require_once 'cls/grupo.class.php';
require_once 'cls/usuario.class.php';

function Main()
{
	if (isset($_POST["cg"]) && $_POST["cg"] != "")
	{
		$codgrupo = $_POST["cg"];
		$pesquisa = $_POST["m"];

		if ($pesquisa == 2)
		{
			$rs = Grupo::ListaUsuariosGrupo($codgrupo);
		}
		else if ($pesquisa == 1)
		{
			$rs = Grupo::ListaUsuariosForaDoGrupo($codgrupo);
		}

		if ($rs != 0)
		{
			if (mysql_num_rows($rs) > 0)
			{
				while ($linha = mysql_fetch_array($rs))
				{
					$opts .= '<option ' . ($linha["Ativo"] == true ? '' : 'class="item-inativo"') . ' value="' . $linha["Codigo"] . '">' . $linha["NomeCompleto"] . ' (' . $linha["NomeUsuario"] . ($linha["Ativo"] == true ? '' : ' - X') . ')</option>';
				}
			}
			else
			{
				$opts = '';
			}
		}
		else
		{
			$opts = '';
		}

		header('Content-Type: text/html; charset=iso-8859-1');
		echo($opts);
	}
	else
	{
		throw new Exception("@lng[Selecione um grupo para realizar esta operação]", 1000);
	}
}

Main();
?>