<?php
include_once 'cls/conexao.class.php';

function Main()
{
	
	$termo = "%" . $_GET['term'] . "%";
	$sql = "select Codigo, NomeCompleto, NomeUsuario, Email from mesusuario where NomeCompleto like :pNome";
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pNome", $termo, PDO::PARAM_STR);
	
	$cmd->execute();
	$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
	$itens = array();
	
	foreach ($rs as $linha)
	{
		$itens[] = array(
					"id" => $linha->Codigo, 
					"usuario" => utf8_encode($linha->NomeUsuario), 
					"value" => utf8_encode($linha->NomeCompleto) 
		);
	}
	
	$json = json_encode($itens);
	
	//header('Content-type: application/json; charset=UTF-8');
	echo($json);
}

Main();

?>