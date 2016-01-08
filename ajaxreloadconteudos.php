<?php

//--utf8_encode --
session_start();
include_once 'cls/conteudo.class.php';
include_once 'cls/components/hashtable.class.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	$ht = new HashTable();
	
	if (isset($_SESSION['caso']) && ($_SESSION['caso']) != 0)
	{
		$c = new Conteudo();
		
		$ht->AddItem('cont', $c->Lista($_SESSION['caso']));
	}
	else
	{
		$ht->AddItem('cont', '@lng[Erro ao localizar o caso de estudo]');
	}

	echo $ht->ToXML();	
}

Main();

?>