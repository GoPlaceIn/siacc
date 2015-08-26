<?php

	$texto = "regis <nome>leandro</nome> sebastiani";
	
	$tag = "nome";
	
	$ini = strpos($texto, ("<".$tag.">")) + strlen($tag) + 2;
	$fim = strpos($texto, ("</".$tag.">"));
	
	echo($ini . " " . $fim . "<br />");
	
	echo(substr($texto, $ini, ($fim - $ini)));

?>