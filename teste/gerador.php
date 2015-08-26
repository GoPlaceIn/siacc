<?php

function fntGeraPrivates($params)
{
	$ret = "";

	$vars = split(";", $params);

	foreach ($vars as $item)
	{
		$ret .= 'private $' . $item . ';' . "\r\n";
	}

	return $ret;
}

function fntGeraGets($params)
{
	$ret = "";

	$vars = split(";", $params);

	foreach ($vars as $item)
	{
		$ret .= 'public function get' . strtoupper( substr( $item, 0, 1 ) ) . substr( $item, 1 ) . '()';
		$ret .= "\r\n" . '{' . "\r\n\t" . 'return $this->' . $item . ';' . "\r\n" . '}'. "\r\n\r\n";
	}

	return $ret;
}

function fntGeraSeters($params)
{
	$ret = "";
	$cod = 1000;

	$vars = split(";", $params);

	foreach ($vars as $item)
	{
		$ret .= 'public function set' . strtoupper( substr( $item, 0, 1 ) ) . substr( $item, 1 ) . '($p_' . $item . ')';
		$ret .= "\r\n" . '{' . "\r\n\t" . 'if ((isset($p_' . $item . ')) && (!is_null($p_' . $item . ')))';
		$ret .= "\r\n\t" . '{' . "\r\n\t\t" . '$this->' . $item . ' = $p_' . $item . ';';
		$ret .= "\r\n\t" . '}' . "\r\n\t" . 'else';
		$ret .= "\r\n\t" . '{' . "\r\n\t\t" . 'throw new Exception("", ' . $cod . ');';
		$ret .= "\r\n\t" . '}' . "\r\n" . '}'. "\r\n\r\n";
		
		$cod += 10;
	}

	return $ret;
}


$tudo  = fntGeraPrivates($_GET['v']);
$tudo .= "\r\n";
$tudo .= fntGeraGets($_GET['v']);
$tudo .= "\r\n";
$tudo .= fntGeraSeters($_GET['v']);

file_put_contents("C:\\temp\\funcoes.txt", $tudo);

echo("Arquivo gerado!");

?>