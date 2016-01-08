<?php
//--utf8_encode --
session_start();
include_once 'cls/components/botao.class.php';

class Menus
{
	public static function MenusBasicos()
	{
		$menus .= Botao::BotaoSalvar("fntGravaEtapaCaso();", "@lng[Salvar dados basicos]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusColaborador()
	{
		$menus .= Botao::BotaoSalvar("fntGravaUsuariosCasoColaboradores();", "@lng[Salvar colaboradores]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusConfiguracoes()
	{
		$menus .= Botao::BotaoSalvar("fntGravaConfiguracoes();", "@lng[Salvar configurações]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusObjetivos()
	{
		$menus .= Botao::BotaoAdd("fntExibeCadastroEtapa();", "@lng[Adicionar novo objetivo]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusAnamnese()
	{
		$menus .= Botao::BotaoSalvar("fntGravaEtapaCaso();", "@lng[Salvar anamnese]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusExameFisico()
	{
		$menus .= Botao::BotaoSalvar("fntGravaEtapaCaso();", "@lng[Salvar exame físico]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusHipoteses()
	{
		//$menus .= Botao::BotaoSalvar("fntSalvaTextoGuia('sth');", "Salvar o texto/pergunta norteadora");
		$menus .= Botao::BotaoAdd("fntExibeCadastroEtapa();", "@lng[Adicionar nova hipótese]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusExames()
	{
		//$menus .= Botao::BotaoSalvar("fntSalvaTextoGuia('ste');", "Salvar o texto/pergunta norteadora");
		$menus .= Botao::BotaoAdd("fntExibeCadastroEtapa();", "@lng[Adicionar novo exame]");
		//$menus .= Botao::BotaoVinculos("fntContExames();", "Conteudos vinculados aos exames");
		//$menus .= Botao::BotaoVinculos("fntLoadTela('examesconteudos', 'sec');", "Conteudos vinculados aos exames");
		/*
		if (Exame::ExamesJaProcessado($_SESSION['caso']) == 0)
			$menus .= Botao::BotaoProcessar("fntProcessaExames();", "Processar os exames salvos");
		else
			$menus .= Botao::BotaoReprocessar("fntReprocessaExames();", "Reprocessar os exames salvos");
		*/
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusConteudosExames()
	{
		$menus .= Botao::BotaoSalvar("fntSalvaConteudosExames();", "@lng[Salvar os conteúdos adicionados ao exame]");
		//$menus .= Botao::BotaoVoltar("fntLoadTela('7ki04F2_xVm0t6lpY4');", "Voltar para a lista de exames");
		//$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusExamesDetalhes()
	{
		$e = new Exame();
		$e->Carrega($_SESSION['caso'], $_SESSION['exame']);
		$te = new TipoExame();
		$te->Carrega($e->getTipo());
		
		//$menus .= Botao::BotaoSalvar("fntGravaEtapaCaso();");
		if ($te->getPodeImgs() == 1)
			$menus .= Botao::BotaoUploadImagem("fntMostraOpcoesUpload();", "@lng[Adicionar arquivo de exame por imagem]");
		if ($te->getPodeDocs() == 1)
			$menus .= Botao::BotaoUploadDocumento("fntMostraOpcoesUploadDoc();","@lng[Adicionar arquivo de exame]");
		
		$menus .= Botao::BotaoSalvar("fntSalvaResultadosExame();", "@lng[Salvar resultados/laudo do exame]");
		$menus .= Botao::BotaoExames("fntVoltar();", "@lng[Voltar para a lista de exames]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusExamesConteudos()
	{
		$menus .= Botao::BotaoSalvar("document.getElementById('adicionaanexos').contentWindow.fntSalvaConteudosExames();", "@lng[Salvar resultados/laudo do exame]");
		$menus .= Botao::BotaoExames("fntVoltar();", "@lng[Voltar para a lista de exames]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusExamesDetalhesImagem()
	{
		$menus .= Botao::BotaoVoltar("fntLoadItemDetalhes('exames', '" . base64_encode($_SESSION['exame']) . "');", "@lng[Voltar para os itens do exame]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusExamesDetalhesAtualizacao()
	{
		$menus .= Botao::BotaoSalvar("fntAtualizaItemExame();", "Salvar as alterações no item");
		$menus .= Botao::BotaoVoltar("fntLoadItemDetalhes('exames', '" . base64_encode($_SESSION['exame']) . "');", "@lng[Voltar para os itens do exame]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusDiagnosticos()
	{
		//$menus .= Botao::BotaoSalvar("fntSalvaTextoGuia('stdi');", "Salvar o texto/pergunta norteadora");
		$menus .= Botao::BotaoAdd("fntExibeCadastroEtapa();", "@lng[Adicionar novo diagnóstico]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusTratamentos()
	{
		//$menus .= Botao::BotaoSalvar("fntSalvaTextoGuia('stt');", "Salvar o texto/pergunta norteadora");
		$menus .= Botao::BotaoAdd("fntExibeCadastroEtapa();", "@lng[Adicionar novo tratamento]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
			
		return $menus;
	}
	
	public static function MenusDesfechos()
	{
		//$menus .= Botao::BotaoSalvar("fntSalvaTextoGuia('std');", "Salvar o texto de reflexão");
		$menus .= Botao::BotaoAdd("fntExibeCadastroEtapa();", "@lng[Adicionar novo desfecho]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
			
		return $menus;
	}
	
	public static function MenusConteudos()
	{
		$menus .= Botao::BotaoAdd("fntExibeCadastroEtapa();", "@lng[Adicionar novo conteúdo]", "@lng[Novo hipertexto]");
		$menus .= Botao::BotaoUploadImagem("fntTelaUploadImg('cont', 0);", "@lng[Adicionar imagem]");
		$menus .= Botao::BotaoUploadSom("fntTelaUploadAudio('cont');", "@lng[Adicionar áudio]");
		$menus .= Botao::BotaoUploadVideo("fntTelaUploadVideo('cont');", "@lng[Adicionar vídeo]");
		$menus .= Botao::BotaoUploadDocumento("fntTelaUploadDocumento('cont');", "@lng[Adicionar documento]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
	
	public static function MenusExercicios()
	{
		$menus .= Botao::BotaoSalvar("fntGravaEtapaCaso();", "@lng[Salva os exercícios escolhidos]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
			
		return $menus;
	}

	public static function MenusMontagem()
	{
		$menus .= Botao::BotaoSalvar("fntGravaOrdenacao();", "@lng[Salva a ordenação criada]");
		$menus .= Botao::BotaoCancelar("fntTelaInicial();");
		
		return $menus;
	}
}

?>