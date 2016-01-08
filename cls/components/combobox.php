<?php
//--utf8_encode --
class ComboBox
{
	private $dataset;
	private $selectedvalue;
	private $datavaluefield;
	private $datatextfield;
	private $defaultvalue;
	private $defaulttext;
	private $id;
	private $cssclass;
	private $eventos;
	private $html;
	
	/**
	 * @param $id string : Obrigatório. Propriedade ID do Select.
	 * @param $ds array : Obrigatório. Dados para montar as opções. Se não informado deve ser setado pelas propriedades.
	 * @param $dvf string : Obrigatório. Indica qual o campo do DataSet que deve ser usado como value do Select.
	 * @param $dtf string : Obrigatório. Indica qual o campo do DataSet que deve ser usado como text do Select.
	 * @param $dv string : Opcional. Valor default.
	 * @param $dt string : Opcional. Texto default.
	 * */
	public function __construct($id = null, $ds = null, $dvf = null, $dtf = null, $dv = null, $dt = null)
	{
		$this->dataset = $ds;
		$this->selectedvalue = null;
		$this->datavaluefield = $dvf;
		$this->datatextfield = $dtf;
		$this->defaultvalue = $dv;
		$this->defaulttext = $dt;
		$this->id = $id;
		$this->cssclass = null;
		$this->eventos = null;
		$this->html = "";
	}
	
	public function setDataSet($ds)
	{
		$this->dataset = $ds;
	}
	
	public function setDataValueField($dv)
	{
		$this->datavaluefield = $dv;
	}
	
	public function setDataTextField($dt)
	{
		$this->datatextfield = $dt;
	}
	
	public function setDefaultValue($defv)
	{
		$this->defaultvalue = $defv;
	}
	
	public function setDefaultText($deft)
	{
		$this->defaulttext = $deft;
	}
	
	public function ID($n)
	{
		$this->id = $n;
	}
	
	public function cssClass($c)
	{
		$this->cssclass = $c;
	}
	
	public function Eventos(array $eventos = null)
	{
		$this->eventos = $eventos;
	}
	
	public function getSelectedValue()
	{
		return $this->selectedvalue;
	}
	
	public function setSelectedValue($sv)
	{
		$this->selectedvalue = $sv;
	}
	
	/**
	 * @param $s string : Opcional. Valor selecionado
	 * */
	public function RenderHTML($s = null)
	{
		if (!$this->dataset)
			return;
		
		if (!$this->id)
			return;
		
		if ($s != null)
			$this->selectedvalue = $s;
			
		$this->html = '<select name="' . $this->id . '" id="' . $this->id . '" ' . (($this->cssclass != null) ? 'class="' . $this->cssclass . '"' : '');
		
		if ($this->eventos)
		{
			foreach ($this->eventos as $evento => $acao)
			{
				$this->html .= ' ' . $evento . '="javascript:' . $acao . ';"';
			}
		}
		
		$this->html .= ' >';
		
		if (($this->defaultvalue !== null) && ($this->defaulttext !== null))
		{
			$this->html .= '<option value="' . $this->defaultvalue . '">' . $this->defaulttext . '</option>';
		}
		
		$value = $this->datavaluefield;
		$text = $this->datatextfield;
		
		foreach ($this->dataset as $item)
		{
			$this->html .= '<option value="' . $item->$value . '"' . (($this->selectedvalue == $item->$value) ? " selected" : "") . '>' . $item->$text . '</option>';
		}
		
		$this->html .= '</select>';
		
		return $this->html;
	}
}

?>