<?php

class Botao
{
	public static function BotaoNovo($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Novo registro]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/novo-reg.png" alt="Novo registro" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Novo]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoSalvar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Salvar registro]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/salvar-reg.png" alt="Salvar registro" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Salvar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoVoltar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Voltar]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/voltar.png" alt="Voltar" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Voltar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoCancelar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Voltar a tela de composição do caso]";
		
		/*
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/cancelar.png" alt="Cancelar" /><br />';
		$html .= '    <a href="javascript:void(0);">Cancelar</a>';
		$html .= '</li>';
		*/
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/voltar-caso.png" alt="Voltar" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Voltar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoCancelarReal($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Cancelar ação]";
		
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/cancelar.png" alt="Cancelar" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Cancelar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoExames($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Voltar para os exames]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/exames_p.png" alt="Voltar para os exames" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Exames]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoAdd($link, $title = null, $texto = null)
	{
		if (is_null($title))
			$title = "@lng[Adicionar novo item]";
		
		if (is_null($texto))
			$texto = "@lng[Adicionar]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/adicionar.png" alt="Adicionar novo item" /><br />';
		$html .= '    <a href="javascript:void(0);">' . $texto . '</a>';
		$html .= '</li>';
		
		return $html;
	}

	public static function BotaoExcluir($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Excluir item]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/excluir.png" alt="Excluir item" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Excluir]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoUploadImagem($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Carregar nova imagem]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/upload.png" alt="Adicionar nova imagem" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Nova Imagem]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoUploadSom($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Carregar novo áudio]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/upload-som.png" alt="Adicionar novo áudio" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Novo Áudio]</a>';
		$html .= '</li>';
		
		return $html;
	}

	public static function BotaoUploadVideo($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Carregar novo vídeo]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/upload-video.png" alt="Adicionar novo vídeo" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Novo Vídeo]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoUploadDocumento($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Carregar novo documento]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/documento.png" alt="Adicionar novo documento" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Novo Documento]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoPesquisar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Pesquisar]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/adicionar.png" alt="Pesquisar" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Pesquisar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoPublicar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Publicar]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/publicar.png" alt="Publicar" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Publicar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoDespublicar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Cancelar publicação]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/despublicar.png" alt="Despublicar" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Cancelar publicação]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoVisualizar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Visualizar]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/preview.png" alt="Preview" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Visualizar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoProcessar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Processar]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/processar.png" alt="" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Processar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoReprocessar($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Reprocessar]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/reprocessar.png" alt="" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Reprocessar]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoVinculos($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Vínculos]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/vinculados.png" alt="" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Anexos]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoConfigs($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Configurações]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/configs.png" alt="" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Configurações]</a>';
		$html .= '</li>';
		
		return $html;
	}
	
	public static function BotaoVersao($link, $title = null)
	{
		if (is_null($title))
			$title = "@lng[Criar nova versão]";
		
		$html  = '<li onclick="javascript:' . $link . '" title="' . $title . '">';
		$html .= '  <div class="toolbar-item">';
		$html .= '    <img src="img/versao.png" alt="" /><br />';
		$html .= '    <a href="javascript:void(0);">@lng[Criar versão]</a>';
		$html .= '</li>';
		
		return $html;
	}
}

?>