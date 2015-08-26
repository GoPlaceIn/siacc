<?php
session_start();
include_once 'cls/instituicao.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/log.class.php';

function Main()
{
	$u = unserialize($_SESSION['usu']);
	
	$cod = $_POST['txtCodigo'];
	$nomecomp = $_POST['txtNomeCompleto'];
	$sigla = $_POST['txtSigla'];
	$end = $_POST['txtEndereco'];
	$compl = $_POST['txtComplemento'];
	$numero = $_POST['txtNumero'];
	$bairro = $_POST['txtBairro'];
	$cidade = $_POST['txtCidade'];
	$cep = $_POST['txtCEP'];
	$uf = $_POST['selUF'];
	$pais = $_POST['selPaises'];
	$fone = $_POST['txtFoneContato'];
	$site = $_POST['txtSite'];
	$email = $_POST['txtEmail'];
	$obrigaemail = $_POST['chkObrigaEmail'];
	if ($obrigaemail != "")
		$dominio = $_POST['txtDominioEmail'];
	$ativo = $_POST['chkAtivo'];
	
	$nomeresp = $_POST['txtNomeResponsavel'];
	$emailresp = $_POST['txtEmailResponsavel'];
	$foneresp = $_POST['txtFoneResponsavel'];
	
	$data = date("Y-m-d H:i:s");
	$usuario = $u->getCodigo();
	
	header('Content-Type: text/html; charset=iso-8859-1');
	
	try
	{
		$i = new Instituicao();
		
		if ($cod != "") { $i->setCodigo($cod); }
		if ($nomecomp != "") { $i->setNomeCompleto($nomecomp); }
		if ($sigla != "") { $i->setSigla($sigla); }
		if ($end != "") { $i->setEndereco($end); }
		if ($compl != "") { $i->setComplemento($compl); }
		if ($numero != "") { $i->setNumero($numero); }
		if ($bairro != "") { $i->setBairro($bairro); }
		if ($cidade != "") { $i->setCidade($cidade); }
		if ($cep != "") { $i->setCEP($cep); }
		if ($uf != "") { $i->setUF($uf); }
		if ($pais != "") { $i->setPais($pais); }
		if ($fone != "") { $i->setFoneContato($fone); }
		if ($site != "") { $i->setSite($site); }
		if ($email != "") { $i->setEmail($email); }
		if ($obrigaemail != "") { $i->setObrigaEmail(1); }
			if ($dominio != "") { $i->setDominioEmail($dominio); }
		if ($ativo != "") { $i->setAtivo($ativo); }
		
		if ($nomeresp != "") { $i->setNomeResponsavel($nomeresp); }
		if ($emailresp != "") { $i->setEmailResponsavel($emailresp); }
		if ($foneresp != "") { $i->setFoneResponsavel($foneresp); }
		
		$i->setCodUsuario($usuario);
		$i->setDtCadastro($data);
		
		if ($cod == "")
		{
			if ($i->Insere())
			{
				Log::RegistraLog("Instituição de ensino " . $nomecomp . " inserido pelo usuário " . $u->getNome() . ".", 0);
				echo("GRAVADO");
			}
			else 
			{
				Log::DetalhaLog("Erro ao tentar inserir a instituição de ensino " . $nomecomp . ". " . $i->getErro(), 1);
				echo($i->getErro());
			}
		}
		else
		{
			if ($i->Altera())
			{
				Log::RegistraLog("Instituição de ensino " . $nomecomp . " atualizada pelo usuário " . $u->getNome() . ".", 0);
				echo("GRAVADO");
			}
			else 
			{
				Log::DetalhaLog("Erro ao tentar atualizar a instituição de ensino " . $nomecomp . ". " . $i->getErro(), 1);
				echo($i->getErro());
			}
		}
	}
	catch (Exception $ex)
	{
		echo($ex->getMessage());
	}
}

Main();
?>