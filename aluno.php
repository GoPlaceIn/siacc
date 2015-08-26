<?php
session_start();
include_once 'inc/comuns.inc.php';

include_once 'cls/conexao.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/instituicao.class.php';
include_once 'cls/caso.class.php';

function Principal($tpl, $usu)
{
	$tpl_lista = file_get_contents("tpl/aluno/lst-casos.html");
	$usu->RegistraAcao("Acesso página inicial de casos clínicos");
	
	$casos = new Caso();
	$lista = $casos->ListaRecordSet($usu->getCodigo());
	
	$item = file_get_contents("tpl/aluno/caso-item-descricao.html");
	
	$casosnaoini = "";
	$casosini = "";
	$casosconc = "";
	
	foreach ($lista as $c)
	{
		$copia = $item;
		
		$copia = str_replace("<!--codcaso-->", base64_encode($c->Codigo), $copia);
		$copia = str_replace("<!--codres-->", (is_null($c->CodResolucao) ? "" : base64_encode($c->CodResolucao)), $copia);
		$copia = str_replace("<!--titulo-->", $c->Nome, $copia);
		$copia = str_replace("<!--dificuldade-->", $c->NivelDif, $copia);
		$copia = str_replace("<!--descricao-->", $c->Descricao, $copia);
		
		if ($c->CodSituacao == 1)
			$casosnaoini .= $copia;
		else if ($c->CodSituacao == 2)
			$casosini .= $copia;
		else if ($c->CodSituacao == 3)
			$casosconc .= $copia;
	}

	if ($casosnaoini == '')
		$casosnaoini = '@lng[Nenhum caso a listar]';

	if ($casosini == '')
		$casosini = '@lng[Nenhum caso a listar]';
		
	if ($casosconc == '')
		$casosconc = '@lng[Nenhum caso a listar]';
		
	$tpl_lista = str_replace("<!--listacasos1-->", $casosnaoini, $tpl_lista);
	$tpl_lista = str_replace("<!--listacasos2-->", $casosini, $tpl_lista);
	$tpl_lista = str_replace("<!--listacasos3-->", $casosconc, $tpl_lista);
	$tpl = str_replace("<!--conteudo-->", $tpl_lista, $tpl);
	
	header('Content-Type: text/html; charset=iso-8859-1');
	echo( Comuns::Idioma($tpl) );
}

function AlteraSenha($tpl)
{
	$tpl_senha = file_get_contents('tpl/aluno/frm-altera-senha.html');
	$tpl = str_replace("<!--conteudo-->", $tpl_senha, $tpl);
	
	header('Content-Type: text/html; charset=iso-8859-1');
	echo( Comuns::Idioma($tpl) );
}

function Main()
{
	$usu = unserialize($_SESSION['usu']);
	$ins = new Instituicao();
	
	$tpl = file_get_contents("tpl/aluno/index.html");
	
	if ($_POST['txtSenha1'] && $_POST['txtSenha2'])
	{
		if ($_POST['txtSenha1'] == $_POST['txtSenha2'])
		{
			if (strlen($_POST['txtSenha1']) >= 6)
			{
				$usu->AlteraSenha(md5($_POST['txtSenha1']), "-999");
				header("Location:aluno.php?msg=" . base64_encode("@lng[Sua senha foi alterada com sucesso]"));
			}
			else
			{
				header("Location:aluno.php?a=as&msg=" . base64_encode("@lng[A senha deve ter no mínimo 6 caracteres]"));
			}
		}
		else
		{
			 header("Location:aluno.php?a=as&msg=" . base64_encode("@lng[As senhas não são iguais]"));
		}
	}
	
	$ins->setCodigo($usu->getCodigoInstituicao());
	$ins->Carrega();
	
	if ($_GET['msg'])
	{
		$tplmsg = file_get_contents("tpl/aluno/mensagem.html");
		$tplmsg = str_replace('<!--mensagem-->', base64_decode($_GET['msg']), $tplmsg);
		$tpl = str_replace('<!--localmensagem-->', $tplmsg, $tpl);
	}
	
	$sNome = split(' ', $usu->getNome());
	$tpl = str_replace("<!--NomeAluno-->", $sNome[0], $tpl);
	$tpl = str_replace("<!--NomeInstituicao-->", '<a target="_blank" href="http://' . $ins->getSite() . '">' . $ins->getNomeCompleto() . '</a>', $tpl);
	
	if ($_GET['a'])
	{
		switch ($_GET['a'])
		{
			case 'as':
				AlteraSenha($tpl);
		}
	}
	else
	{
		Principal($tpl, $usu);
	}
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("Você deve estar logado para acessar esta tela");
	header("Location:index.php?m=" . $msg);
}
?>