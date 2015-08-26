<?php

class MostraQuando
{
	public static function SelectMostraQuando($sel = 0)
	{
		/*
		 * 0 = Como exerc�cio e nos Resultados
		 * 1 = Somente nos Resultados
		 * */
		
		$ret  = '<option ' . (($sel == 0) ? "selected" : "") . ' value="0">Como op��o e nos resultados</option>';
		$ret .= '<option ' . (($sel == 1) ? "selected" : "") . ' value="1">Somente nos resultados</option>';
		
		return $ret;
	}
	
	public static function Descreve($valor)
	{
		switch ($valor)
		{
			case 0:
				return "Como op��o e nos resultados";
				break;
			case 1:
				return "Somente nos resultados";
				break;
		}
	}
}

?>