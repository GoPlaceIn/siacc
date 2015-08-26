<?php
session_start();

function Main()
{
	$imagemCaptcha = imagecreatefrompng("img/captcha-fundo.png");
	$fonteCaptcha = imageloadfont("bradhitc.ttf");
	//$fonteCaptcha = imageloadfont("wst_czec.fon");
	$textoCaptcha = substr(md5(uniqid('')),-9,9);
	
	$_SESSION['session_textoCaptcha'] = $textoCaptcha;
	
	$corCaptcha = imagecolorallocate($imagemCaptcha,0,0,0);
	
	imagestring($imagemCaptcha,$fonteCaptcha,15,5,$textoCaptcha,$corCaptcha);
	
	header('Content-Type: image/png; charset=iso-8859-1');
	imagepng($image = $imagemCaptcha, $filename = null, $quality = 0);
	
	imagedestroy($imagemCaptcha);
}

Main();

?>