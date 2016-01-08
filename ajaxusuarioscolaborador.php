<?php
//--utf8_encode --
session_start();
require_once 'cls/caso.class.php';

function Main()
{
	if (isset($_SESSION['caso']) && ($_SESSION['caso'] != 0))
	{
		$c = new Caso();
		$c->setCodigo($_SESSION['caso']);
		$rs = $c->ListaUsuariosColaboradores();

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
		throw new Exception("@lng[Caso não identificado.]", 1000);
	}
}

Main();
?>