<?php
session_start();
include_once 'cls/components/botao.class.php';

class Caminhos
{
	public static function MontaCaminhoDadosBasicos()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Dados b�sicos]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoColaborador()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Colaboradores]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoConfiguracoes()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Configura��es]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoObjetivos()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Objetivos]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoAnamnese()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Anamnese]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoExameFisico()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Exame f�sico]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoHipoteses()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Hip�teses diagn�sticas]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoExames()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Exames]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoExamesDetalhes()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntLoadTela(\'exames\');">@lng[Exames]</a> > ';
		$caminho .= '@lng[Detalhes]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoExamesDetalhesImagem()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntLoadTela(\'exames\');">@lng[Exames]</a> > ';
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntLoadItemDetalhes(\'exames\', \'' . base64_encode($_SESSION['exame']) . '\')">@lng[Detalhes]</a> > ';
		$caminho .= '@lng[Visualizar Item]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoExamesDetalhesAtualizacao()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntLoadTela(\'exames\');">@lng[Exames]</a> > ';
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntLoadItemDetalhes(\'exames\', \'' . base64_encode($_SESSION['exame']) . '\')">@lng[Detalhes]</a> > ';
		$caminho .= '@lng[Atualizar Item]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoExamesConteudos()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntLoadTela(\'exames\');">@lng[Exames]</a> > ';
		$caminho .= '@lng[Conte�dos vinculados]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoDiagnosticos()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Diagn�sticos]';
			
		return $caminho;
	}
	
	public static function MontaCaminhoTratamentos()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Tratamentos]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoDesfechos()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Desfechos]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoConteudos()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Conte�dos extras]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoExercicios()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Exerc�cios]';
		
		return $caminho;
	}
	
	public static function MontaCaminhoMontagem()
	{
		$caminho .= '<a href="javascript:void(0);" onclick="javascript:fntTelaInicial();">@lng[Caso]</a> > ';
		$caminho .= '@lng[Montagem]';
		
		return $caminho;
	}
}

?>