<?php

class viewUsuario
{
	private $tplLista;
	private $tplEdita;

	public function __construct()
	{
		$this->tplLista = '../tpl/listapadr.html';
		$this->tplEdita = '../tpl/cadpad.html';
	}

	public function MostraTelaLista($list)
	{
		$template = file_get_contents($this->tplLista);

		$dados  = '<table>';
		$dados .= '  <tr>';
		$dados .= '    <td>Codigo</td>';
		$dados .= '    <td>Nome</td>';
		$dados .= '  </tr>';

		foreach ($list as $item)
		{
			$dados .= '  <tr>';
			$dados .= '    <td>' . $item->Codigo . '</td>';
			$dados .= '    <td><a href="usuario.php?a=e&c=' . $item->Codigo . '">' . $item->NomeCompleto . '</a></td>';
			$dados .= '  </tr>';
		}

		$dados .= '</table>';

		$template = str_replace("<!--lista-->", $dados, $template);

		return $template;
	}

	public function MostraTelaNovo()
	{
		$template = file_get_contents($this->tplEdita);

		$template = str_replace("<!--codigo-->", "", $template);
		$template = str_replace("<!--nome-->", "", $template);

		return $template;
	}

	public function MostraTelaEdita($reg)
	{
		$template = file_get_contents($this->tplEdita);

		foreach ($reg as $item)
		{
			$template = str_replace("<!--codigo-->", $item->Codigo, $template);
			$template = str_replace("<!--nome-->", $item->NomeCompleto, $template);
		}

		return $template;
	}
}
?>