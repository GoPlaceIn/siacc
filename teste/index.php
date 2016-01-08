<?php

//--utf8_encode --

 class Conexao
{
	public static $instance;

	public function getInstance()
	{
		if (!isset(self::$instance))
		{
			self::$instance = new PDO("mysql:host=localhost;dbname=mestrado","root","");
		}
		return self::$instance;
	}
}

function Main()
{
	echo(base64_encode("ins"));
	return 0;


	$cnn = Conexao::getInstance();
	$codigo = 1;
	$q = $cnn->prepare("SELECT * FROM mesClassePergunta where Codigo = :Codigo");
	$q->bindParam(":Codigo", $codigo, PDO::PARAM_INT);
	$q->execute();
	echo($q->rowCount() . "<br />");
	while ($linha = $q->fetch(PDO::FETCH_OBJ))
	{
		echo($linha->Codigo . " - " . $linha->Descricao);
	}
}


Main();
?>
