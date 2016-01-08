<?php
//--utf8_encode --
session_start();

include_once "cls/conexao.class.php";
include_once 'inc/comuns.inc.php';

function Main()
{
	try
	{
		$obj = new ReflectionClass("Comuns");

		$tabela = $_POST['t'];
		$tabela = $obj->getConstant($tabela);

		$registro = base64_decode($_POST['r']);

		$sql = "SELECT Ativo FROM " . $tabela . " WHERE Codigo = :pcod;";

		$cnn = Conexao2::getInstance();

		$q = $cnn->prepare($sql);
		$q->bindParam(":pcod", $registro, PDO::PARAM_INT);
		$q->execute();

		$rs = $q->fetch(PDO::FETCH_OBJ);

		if ($rs->Ativo == 1)
		{
			$status = 0;
		}
		else
		{
			$status = 1;
		}

		$q->closeCursor();

		$sql = "UPDATE " . $tabela . " SET Ativo = :pnovo WHERE Codigo = :pcod;";

		$q = $cnn->prepare($sql);
		$q->bindParam(":pnovo", $status, PDO::PARAM_INT);
		$q->bindParam(":pcod", $registro, PDO::PARAM_INT);

		$q->execute();

		echo($status);
	}
	catch (PDOException $ex)
	{
		echo($ex->getMessage());
	}
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}

?>