<?php
session_start();
require_once 'cls/pergunta.class.php';
include_once 'cls/usuario.class.php';

function Main()
{
	$classe = (isset($_GET['cls'])) ? $_GET['cls'] : null;
	$tipo = (isset($_GET['tip'])) ? $_GET['tip'] : null;
	$termo = $_GET['term'];

	$u = unserialize($_SESSION['usu']);
	$perg_atual = unserialize($_SESSION['perg']);

	if ($classe == 0)
	$classe = null;

	if ($tipo == 0)
	$tipo = null;

	$p = new Pergunta();

	$retorno = $p->ListaPerguntasAtivas($classe, $tipo, $termo, $perg_atual->getCodigo(), $u->getCodigo());

	$registros = count($retorno);

	if ($registros > 0)
	$dados = "<strong>" . $registros . "</strong> @lng[perguntas encontradas]<br /><br />";
	else
	$dados = "@lng[Nenhuma pergunta encontrada]<br /><br />";

	foreach ($retorno as $pergunta)
	{
		$dados .= '<img src="img/use-this.png" alt="@lng[Apontar para esta pergunta]" title="@lng[Apontar para esta pergunta]" onclick="javascript:fntAddPerguntaCombo(\'' . base64_encode($pergunta->Codigo) . '\', \'' . $pergunta->Texto . '\');">' . $pergunta->Texto . "<br /><hr />";
	}

	header('Content-Type: text/html; charset=iso-8859-1');
	echo($dados);
}

Main();

?>