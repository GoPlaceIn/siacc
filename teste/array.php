<?php

//--utf8_encode --

$a[1] = "Regis <regisls@gmail.com>";
//$a[2] = "Agathe <agathe@feevale.br>";

//echo(count($a));

$destino = "";

foreach ($a as $endereco)
{
	$destino .= ($destino != "" ? ", " : "") . $endereco;
}

echo($destino);

?>