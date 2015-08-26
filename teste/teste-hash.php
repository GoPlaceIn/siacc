<?php
include_once '../cls/components/hashtable.class.php';

function Main()
{
	$hash = new HashTable();
	
	echo("Primeiro teste: Adicionar elementos<br /><br />");
	
	$hash->AddItem("Nome", "Regis");
	$hash->AddItem("Sobrenome", "Sebastiani");
	
	echo("Segundo teste: Verificar se existem elementos<br /><br />");
	
	if ($hash->ContainsKey("Sobrenome"))
		echo("Tem Sobrenome<br /><br />");
	else
		echo("N�o tem Sobrenome<br /><br />");
		
	if ($hash->ContainsKey("Endere�o"))
		echo("Tem Endere�o<br /><br />");
	else
		echo("N�o tem Endere�o<br /><br />");
	
	if ($hash->ContainsValue("Regis"))
		echo("Tem o valor Regis<br /><br />");
	else
		echo("N�o tem o valor Regis<br /><br />");
	
	if ($hash->ContainsValue("teste"))
		echo("Tem o valor teste<br /><br />");
	else
		echo("N�o tem o valor teste<br /><br />");
	
	echo("Terceiro teste: Recuperando um valor<br /><br />");
	
	echo($hash->getValue("Nome") . "<br /><br />");
	
	echo("Quarto teste: Gerando XML<br /><br />");
	
	echo($hash->ToXML());
}

Main();

?>