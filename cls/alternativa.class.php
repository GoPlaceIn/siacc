<?php

include_once 'conexao.class.php';

class Alternativa
{
	private $sequencia;
	private $codunico;
	private $texto;
	private $imagem;
	private $correto;
	private $explicacao;
	private $exibirexplicacao;
	private $tipoconsequencia;
	private $valorconsequencia;
	private $codbinario;
	private $origem;

	public function getSequencia()
	{
		return $this->sequencia;
	}

	public function getCodUnico()
	{
		return $this->codunico;
	}
	
	public function getTexto()
	{
		return $this->texto;
	}

	public function getImagem()
	{
		return $this->imagem;
	}

	public function getCorreto()
	{
		return $this->correto;
	}

	public function getExplicacao()
	{
		return $this->explicacao;
	}

	public function getExibirExplicacao()
	{
		return $this->exibirexplicacao;
	}

	public function getTipoConsequencia()
	{
		return $this->tipoconsequencia;
	}

	public function getValorConsequencia()
	{
		return $this->valorconsequencia;
	}

	public function getCodBinario()
	{
		return $this->codbinario;
	}
	
	public function getOrigem()
	{
		return $this->origem;	
	}
	

	public function setSequencia($seq)
	{
		$this->sequencia = $seq;
	}

	public function setCodUnico($codunic)
	{
		$this->codunico = $codunic;
	}
	
	public function setTexto($txt)
	{
		$this->texto = $txt;
	}

	public function setImagem($img)
	{
		$this->imagem = $img;
	}

	public function setCorreto($certo)
	{
		$this->correto = $certo;
	}

	public function setExplicacao($exp)
	{
		$this->explicacao = $exp;
	}

	public function setExibirExplicacao($exibir)
	{
		$this->exibirexplicacao = $exibir;
	}

	public function setTipoConsequencia($tipoconseq)
	{
		$this->tipoconsequencia = $tipoconseq;
	}

	public function setValorConsequencia($valconseq)
	{
		$this->valorconsequencia = $valconseq;
	}

	public function setCodBinario($p_codbinario)
	{
		$this->codbinario = $p_codbinario;
	}
	
	public function setOrigem($p_origem)
	{
		$this->origem = $p_origem;
	}
	
	public function __construct()
	{
		$this->sequencia = 0;
		$this->codunico = 0;
		$this->texto = "";
		$this->imagem = null;
		$this->correto = null;
		$this->explicacao = "";
		$this->tipoconsequencia = 1;
		$this->valorconsequencia = 0;
		$this->codbinario = 0;
		$this->origem = "";
	}

	public function Carrega($codunico)
	{
		$sql  = "select CodPergunta, Sequencia, Texto, Imagem, Correto, Explicacao, ExibirExplicacao, TipoConsequencia, ValorConsequencia, CodUnico, Origem ";
		$sql .= "from mesalternativa ";
		$sql .= "where CodUnico = :coduni;";

		$cnn = Conexao2::getInstance();
		$q = $cnn->prepare($sql);
		$q->bindParam(":coduni", $codunico, PDO::PARAM_INT);
		$q->execute();

		if ($q->rowCount() > 0)
		{
			$alt = $q->fetch(PDO::FETCH_OBJ);
			$this->sequencia = $alt->Sequencia;
			$this->codunico = $alt->CodUnico;
			$this->texto = $alt->Texto;
			$this->imagem = $alt->Imagem;
			$this->correto = $alt->Correto;
			$this->exibirexplicacao = $alt->ExibirExplicacao;
			$this->explicacao = $alt->Explicacao;
			$this->tipoconsequencia = $alt->TipoConsequencia;
			$this->valorconsequencia = $alt->ValorConsequencia;
			$this->origem = $alt->Origem;
		}
	}
}

?>