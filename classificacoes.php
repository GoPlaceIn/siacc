<?php
require_once "cls/classes.class.php";

function Main()
{
	// Leitura do template
	$tpl = file_get_contents("tpl/classes.html");

	// Número de registros a exibir por página
	$limite = 10;
	$pagina = (isset($_GET['pag'])) ? $_GET['pag'] : 1;

	// Instancia a classe Pergunta
	$c = new Classes();

	// Se vier a instrução de inserir uma pergunta, faz isso
	$descricao = (isset($_POST['txtDescricao'])) ? $_POST['txtDescricao'] : null;
	if ( $descricao )
	{
		$c->setDescricao($descricao);
		if (isset($_POST['txtComplemento']))
		{
			$c->setComplemento($_POST['txtComplemento']);
		}
		$c->adicionar();
	}

	//  Começa a listagem das perguntas já cadastradas

	// Retorna uma lista das perguntas cadastradas
	$lista = $c->listarclasses($pagina, $limite);
	if (($lista != 0) && (mysql_num_rows($lista) > 0))
	{
		// Se tem perguntas cadastradas, começa a montar a lista
		$html = '<ul>';

		while ( $linha = mysql_fetch_array($lista) )
		{
			$html .= '<li>' . $linha["Descricao"] . ' ( <a href="javascript:void(0);" title="' . $linha["TextoDescritivo"] . '">X</a> )</li>';
		}

		$html .= '</ul><br /><br />';

		// Verifica quantas perguntas tem cadastradas ao todo
		$registros = $c->contaclasses();

		// Se for necessário, adiciona ao fim da página os links para navegação (da paginação)
		if ($pagina > 1)
		{
			$html .= '<a href="classificacoes.php?pag=' . ($pagina - 1) . '">@lng[Anterior]</a> | ';
		}

		if ($registros > ($limite * $pagina))
		{
			$html .= '<a href="classificacoes.php?pag=' . ($pagina + 1) . '">@lng[Proximo]</a>';
		}
	}
	else
	{
		// Se não tem perguntas cadastradas, informa que não tem nenhuma
		$html = "@lng[Nenhuma pergunta cadastrada]";
	}

	$tpl = str_replace("<!--ListaClasses-->", $html, $tpl);

	echo( $tpl );
}

Main();
?>