<?php
//--utf8_encode --
session_start();
include_once 'cls/usuario.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/montagem.class.php';
include_once 'cls/components/botao.class.php';

include_once 'inc/comuns.inc.php';

function Main()
{
	$u = unserialize($_SESSION['usu']);

	$tpl = file_get_contents("tpl/frm-montagem.html");
	$botoes = "";
	
	//$botoes = Botao::BotaoSalvar("fntSalvaMontagem();", "Salvar a montagem atual");
	$botoes .= Botao::BotaoAdd("fntAddFolha();", "@lng[Adicionar o item selecionado a montagem]");
	$botoes .= Botao::BotaoExcluir("fntRemoverItemMontagem()", "@lng[Remover o item selecionado da montagem]");
	$botoes .= Botao::BotaoConfigs("fntMostraConfigs();", "@lng[Permite modificar as configurações do item selecionado]");
	//$botoes .= Botao::BotaoSalvar("fntSalvaConfigs();", "Salvar as configurações do item selecionado");
	$botoes .= Botao::BotaoCancelar("fntVoltaTelaOpcoes();", "@lng[Voltar para a tela inicial do caso]");
	
	
	$mon = new Montagem();
	$mon->setCodCaso($_SESSION['caso']);
	
	$rais = $mon->ExisteArvore();
	
	if (is_null($rais))
	{
		$rais = $mon->AddRais();
	}
	
	$arvore = $mon->RetornaArvoreLista();
	$anexos = $mon->RetornaComboConteudosExtras();
	
	if ($arvore != false)
	{
		//echo($arvore);
		//return;
		
		$tpl = str_replace("<!--arvore-->", $arvore, $tpl);
	}
	else
	{
		$tpl = str_replace("<!--arvore-->", $mon->getErro(), $tpl);
	}

	$tpl = str_replace("<!--selConteudos-->", $anexos, $tpl);
	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
	$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
	
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