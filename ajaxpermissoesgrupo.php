<?php
session_start();
require_once 'cls/grupo.class.php';

function Main()
{
	if (isset($_POST["cg"]) && $_POST["cg"] != "")
	{
		$codgrupo = $_POST["cg"];

		$rs = Grupo::ListaPermissoesTodas($codgrupo);

		if ($rs != false)
		{
			$opts .= '<select id="selPermissoes" name="selPermissoes" class="selmultiplo largo" size="10" multiple="multiple">';
				
			if (mysql_num_rows($rs) > 0)
			{
				while ($linha = mysql_fetch_array($rs))
				{
					if ($linha["Pode"] == 1)
					{
						$opts .= '<option selected="selected" value="' . $linha["Codigo"] . '">' . $linha["Descricao"] . '</option>';
					}
					else
					{
						$opts .= '<option value="' . $linha["Codigo"] . '">' . $linha["Descricao"] . '</option>';
					}
				}
			}
				
			$opts .= '</select>';
		}
		else
		{
			$opts .= 'vazio';
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