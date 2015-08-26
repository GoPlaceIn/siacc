<?php

class Pessoa
{
	private $nome;
	private $endereco;
	private $telefones;
	
	public function setNome($p_nome)
	{
		$this->nome = $p_nome;
	}
	
	public function setEndereco($p_endereco)
	{
		$this->endereco = $p_endereco;
	}
	
	public function setTelefone($p_telefone)
	{
		$this->telefones[] = $p_telefone;
	}
	
	public function __construct()
	{
		$this->nome = null;
		$this->endereco = null;
		$this->telefones[] = new Telefone();
	}
}

class Telefone
{
	private $ddd;
	private $numero;
	
	public function setDDD($p_ddd)
	{
		$this->ddd = $p_ddd;
	}
	
	public function setNumero($p_numero)
	{
		$this->numero = $p_numero;
	}
	
	public function __construct()
	{
		$this->ddd = null;
		$this->numero = null;
	}
}

function Main()
{
	$p = new Pessoa();
	$p->setNome("Regis Leandro Sebastiani");
	$p->setEndereco("Rua Esteio, 1169");
	
	$t1 = new Telefone();
	$t1->setDDD(51);
	$t1->setNumero(92666970);

	$t2 = new Telefone();
	$t2->setDDD(51);
	$t2->setNumero(35641890);
	
	$p->setTelefone($t1);
	$p->setTelefone($t2);
	
	$a = array("nome" => "Regis Leandro Sebastiani", "Endereco" => "Rua esteio, 1169", "Telefones" => array("num" => array(array("51", "92666970"), array("51", "3333333"))));
	$b = array(array("33", "989898"), array("56", "84848484")); 
	
	$jason = json_encode($p);
	echo($jason);
	echo("<br />");
	echo(json_encode($a));
	echo("<br />");
	echo(json_encode($b));
}

Main();

?>