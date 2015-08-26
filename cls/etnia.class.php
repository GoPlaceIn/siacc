<?php

class Etnia
{
	public static function SelectEtnia($sel = 0)
	{
		$s = ' selected ';
		$ns = ' ';
		
		$ret  = '<option' . ($sel == 0 ? $s : $ns) . 'value="0">Selecione</option>';
		$ret .= '<option' . ($sel == 1 ? $s : $ns) . 'value="1">Branco</option>';
		$ret .= '<option' . ($sel == 2 ? $s : $ns) . 'value="2">Negro</option>';
		$ret .= '<option' . ($sel == 3 ? $s : $ns) . 'value="3">Pardo</option>';
		
		return $ret;
	}
}

?>