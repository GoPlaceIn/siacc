<?php

class HashTable
{
	private $conteudo;
	
	public function AddItem($key, $value)
	{
		$this->conteudo[$key] = $value;
	}
	
	public function ContainsKey($key)
	{
		return array_key_exists($key, $this->conteudo);
	}
	
	public function ContainsValue($value)
	{
		return in_array($value, $this->conteudo);
	}
	
	public function getValue($key)
	{
		return $this->conteudo[$key];
	}
	
	public function ToXML()
	{
		$xml = "";
		
		foreach ($this->conteudo as $chave => $item)
		{
			$xml .= '<' . $chave . '>' . $item . '</' . $chave . '>';
		}
		
		return $xml;
	}
	
	public function ToArray()
	{
		return $this->conteudo;
	}
}

?>