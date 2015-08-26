<?php
session_start();

include_once 'cls/pergunta.class.php';
include_once 'cls/alternativa.class.php';
include_once 'inc/comuns.inc.php';


function Main()
{
	$p = $_SESSION['perg'];
	$codalt = (isset($_GET['a']) && (! is_null($_GET['a']))) ? base64_decode($_GET['a']) : null;

	if (is_numeric($codalt))
	{
		//$codperg = $p->getCodigo();
		$pergunta = new Pergunta();
		$pergunta->setCodigo($p);
		$alt = new Alternativa();
		$alt->Carrega($codalt);
		if ($pergunta->DeletaAlternativa($alt))
		{
			//$pergunta->RecarregarAlternativas();
			//$_SESSION['perg'] = serialize($p);
			header("Location:vwalternativas.php?p=" . base64_encode($p));
		}
		else
		{
			$erros = "Erros ocorreram.";
			foreach ($p->msg_erro as $err)
			{
				$erros .= "<br />" . $err;
			}
			echo($erros);
		}
	}
}
if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("Você deve estar logado para acessar esta tela");
	header("Location:index.php?m=" . $msg);
}


?>