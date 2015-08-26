<?php

class TipoResposta
{
	public static function SelectTipoResposta($sel = "SEL")
	{
		/*
		 * CE = Certo e Errado
		 * ORD = Ordena��o
		 * */
		
		$ret  = '<option ' . (($sel == "SEL") ? "selected" : "") . ' value="">@lng[Selecione]</option>';
		$ret .= '<option ' . (($sel == "CE") ? "selected" : "") . ' value="CE">@lng[Certo e Errado]</option>';
		$ret .= '<option ' . (($sel == "ORD") ? "selected" : "") . ' value="ORD">@lng[Ordena��o/Classifica��o]</option>';
		
		return $ret;
	}
	
}

?>