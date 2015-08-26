<?php

class Sexo
{
	private $masculino = "M";
	private $feminino = "F";

	public static function Masculino()
	{
		return $this->masculino;
	}

	public static function Feminino()
	{
		return $this->feminino;
	}

	public static function SelectSexo($sel = "M")
	{
		if ($sel == "M")
		{
			$ret  = '<option selected value="M">@lng[Masculino]</option>';
			$ret .= '<option value="F">@lng[Feminino]</option>';
		}
		else
		{
			$ret  = '<option value="M">@lng[Masculino]</option>';
			$ret .= '<option selected value="F">@lng[Feminino]</option>';
		}

		return $ret;
	}

	public static function Descreve($val)
	{
		switch ($val)
		{
			case "M":
				return "@lng[Masculino]";
			case "F":
				return "@lng[Feminino]";
		}
	}
}

?>