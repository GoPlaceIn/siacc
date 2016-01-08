<?php
//--utf8_encode --
session_start();
include_once 'cls/usuario.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/log.class.php';

include_once 'cls/components/botao.class.php';

include_once 'inc/comuns.inc.php';

function Main()
{
	$usu = unserialize($_SESSION['usu']);
	//$usu = new Usuario();
	
	$usufiltro = $_POST['txtUsuario'];
	$idusuario = $_POST['idusuario'];
	$dtinifiltro = $_POST['txtDtIni'];
	$dtfimfiltro = $_POST['txtDtFin'];
	$pagina = $_POST['hidPagina'];
	
	$tpl = file_get_contents("tpl/frm-acessos.html");
	
	$botoes = Botao::BotaoPesquisar("fntPesquisarAcessos();", "Pesquisar acessos");
	
	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($usu), $tpl);
	$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
	$tpl = str_replace("<!--txtDtIni-->", $dtinifiltro, $tpl);
	$tpl = str_replace("<!--txtDtFin-->", $dtfimfiltro, $tpl);
	
	if (($dtinifiltro != "") && ($dtfimfiltro != ""))
	{
		Log::RegistraLog("Acessou tela de consulta de acessos ao sistema e parametrizou: dtinifiltro=" . $dtinifiltro . "; dtfimfiltro=" . $dtfimfiltro . "; idusuario=" . $idusuario);
		
		$idusuario = ($idusuario == "" ? null : $idusuario);
		$pagina = ($pagina == "" ? 1 : $pagina);
		$tpl = str_replace("<!--hidPagina-->", $pagina, $tpl);
		
		$dtinifiltro = Comuns::DataBanco($dtinifiltro) . " 00:00:00";
		$dtfimfiltro = Comuns::DataBanco($dtfimfiltro) . " 23:59:59";
		
		$regs = 0;
		
		$acessos = $usu->ListaAcessosSistema($usuario = $idusuario, $dataini = $dtinifiltro, $datafim = $dtfimfiltro, $pagina = $pagina, 30, $regs);
		
		if (count($acessos) > 0)
		{
			$tabela = Comuns::TopoTabelaListagem("Acessos ao sistema", "acessos", array('Núm. Acesso', 'Usuário', 'Data', 'Detalhes'));
			
			foreach ($acessos as $linha)
			{
				$tabela .= '<tr>';
				$tabela .= '  <td>' . $linha->NumAcesso . '</td>';
				$tabela .= '  <td>' . $linha->Usuario . '</td>';
				$tabela .= '  <td>' . date("d/m/Y H:i:s", strtotime($linha->Data)) . '</td>';
				$tabela .= '  <td><a href="javascript:void(0);" onclick="javascript:fntDetalhesAcesso(' . $linha->NumAcesso . ');">' . Comuns::IMG_ACAO_DETALHES . '</a></td>';
				$tabela .= '</tr>';
			}
			
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			$tabela .= Comuns::GeraPaginacao($regs, $pagina, 30, 0, "fntNavegaPaginacaoAcessos", true);
			$tabela .= '<br /><br />';
		}
		else
		{
			$tabela = "@lng[Nenhum registro encontrado]";
		}
	}
	else
	{
		$tabela = "@lng[Pesquisa não realizada]";
	}

	$tpl = str_replace("<!--txtUsuario-->", $usufiltro, $tpl);
	$tpl = str_replace("<!--id-usuario-->", $idusuario, $tpl);
	$tpl = str_replace("<!--acessos-usuarios-->", $tabela, $tpl);
	$tpl = str_replace("<!--hidPagina-->", "", $tpl);
	
	echo( Comuns::Idioma($tpl) );
}

if (Comuns::EstaLogado())
{

	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}

?>