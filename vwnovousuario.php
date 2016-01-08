<?php
//--utf8_encode --
session_start();
include_once 'cls/conexao.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/grupo.class.php';
include_once 'cls/components/combobox.php';
include_once 'cls/email.class.php';
include_once 'cls/log.class.php';
include_once 'inc/comuns.inc.php';

function fntTelaNovoUsuario()
{
	$tpl = file_get_contents("tpl/frm-add-usuario.html");
	
	$sql  = "SELECT Codigo, CONCAT(NomeCompleto, CASE WHEN Sigla IS NOT NULL THEN concat(' (', Sigla, ')') ELSE '' END) AS Nome ";
	$sql .= "FROM mesinstituicao ORDER BY NomeCompleto;";
	
	$sqlIdi = "select Codigo, Nome from sisidiomas where publicado = 1";
	
	$dsIns = null;
	$dsIdi = null;
	
	if (!Comuns::ArrayObj($sql, $dsIns))
		echo($dsIns);
	
	if (!Comuns::ArrayObj($sqlIdi, $dsIdi))
		echo($dsIdi);
	
	$comboIns = new ComboBox("selInstituicao", $dsIns, "Codigo", "Nome", "0", "@lng[Selecione]");
	$comboIns->cssClass("campo req");
	$htmlCombo = $comboIns->RenderHTML();
	
	$comboIdi = new ComboBox("selIdioma", $dsIdi, "Codigo", "Nome");
	$comboIdi->cssClass("campo req");
	$htmlComboIdi = $comboIdi->RenderHTML(1);
	
	$tpl = str_replace("<!--selInstituicao-->", $htmlCombo, $tpl);
	$tpl = str_replace("<!--selIdioma-->", $htmlComboIdi, $tpl);
	
	echo( Comuns::Idioma($tpl) );
}

function fntGravaDados()
{
	$nome = $_POST['txtNome'];
	$usuario = $_POST['txtUsuario'];
	$email = $_POST['txtEmail'];
	$senha = $_POST['txtSenha'];
	$senhaII = $_POST['txtRepetirSenha'];
	$ins = $_POST['selInstituicao'];
	
	if ((trim($senha) != "") && (trim($senhaII) != ""))
	{
		if ($senha == $senhaII)
		{
			try
			{
				$u = new Usuario();
				$g = new Grupo();
				
				$u->setNome($nome);
				$u->setUsuario($usuario);
				$u->setEmail($email);
				$u->setSenha($senha);
				$u->setCodigoInstituicao($ins);
				
				$ret = $u->CadastraNovoUsuario(2);
				
				$g->setCodigo(3);
				$g->AdicionaUsuarioAoGrupo($u->getCodigo());
				$_SESSION['usu'] = serialize($u);
				$ret = "OK";
				
				try
				{
					$mensagem  = "Foi realizado um novo cadastro de usuário no SIACC.<br />";
					$mensagem .= "Nome: " . $u->getNome() . " (" . $u->getUsuario() . ")<br />";
					$mensagem .= "E-mail: " . $u->getEmail() . "<br />";
					//$mensagem .= "Instituição: " . $u->getNomeInstituicao() . " - " . $u->getSiglaInstituicao() . "<br />";
					//$mensagem .= "Cidade/UF: " . $u->getCidadeInstituicao() . "/" . $u->getUFInstituicao() . "<br /><br />";
					$mensagem .= 'Acesse o SIACC agora clicando <a href="http://siacc.regisls.net">aqui</a> para ativar a conta deste usuário e liberar seu acesso a ferramenta';
					
					$mail = new Email();
					$mail->setRemetente("Regis Leandro Sebastiani <regisls@regisls.net>");
					$mail->setAssunto("[SIACC] Novo cadastro de usuário");
					$mail->setDestinatario("regisls@regisls.net");
					$mail->setMensagem($mensagem);
					$mail->Enviar();
				}
				catch (Exception $exEmail)
				{
					Log::RegistraLog("Erro ao enviar e-mail de cadastro de usuário realizado pelo site", true);
				}
			}
			catch (Exception $ex)
			{
				$ret = "@lng[Erro ao gravar usuário.] " . $ex->getMessage();
			}
		}
		else
		{
			$ret = "@lng[As senhas informadas não são identicas. Verifique.]";
		}
	}
	else
	{
		$ret = "@lng[A senha não pode ser vazia]";
	}
	
	echo($ret);
}

function Main()
{
	switch($_POST['act'])
	{
		case "":
			fntTelaNovoUsuario();
			break;
		case "add":
			fntGravaDados();
			break;
	}
}

Main();

?>