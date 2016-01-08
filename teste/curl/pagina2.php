<?php

//--utf8_encode --

function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
	
	$pageURL .= "://";
	
	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function Main()
{
	echo(curPageURL() . '<br />');
	
	
	$ch = curl_init();
	
	$data = array('nome' => 'Regis', 'secao' => 'exames');
	
	curl_setopt($ch, CURLOPT_URL , "HTTP://localhost/testes/cURL/pagina1.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	
	$output = curl_exec($ch);
	
	curl_close($ch);
	
	echo ("Retorno obtido: " . $output);
}

Main();
?>