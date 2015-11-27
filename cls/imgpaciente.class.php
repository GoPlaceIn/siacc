<?php
include_once 'cls/Image.class.php';

class ImgPaciente
{
	public static function SelectImagem($sel = 0)
	{
		$s = ' selected ';
		$ns = ' ';
		
		$ret  = '<option' . ($sel == 0 ? $s : $ns) . 'value="0">Selecione</option>';
		$ret .= '<option' . ($sel == 1 ? $s : $ns) . 'value="1">Homem adulto branco</option>';
		$ret .= '<option' . ($sel == 5 ? $s : $ns) . 'value="5">Homem adulto negro</option>';
		$ret .= '<option' . ($sel == 3 ? $s : $ns) . 'value="3">Mulher adulta branca</option>';
		$ret .= '<option' . ($sel == 4 ? $s : $ns) . 'value="4">Mulher adulta negra</option>';
		$ret .= '<option' . ($sel == 2 ? $s : $ns) . 'value="2">Mulher adulta parda</option>';
		
		return $ret;
	}


	public static function SetImagem($foto, $nomeFoto)
	{
		
						 
               
	}

}

?>