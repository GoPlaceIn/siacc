<?php

class EtapaPergunta
{
	private $tipo;
	private $texto;
	private $alternativas;

	public function getTipo()
	{
		return $this->tipo;
	}

	public function setTipo($tip)
	{
		$this->tipo = $tip;
	}

	public function getTexto()
	{
		return $this->texto;
	}

	public function setTexto($txt)
	{
		$this->texto = $txt;
	}

	public function getAlternativas()
	{
		return $this->alternativas;
	}

	public function setAlternativa($alt)
	{
		$this->alternativas;
	}

	public function AdicionaEtapa($perg)
	{
		try
		{
			if (isset($this->tipo))
			{
				if (isset($this->texto))
				{
					$proxima = BuscaUltimaEtapa($perg) + 1;
					$linha = 0;
					$start = 0;
						
					$sql  = "INSERT INTO mesperguntaetapa(CodPergunta, CodEtapa, CodTipo) ";
					$sql .= "VALUES(" . $perg . ", " . $proxima . ", " . $this->tipo . ");";
						
					$cnn = new Conexao();
					if ($cnn->Instrucao($sql, false))
					{
						while ($aux = substr($this->texto, $start, 3000))
						{
							$linha ++;

							$sql  = "INSERT INTO mesperguntatexto(CodPergunta, CodEtapa, Linha, Texto) ";
							$sql .= "VALUES(" . $perg . ", " . $proxima . ", " . $linha . ", '" . $aux . "');";

							$cnn->Instrucao($sql, false);
							$start += 3000;
						}
					}
					else
					{
						throw new Exception("@lng[Erro ao inserir nova etapa da pergunta]", 1002);
					}
				}
				else
				{
					throw new Exception("@lng[Texto não informado]", 1001);
				}
			}
			else
			{
				throw new Exception("@lng[Tipo não informado]", 1000);
			}
		}
		catch (Exception $ex)
		{
			throw new Exception($ex->getMessage(), $ex->getCode());
		}
	}

	private function BuscaUltimaEtapa($pergunta)
	{
		$sql  = "SELECT MAX(CodEtapa) as Etapa FROM mesperguntaetapa WHERE CodPergunta = " . $pergunta . ";";

		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);
		if (($rs != 0) && (mysql_num_rows($rs) > 0))
		{
			return mysql_result($rs, 0, "Etapa");
		}
		else
		{
			return 0;
		}
	}
}

?>