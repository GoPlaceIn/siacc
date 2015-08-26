<?php
include_once 'cls/conexao.class.php';

function fntSetLanguage()
{
	
	
	if ($_GET['lang'])
		$lang = $_GET['lang'];
	else
		$lang = "pt-br";
	
	
	//$gettext_domain = split("_", $lang);
	 
	//putenv("LC_ALL=$gettext_domain[0]");
	/*
	setlocale(LC_ALL, $lang . ".iso-8859-1");
	bindtextdomain($gettext_domain[0], "locale");
	textdomain($gettext_domain[0]);
	bind_textdomain_codeset($gettext_domain[0], 'iso-8859-1');
*/
	/*
	$gettext_domain = 'en_US';
	
	setlocale(LC_ALL, 'en_US');
	bindtextdomain('en_US', "locale");
	textdomain('en');
	bind_textdomain_codeset('en', 'iso-8859-1');
	*/

}

?>