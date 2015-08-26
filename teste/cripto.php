<?php
function Main()
{
	//echo( md5("kmvd96Ui_") );
	
	$texto = 'Meu gato pôs um ovo';
	$key = 'main katz hot an oi kalet';
	$iv = '12345678';
	
	$cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
	
	mcrypt_generic_init($cipher, $key, $iv);
	$encrypted = mcrypt_generic($cipher,$texto);
	mcrypt_generic_deinit($cipher);
	
	mcrypt_generic_init($cipher, $key, $iv);
	$decrypted = mdecrypt_generic($cipher,$encrypted);
	mcrypt_generic_deinit($cipher);
	
	echo "encrypted..: ".$encrypted;
	echo "<br>";
	echo "enc base 64: ".base64_encode($encrypted);
	echo "<br>";
	echo "enc base 64: ".base64_decode(base64_encode($encrypted));
	echo "<br>";
	echo "decrypted..: ".$decrypted;
}

Main();
?>