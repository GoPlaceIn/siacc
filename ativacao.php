<?php
//--utf8_encode --
session_start();

include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';

function Main()
{
	$tpl = file_get_contents("tpl/frm-ativacao.html");
	
	$u = unserialize($_SESSION['usu']);

	$evento = "O usuário " . $u->getNome() . " (" . $u->getUsuario() . ") tentou acessar o sistema mas seu usuário ainda não estava ativo";
	Log::RegistraLog($evento);
	
	$mensagem = "";
	
	if ((isset($_SESSION['origem'])) && ($_SESSION['origem'] == "actvalidalogin.php"))
	{
		$mensagem .= "<p>@lng[Olá] <strong>" . $u->getNome() . "</strong>. @lng[Seus dados estão cadastrados no sistema e seu usuário será ativado em breve.]</p>";
		$mensagem .= "<p>@lng[Você receberá um e-mail de confirmação da ativação de sua conta.]</p>";
	}
	else
	{
		$mensagem .= "<p>@lng[Olá] <strong>" . $u->getNome() . "</strong>. @lng[Seus cadastro foi realizado com sucesso. Sua conta será ativada em breve.]</p>";
		$mensagem .= "<p>@lng[Aguarde receber por e-mail as instruções para a utilização do sistema.]</p>";
	}
	
	
	$_SESSION['usu'] = null;
	$tpl = str_replace("<!--mensagem-->", $mensagem, $tpl);
	
	echo($tpl);
}

Main();

?>