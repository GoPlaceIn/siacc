<?php

include_once 'cls/email.class.php';

function Main()
{
	$mail = new Email();
	$mail->setRemetente("regisls@regisls.net");
	$mail->setDestinatario("regisls@gmail.com");
	$mail->setAssunto("[SIACC] Teste de envio de e-mail");
	$mail->setMensagem("Corpo do email.<br /><br />Quebra de linha.");
	
	$mail->Enviar();
}

Main();

?>