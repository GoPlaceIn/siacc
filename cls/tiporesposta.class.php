<?php
//--utf8_encode --
class TipoResposta
{
	public static function SelectTipoResposta($sel = "SEL")
	{
		/*
		 * CE = Certo e Errado
		 * ORD = Ordenação
		 * */
		
		$ret  = '<option ' . (($sel == "SEL") ? "selected" : "") . ' value="">@lng[Selecione]</option>';
		$ret .= '<option ' . (($sel == "CE") ? "selected" : "") . ' value="CE">@lng[Certo e Errado]</option>';
		$ret .= '<option ' . (($sel == "ORD") ? "selected" : "") . ' value="ORD">@lng[Ordenação/Classificação]</option>';
		
		return $ret;
	}
	
}

?>