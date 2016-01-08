<?php
//--utf8_encode --
include_once "cls/pergunta.class.php";
include_once 'inc/comuns.inc.php';

function Main()
{
	// Leitura do template
	$tpl = file_get_contents("tpl/perguntas.html");

	// Número de registros a exibir por página
	$limite = 10;
	$pagina = (isset($_GET['pag'])) ? $_GET['pag'] : 1;

	// Instancia a classe Pergunta
	$p = new Pergunta();

	// Se vier a instrução de inserir uma pergunta, faz isso
	$inserir = (isset($_POST['txtDescricao'])) ? $_POST['txtDescricao'] : null;
	if ( $inserir )
	{
		$p->setDescricao($inserir);
		$p->adicionar();
	}

	//  Começa a listagem das perguntas já cadastradas

	// Retorna uma lista das perguntas cadastradas
	$lista = $p->listarperguntas($pagina, $limite);
	if (($lista != 0) && (mysql_num_rows($lista) > 0))
	{
		// Se tem perguntas cadastradas, começa a montar a lista
		$html = '<ul>';

		while ( $linha = mysql_fetch_array($lista) )
		{
			$html .= '<li>' . $linha["Descricao"] . ' ( <a href="javascript:void(0);">X</a> )</li>';
		}

		$html .= '</ul><br /><br />';

		// Verifica quantas perguntas tem cadastradas ao todo
		$registros = $p->contaperguntas();

		// Se for necessário, adiciona ao fim da página os links para navegação (da paginação)
		if ($pagina > 1)
		{
			$html .= '<a href="perguntas.php?pag=' . ($pagina - 1) . '">Anterior</a> | ';
		}

		if ($registros > ($limite * $pagina))
		{
			$html .= '<a href="perguntas.php?pag=' . ($pagina + 1) . '">Proximo</a>';
		}
	}
	else
	{
		// Se não tem perguntas cadastradas, informa que não tem nenhuma
		$html = "@lng[Nenhuma pergunta cadastrada]";
	}

	$tpl = str_replace("<!--ListaPerguntas-->", $html, $tpl);

	header('Content-Type: text/html; charset=iso-8859-1');
	echo( comuns::Idioma($tpl) );
}

Main();
?>