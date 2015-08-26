<?php

class SelectNumerico
{
	public static function MontaSelect($NElementos, $NInicial = 1, $TextoInicial = "Selecione", $sel = -1)
	{
		$html = '<option value="">' . $TextoInicial . '</option>';
		
		for ($i = $NInicial; $i <= $NElementos; $i++)
		{
			$html .= '<option' . (($i == $sel) ? ' selected': '') . ' value="' . $i . '">' . $i . '</option>';
		}
		
		return $html;
	}
}

?>