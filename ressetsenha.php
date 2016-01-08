<?php
//--utf8_encode --
session_start();

include_once 'cls/conexao.class.php';
include_once 'cls/email.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';
include_once 'inc/comuns.inc.php';

function createRandomPassword() { 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    }

    return $pass;
}

function MontaJanela($strErrado)
{
	$tpl = file_get_contents("tpl/frm-recover.html");
	
	$intNum1 = rand(1, 10);
	$intNum2 = rand(1, 10);
	$intOper = rand(1, 3);
	
	switch($intOper)
	{
		case 1:
			$intResp = $intNum1 * $intNum2;
			$strPerg = $intNum1 . ' x ' . $intNum2;
			break;
		case 2:
			$intResp = $intNum1 + $intNum2;
			$strPerg = $intNum1 . ' + ' . $intNum2;
			break;
		case 3:
			$intResp = $intNum1 - $intNum2;
			$strPerg = $intNum1 . ' - ' . $intNum2;
			break;
	}
	$_SESSION['resp_perg'] = $intResp;
	
	if ($strErrado === true)
	{
		$tpl = str_replace("<!--mensagem-->", "@lng[Resposta da operação errada. Tente novamente.]", $tpl);
		$tpl = str_replace("<!--txtEmail-->", $_POST['txtEmail'], $tpl);
		$tpl = str_replace("<!--txtNome-->", $_POST['txtNome'], $tpl);
	}
	else
	{
		$tpl = str_replace("<!--mensagem-->", "", $tpl);
		$tpl = str_replace("<!--txtEmail-->", "", $tpl);
		$tpl = str_replace("<!--txtNome-->", "", $tpl);
	}
	
	$tpl = str_replace("<!--operacao-->", $strPerg, $tpl);
	return $tpl;
}

function AlteraSenha($strNova)
{
	$sql  = "SELECT Codigo FROM mesusuario ";
	$sql .= "WHERE NomeCompleto = :pNome AND Email = :pEmail";
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pNome", $_POST['txtNome'], PDO::PARAM_STR);
	$cmd->bindParam(":pEmail", $_POST['txtEmail'], PDO::PARAM_STR);
	
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			$intCodUsu = $cmd->fetchColumn(0);
			$strNome = $_POST['txtNome'];
			$strEmail = $_POST['txtEmail'];
			
			$u = new Usuario();
			$u->Carrega($intCodUsu);
			if ($u->getCodigo() !== null)
			{
				if ($u->AlteraSenha(md5($strNova), $_POST['txtResposta']))
				{
					$mens  = "@lng[Prezado] " . $strNome . "<br />";
					$mens .= "@lng[Você esta recebendo este e-mail porque solicitou que fosse gerada uma nova senha no sistema SIACC.] ";
					$mens .= "@lng[Segue abaixo a nova senha gerada pelo sistema. É altamente recomendavel que você a altere. Se não foi você que] ";
					$mens .= "@lng[solicitou esta alteração recomendamos que altere imediatamente sua senha.]<br /><br />";
					$mens .= "@lng[Nova senha gerada:] " . $strNova . "<br /><br />";
					$mens .= "@lng[Clique aqui para acessar o SIACC ou digite a seguinte URL no seu navegador:] http://siacc.regisls.net<br /><br />";
					$mens .= "@lng[Qualquer dúvida, entre em contato com a equipe do SIACC.]";
					
					$mail = new Email();
					$mail->setAssunto("[SIACC] @lng[Nova senha gerada]");
					$mail->setRemetente("Regis Leandro Sebastiani <regisls@regisls.net>");
					$mail->setDestinatario($strNome . "<" . $strEmail . ">");
					$mail->setMensagem($mens);
					$mail->Enviar();
					
					return 1;
				}
				else
				{
					//Log::RegistraLog("Alterar Senha: Erro ao alterar senha pelo site. " . $u->getErro(), true);
					echo($u->getErro());
					return -3;
				}
			}
			else
			{
				//Log::RegistraLog("Alterar Senha: Erro ao alterar senha pelo site. Não foi carregado usuário", true);
				echo("Codigo é null");
				return -2;
			}
		}
		else
		{
			return -1;
		}
	}
	else
	{
		$msg = $cmd->errorInfo();
		echo($msg[2]);
		return -4;
	}
}

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if (($_POST['txtEmail']) && ($_POST['txtNome']) && ($_POST['txtResposta']) && ($_SESSION['resp_perg']))
	{
		if ($_SESSION['resp_perg'] == $_POST['txtResposta'])
		{
			$senha = createRandomPassword();
			$intRet = AlteraSenha($senha);
			
			switch ($intRet)
			{
				case 1:
					$tpl = file_get_contents("tpl/frm-recover-ok.html");
					break;
				case -1:
					$tpl = file_get_contents("tpl/frm-recover-dadosinc.html");
					break;
				case -2:
				case -3:
				case -4:
					$tpl = file_get_contents("tpl/frm-recover-erro.html");
					break;
			}
		}
		else
		{
			$tpl = MontaJanela(true);
		}
	}
	else
	{
		$tpl = MontaJanela(false);
	}
	
	echo( Comuns::Idioma($tpl) );
}

Main();
?>