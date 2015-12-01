<?php
session_start();
include_once 'cls/curso.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';

function Main()
{

	$u = unserialize($_SESSION['usu']);
	
	$cod = $_POST['txtCodigo'];
	$nomecomp = $_POST['txtNomeCurso'];

	
	$data = date("Y-m-d H:i:s");
	$usuario = $u->getCodigo();
	
	header('Content-Type: text/html; charset=iso-8859-1');
	
	try
	{
		$i = new Curso();
		
		
		if ($nomecomp != "") { $i->setNomeCompleto($nomecomp); }
		if ($sigla != "") { $i->setSigla($sigla); }

		
		if ($cod == "")
		{
			if ($i->Insere())
			{
				Log::RegistraLog("Instituição de ensino " . $nomecomp . " inserido pelo usuário " . $u->getNome() . ".", 0);
				echo("GRAVADO");
			}
			else 
			{
				Log::DetalhaLog("Erro ao tentar inserir a instituição de ensino " . $nomecomp . ". " . $i->getErro(), 1);
				echo($i->getErro());
			}
		}
		else
		{
			if ($i->Altera())
			{
				Log::RegistraLog("Instituição de ensino " . $nomecomp . " atualizada pelo usuário " . $u->getNome() . ".", 0);
				echo("GRAVADO");
			}
			else 
			{
				Log::DetalhaLog("Erro ao tentar atualizar a instituição de ensino " . $nomecomp . ". " . $i->getErro(), 1);
				echo($i->getErro());
			}
		}
	}
	catch (Exception $ex)
	{
		echo($ex->getMessage());
	}
}



Main();
?>