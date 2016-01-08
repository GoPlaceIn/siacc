<?php

//--utf8_encode --

if (isset($_REQUEST['par']))
{
	echo("isset = true");
}

if (is_null($_REQUEST['par']))
{
	echo("is_null = true");
}

if ($_REQUEST['par'])
{
	echo("<br />diretão");
}

?>