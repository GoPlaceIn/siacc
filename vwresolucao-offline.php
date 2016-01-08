<?php
//--utf8_encode --
session_start();
include_once 'cls/usuario.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/montagem.class.php';
include_once 'cls/resolucao.class.php';
include_once 'cls/caso.class.php';
include_once 'cls/components/botao.class.php';

include_once 'inc/comuns.inc.php';
include_once 'cls/log.class.php';

function Main()
{
	//header('Content-Type: text/html; charset=iso-8859-1');
	
	if (!$_GET['c'])
	{
		if ((!isset($_SESSION['casores'])) || (is_null('casores')))
		{
			$msg = base64_encode("@lng[Não foi informado nenhum caso de estudo]");
			header("Location:aluno.php?msg=" . $msg);
		}
	}
	else
	{
		if (Caso::CasoValido(base64_decode($_GET['c'])))
		{
			$_SESSION['casores'] = base64_decode($_GET['c']);
			$_SESSION['status'] = false;
			$_SESSION['codresolucao'] = null;
		}
		else
		{
			$msg = base64_encode("@lng[Caso de estudo informado não é um caso válido]");
			header("Location:aluno.php?msg=" . $msg);
		}
	}
	
	$u = unserialize($_SESSION['usu']);
	//$u = new Usuario();
	
	$tpl = file_get_contents("tpl/frm-resolucao-off.html");
	
	// Armazena a árvore de forma oculta
	$mon = new Montagem();
	$mon->setCodCaso($_SESSION['casores']);
	
	$arvore = $mon->RetornaArvoreLista();
	$tpl = str_replace("<!--arvore-->", $arvore, $tpl);

	$res = new Resolucao();
	$res->setCodcaso($_SESSION['casores']);
	$res->setCodusuario($u->getCodigo());
	
	if ($_GET['m'] == 'pre')
	{
		$tpl= str_replace("<!--region_close_preview-->", file_get_contents("tpl/close-preview.html"), $tpl);
		
		if ($_GET['t'] == 'I')
		{
			if ($u->TemGrupo(1) || ($u->TemGrupo(4)))
			{
				if (Caso::ConsultaSituacao($_SESSION['casores']) == 0)
				{
					if (!$res->LimpaResolucao())
					{
						echo( Comuns::Idioma("@lng[Erro ao limpar histórico de resoluções.]") . " " . $res->getErro());
						return;
					}
				}
				else
				{
					echo( Comuns::Idioma("@lng[Este caso está publicado e não é possível lipar suas resoluções]"));
					return;
				}
			}
			else
			{
				echo( Comuns::Idioma("@lng[Você não tem permissõo para excluir as resoluções deste caso]"));
				return;
			}
		}
	}
	
	if (!$_SESSION['status'])
	{
		$_SESSION['status'] = $res->BuscaStatusAndamento();
		
		$raiz = "";
		
		if ($_SESSION['status'] == 1)
		{
			$raiz = $res->BuscaNodoRaiz();
			$raiz = "fntInicia('raiz_raiz_0_" . $raiz . "');";
			
			$res->IniciaResolucao();
		}
		else if ($_SESSION['status'] == 2)
		{
			if ($_SESSION['codresolucao'] == null)
			{
				if ($_GET['r'])
				{
					if (Resolucao::ResolucaoValida($_SESSION['casores'], $u->getCodigo(), base64_decode($_GET['r'])))
					{
						$_SESSION['codresolucao'] = base64_decode($_GET['r']);
					}
					else
					{
						$msg = base64_encode("@lng[Dados informados inválidos]");
						header("Location:aluno.php?msg=" . $msg);
					}
				}
				else
				{
					$codresolucao = Resolucao::BuscaUltimaResolucaoCaso($_SESSION['casores'], $u->getCodigo(), $_SESSION['status']);
					if ($codresolucao !== false)
					{
						$_SESSION['codresolucao'] = $codresolucao;
					}
					else
					{
						$msg = base64_encode("@lng[Não foi possível localilzar a resolução deste caso]");
						header("Location:aluno.php?msg=" . $msg);
					}
				}
			}
			
			$res->setCodresolucao($_SESSION['codresolucao']);
			$res->RegistraAcesso($u->getIdAcessoAtual());
			
			$raiz = $res->BuscaUltimoNodoVisitado();
			if ($raiz !== false)
			{
				if ($raiz != -1)
				{
					$strPossiveis = $res->BuscaTodosMenosUltimoVisitado();
					if ($strPossiveis !== false)
					{
						$strJaVisitados = $res->BuscaTodosNodosVisitados();
						
						Log::RegistraLog("Nodos possíveis para o caminho de volta: " . $strPossiveis);
						$raiz = "fntInicia('" . $raiz . "'); fntGeraCaminhoVolta('" . $strPossiveis . "'); fntGeraVisitados('" . $strJaVisitados . "');";
					}
					else
					{
						// Se não retornou nenhum é porque o ultimo visto foi a raiz e dai não precisa gerar histórico de volta
						$raiz = "fntInicia('" . $raiz . "');";
					}
				}
				else
				{
					$raiz = $res->BuscaNodoRaiz();
					$raiz = "fntInicia('raiz_raiz_0_" . $raiz . "');";
				}
			}
			else
			{
				$msg = base64_encode("@lng[Erro durante a recuperação das informações.]" . $res->getErro());
				header("Location:aluno.php?msg=" . $msg);
			}
			
		}
		else if ($_SESSION['status'] == 3)
		{
			if ($_GET['re'] && $_GET['re'] == true)
			{
				$raiz = $res->BuscaNodoRaiz();
				$raiz = "fntInicia('raiz_raiz_0_" . $raiz . "');";
			
				$res->IniciaResolucao();
			}
			else
			{
				header("Location:vwopcoescaso.php?c=" . base64_encode($_SESSION['casores']));
			}
		}
		else
		{
			$_SESSION['status'] = false;
			die("Inconsistencia localizada. " . $res->getErro());
		}
		
		if ($u->getNome() == "Anonimo")
			$raiz .= "fntOcultaHome();";
		
		$tpl = str_replace("<!--javascriptload-->", $raiz, $tpl);
	}
	
	// Busca o nome do caso clínico
	$infos = Caso::ConsultaInfosCaso($_SESSION['casores']);
	$tpl = str_replace("<!--titulocaso-->", $infos['nome'], $tpl);
	
	echo( Comuns::Idioma($tpl) );
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$status = false;
	
	if ($_GET['c'])
	{
		$CodCaso = base64_decode($_GET['c']);
		if (Caso::CasoValido($CodCaso))
		{
			$caso = new Caso();
			$caso->setCodigo($CodCaso);
			$caso->CarregarCaso();
			if ($caso->getExigeLogin() == 0)
			{
				$usuario = new Usuario();
				if ($usuario->Carrega("Anonimo"))
				{
					$_SESSION["usu"] = serialize($usuario);
					$status = true;
				}
			}
		}
	}
	
	if (!$status)
	{
		$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
		header("Location:index.php?m=" . $msg);
	}
	else
		Main();
}

?>