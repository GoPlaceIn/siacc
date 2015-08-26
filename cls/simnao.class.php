<?php

class SimNao
{
	private $sim = 1;
	private $nao = 0;

	public static function Sim()
	{
		return $this->sim;
	}

	public static function Nao()
	{
		return $this->nao;
	}

	public static function SelectSimNao($sel = 1)
	{
		if ($sel == 1)
		{
			$ret  = '<option selected value="1">@lng[SIM]</option>';
			$ret .= '<option value="0">@lng[NÃO]</option>';
		}
		else
		{
			$ret  = '<option value="1">@lng[SIM]</option>';
			$ret .= '<option selected value="0">@lng[NÃO]</option>';
		}

		return $ret;
	}

	public static function Descreve($val)
	{
		switch ($val)
		{
			case 1:
				return "@lng[SIM]";
			case 0:
				return "@lng[NÃO]";
		}
	}
}

?>