<?php

include_once "conexao.class.php";
include_once 'cls/usuario.class.php';
include_once 'cls/tipopergunta.class.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/classes.class.php';
include_once 'cls/alternativa.class.php';
include_once 'cls/upload.class.php';
include_once 'inc/comuns.inc.php';

class Pergunta
{

	private $codigo;
	private $texto;
	private $classe;
	private $usuario;
	private $ativo;
	private $nivel;
	private $tipo;
	private $expgeral;
	private $alternativas;
	private $form;
	private $maiorseq;
	public $tipos;
	public $niveis;
	public $classes;
	
	public $msg_erro;

	function __construct()
	{
		$u = unserialize($_SESSION["usu"]);

		$this->codigo = 0;
		$this->texto = "";
		$this->classe = null;
		$this->usuario = $u->getCodigo();
		$this->ativo = 1;
		$this->nivel = null;
		$this->tipo = null;
		$this->expgeral = null;
		$this->alternativas = null;
		$this->form = 8;
		$this->tipos = new TipoPergunta();
		$this->niveis = new NivelPergunta();
		$this->classes = new Classes();
	}

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($cd)
	{
		if (isset($cd))
		{
			$this->codigo = $cd;
		}
	}

	public function getClasse()
	{
		return $this->classe;
	}

	public function getTexto()
	{
		return $this->texto;
	}

	public function setTexto($txt)
	{
		if (!isset($txt))
		{
			throw new Exception("@lng[Você deve informar o texto da pergunta]", 0001);
		}
		$this->texto = $txt;
	}

	public function setClasse($cl)
	{
		if (!isset($cl))
		{
			throw new Exception("@lng[Selecione a classe da pergunta]", 0002);
		}
		$this->classe = $cl;
	}

	public function getAtivo()
	{
		return $this->ativo;
	}

	public function setAtivo($at)
	{
		if (!isset($at))
		{
			throw new Exception("@lng[Selecione se a pergunta estará ativa ou não]", 0003);
		}
		$this->ativo = $at;
	}

	public function getNivel()
	{
		return $this->nivel;
	}

	public function setNivel($niv)
	{
		if (!isset($niv))
		{
			throw new Exception("@lng[Selecione o nível de dificuldade da pergunta]", 0004);
		}
		$this->nivel = $niv;
	}

	public function getTipo()
	{
		return $this->tipo;
	}

	public function setTipo($tip)
	{
		if (!isset($tip))
		{
			throw new Exception("@lng[Selecione o tipo da pergunta]", 0005);
		}
		$this->tipo = $tip;
	}

	public function getTextoExplicacaoGeral()
	{
		return $this->expgeral;
	}
	
	public function setTextoExplicacaoGeral($texto)
	{
		$this->expgeral = $texto;
	}
	
	public function getAlternativas()
	{
		return $this->alternativas;
	}

	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function RetornaDescricaoTela($tipo)
	{
		switch ($tipo)
		{
			case "lista":
				$ret = "listagem de perguntas";
				break;
			case "cadastro":
				$ret = "cadastro de perguntas";
		}
		
		return $ret;
	}
	
	public function AdicionaPergunta()
	{
		$sql  = "INSERT INTO mespergunta(CodClass, CodUsuario, Ativo, CodNivel, CodTipo, DtCadastro, Chave, ExplicacaoGeral) ";
		$sql .= "VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?);";

		$chave = Comuns::CodigoUnico();
		
		$cnn = Conexao2::getInstance();

		try
		{

			$cnn->beginTransaction();
			$cmd = $cnn->prepare($sql);
			$cmd->bindValue(1, $this->classe);
			$cmd->bindValue(2, $this->usuario);
			$cmd->bindValue(3, $this->ativo);
			$cmd->bindValue(4, $this->nivel);
			$cmd->bindValue(5, $this->tipo->getCodigo());
			$cmd->bindValue(6, $chave);
			$cmd->bindValue(7, $this->expgeral);

			$cmd->execute();
			$codi = $cnn->lastInsertId();

			if ($codi > 0)
			{
				$this->codigo = $codi;
				$this->GravaTexto();
				$cnn->commit();
				$this->CriaDiretorio();
				return true;
			}
			else
			{
				$this->msg_erro[] = "@lng[Erro inesperado ao criar o código da pergunta.]";
				$cnn->rollBack();
				return false;
			}
		}
		catch (PDOException $ex)
		{
			$this->msg_erro[] = $ex->getMessage();
			$cnn->rollBack();
			return false;
		}
	}

	private function CriaDiretorio()
	{
		$diretorio_base = 'files/' . $this->codigo;

		//Se o diretório da pergunta não existe, ele é criado
		if ( ! file_exists($diretorio_base) )
		{
			mkdir($diretorio_base);
		}

		// Diretório dos itens de ajuda da pergunta
		$diretorio_help = $diretorio_base . '/help';

		if ( ! file_exists($diretorio_help) )
		{
			mkdir($diretorio_help);
		}

		$diretorio_imgs = $diretorio_base . '/imgs';

		if ( ! file_exists($diretorio_imgs) )
		{
			mkdir($diretorio_imgs);
		}
	}

	/**
	 * Grava o texto da pergunta no banco de dados
	 * @return string : Retorna uma mensagem de alerta caso uma falha tenha ocorrido na gravação
	 * */
	private function GravaTexto()
	{
		try
		{
			$max = 3000;
			$inicio = 0;
			$tamanho = strlen($this->texto);

			$sql = "DELETE FROM mesperguntatexto WHERE CodPergunta = " . $this->codigo . ";";

			$cnn = Conexao2::getInstance();
			$cmddel = $cnn->prepare($sql);
			$cmddel->execute();

			$copia = $this->texto;
			$parte = substr($copia, $inicio, $max);
			$copia = str_replace($parte, "", $copia);
			$linha = 1;

			while ($parte != "")
			{
				$sql  = "INSERT INTO mesperguntatexto(CodPergunta, Linha, Texto) ";
				$sql .= "VALUES(?,?,?)";

				$cmdins = $cnn->prepare($sql);

				$cmdins->bindValue(1, $this->codigo);
				$cmdins->bindValue(2, $linha);
				$cmdins->bindValue(3, $parte);

				$cmdins->execute();

				$cmdins->closeCursor();

				$linha++;
				$parte = substr($copia, $inicio, $max);
				$copia = str_replace($parte, "", $copia);
			}
		}
		catch (PDOException $ex)
		{
			$this->msg_erro[] = $ex->getMessage();
		}
	}

	public function AtualizaPergunta()
	{
		$sql  = "UPDATE mespergunta ";
		$sql .= "SET CodClass = :pclass, Ativo = :pati, CodNivel = :pnivel, CodTipo = :ptipo, ExplicacaoGeral = :pExplicacaoGeral ";
		$sql .= "WHERE Codigo = :pcodigo";

		$cnn = Conexao2::getInstance();

		try
		{
			$cnn->beginTransaction();
			$q = $cnn->prepare($sql);

			$q->bindParam(":pclass", $this->classe, PDO::PARAM_INT);
			$q->bindParam(":pati", $this->ativo, PDO::PARAM_INT);
			$q->bindParam(":pnivel", $this->nivel, PDO::PARAM_INT);
			$q->bindParam(":ptipo", $this->tipo->getCodigo(), PDO::PARAM_INT);
			$q->bindParam(":pcodigo", $this->codigo, PDO::PARAM_INT);
			$q->bindParam(":pExplicacaoGeral", $this->expgeral , PDO::PARAM_STR);

			$q->execute();
			$this->GravaTexto();

			$cnn->commit();
			return true;
		}
		catch (PDOException $ex)
		{
			$this->msg_erro[] = $ex->getMessage();
			$cnn->rollBack();
			return false;
		}
	}

	public function Carregar($codigo)
	{
		if (!isset($codigo))
		{
			throw new Exception("@lng[Código inválido]", 0005);
		}

		$this->codigo = $codigo;

		$sql  = "select p.Codigo, p.CodClass, p.CodUsuario, p.Ativo, p.CodNivel, p.CodTipo, p.ExplicacaoGeral, pt.Linha, pt.Texto ";
		$sql .= "from mespergunta p inner join mesperguntatexto pt on pt.codpergunta = p.codigo ";
		$sql .= "where p.Codigo = :codigo;";

		$cnn = Conexao2::getInstance();
		$q = $cnn->prepare($sql);
		$q->bindParam(":codigo", $this->codigo, PDO::PARAM_INT);
		$q->execute();

		if ($q->errorCode() == Comuns::QUERY_OK)
		{
			if ($q->rowCount() > 0)
			{
				$cont = 1;
				while ($perg = $q->fetch(PDO::FETCH_OBJ))
				{
					if ($cont == 1)
					{
						$this->ativo = $perg->Ativo;
						$this->nivel = $perg->CodNivel;
						$this->tipo = TipoPergunta::RetornaTipo($perg->CodTipo);
						$this->classe = $perg->CodClass;
						$this->usuario = $perg->CodUsuario;
						$this->expgeral = $perg->ExplicacaoGeral;
					}
					$this->texto .= $perg->Texto;
					$cont++;
				}
				$this->CarregarAlternativas();
				
				return true;
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum registro encontrado]";
				return false;
			}
		}
		else
		{
			$msg = $q->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function RecarregarAlternativas()
	{
		unset($this->alternativas);
		$this->CarregarAlternativas();
	}

	private function CarregarAlternativas()
	{
		$sql  = "select CASE WHEN Sequencia IS NULL THEN 0 ELSE Sequencia END Sequencia, ";
		$sql .= "Texto, Imagem, Correto, Explicacao, ExibirExplicacao, TipoConsequencia, ValorConsequencia, CodUnico, CodBinario ";
		$sql .= "from mesalternativa ";
		$sql .= "where CodPergunta = :pCodPerg ";
		$sql .= "order by Sequencia;";

		$cnn = Conexao2::getInstance();
		$q = $cnn->prepare($sql);
		$q->bindParam(":pCodPerg", $this->codigo, PDO::PARAM_INT);
		$q->execute();

		if ($q->rowCount() > 0)
		{
			while ($rs = $q->fetch(PDO::FETCH_OBJ))
			{
				$a = new Alternativa();
				$a->setSequencia($rs->Sequencia);
				$a->setCodUnico($rs->CodUnico);
				$a->setTexto($rs->Texto);
				$a->setImagem($rs->Imagem);
				$a->setCorreto($rs->Correto);
				$a->setExplicacao($rs->Explicacao);
				$a->setExibirExplicacao($rs->ExibirExplicacao);
				$a->setTipoConsequencia($rs->CodConsequencia);
				$a->setValorConsequencia($rs->ValorConsequencia);
				$a->setCodBinario($rs->CodBinario);

				$this->alternativas[] = $a;

				$this->maiorseq = $rs->Sequencia;
			}
		}
	}

	public function BuscaAlternativasFiltradas($filtro)
	{
		Log::RegistraLog("Pesquisa alternativas da pergunta " . $this->codigo . " filtradas por: " . $filtro);
		
		$sql  = "select CASE WHEN Sequencia IS NULL THEN 0 ELSE Sequencia END Sequencia, ";
		$sql .= "Texto, Imagem, Correto, Explicacao, ExibirExplicacao, TipoConsequencia, ValorConsequencia, CodUnico, CodBinario ";
		$sql .= "from mesalternativa ";
		$sql .= "where CodPergunta = :pCodPerg ";
		$sql .= "  and ((CodBinario & :pFiltro) > 0) ";
		$sql .= "order by Sequencia;";

		$cnn = Conexao2::getInstance();
		$q = $cnn->prepare($sql);
		$q->bindParam(":pCodPerg", $this->codigo, PDO::PARAM_INT);
		$q->bindParam(":pFiltro", $filtro, PDO::PARAM_INT);
		$q->execute();

		$arrAlternativas = array();
		
		if ($q->rowCount() > 0)
		{
			while ($rs = $q->fetch(PDO::FETCH_OBJ))
			{
				$a = new Alternativa();
				$a->setSequencia($rs->Sequencia);
				$a->setCodUnico($rs->CodUnico);
				$a->setTexto($rs->Texto);
				$a->setImagem($rs->Imagem);
				$a->setCorreto($rs->Correto);
				$a->setExplicacao($rs->Explicacao);
				$a->setExibirExplicacao($rs->ExibirExplicacao);
				$a->setTipoConsequencia($rs->CodConsequencia);
				$a->setValorConsequencia($rs->ValorConsequencia);
				$a->setCodBinario($rs->CodBinario);

				$arrAlternativas[] = $a;
			}
		}
		return $arrAlternativas;
	}
	
	public function AdicionaAlternativa($alt)
	{
		try
		{
			if ($this->getTipo()->getCodigo() == 1)
			{
				if ($_REQUEST['hdnOrigem'] == "banco")
				{
					foreach ($_REQUEST['chkUsar'] as $imagem)
					{
						$value = base64_decode($imagem);
						$valores = split("::::", $value);
						
						$img = $valores[0];
					}
				}
				else
				{
					$arquivo = isset($_FILES["realupload"]) ? $_FILES["realupload"] : false;
		
					// Se não veio o arquivo
					if ($arquivo == false)
					{
						$this->msg_erro[] = "@lng[Informe um arquivo para realizar o upload]";
						return false;
					}
		
					if(!eregi("^image\/(pjpeg|jpeg|png|gif)$", $arquivo["type"]))
					{
						$this->msg_erro[] = "@lng[Tipo de arquivo enviado inválido. Envie jpeg, gif ou png]";
						return false;
					}
		
					// Recupera extensão do arquivo
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
		
					// Monta o nome final do arquivo
					$img = 'files/perg/' . $this->getCodigo() . "/imgs/" . Comuns::CodigoUnico() . "." . $ext[1];
		
					// Verifica a existencia dos diretórios. Se não existirem, eles são criados
					$this->CriaDiretorio();
		
					// Carrega o arquivo
					move_uploaded_file($arquivo["tmp_name"], $img);
				}
			}
			else
			{
				$img = "";
			}

			// Se deu tudo certo no upload ou pergunta é do tipo texto, faz a gravação no banco de dados
				
			$sql  = "INSERT INTO mesalternativa(CodPergunta, Sequencia, Texto, Imagem, Correto, Explicacao, ExibirExplicacao, TipoConsequencia, ValorConsequencia, CodBinario, Origem) ";
			$sql .= "SELECT :pCodPerg, :pSeq, :pTexto, :pImagem, :pCorreto, :pExplicacao, :pExibirExp, :pTipoConseq, :pValConseq, ";
			$sql .= "(SELECT IFNULL((MAX(CodBinario) * 2), 1) FROM mesalternativa WHERE codpergunta = :pCodPerg), :pOrigem ";
			//$sql .= "VALUES(:pCodPerg, :pSeq, :pTexto, :pImagem, :pCorreto, :pExplicacao, :pExibirExp, :pTipoConseq, :pValConseq);";

			$proximo = $this->maiorseq + 1;
				
			try
			{
				$cnn = Conexao2::getInstance();
				$cnn->beginTransaction();
				$q = $cnn->prepare($sql);
				$q->bindParam(":pCodPerg", $this->getCodigo(), PDO::PARAM_INT);
				$q->bindParam(":pSeq", $proximo, PDO::PARAM_INT);
				$q->bindParam(":pTexto", $alt->getTexto(), PDO::PARAM_STR);
				$q->bindParam(":pImagem", $img, PDO::PARAM_STR);
				$q->bindParam(":pCorreto", $alt->getCorreto(), PDO::PARAM_INT);
				$q->bindParam(":pExplicacao", $alt->getExplicacao(), PDO::PARAM_STR);
				$q->bindParam(":pExibirExp", $alt->getExibirExplicacao(), PDO::PARAM_INT);
				$q->bindParam(":pTipoConseq", $alt->getTipoConsequencia(), PDO::PARAM_INT);
				$q->bindParam(":pValConseq", $alt->getValorConsequencia(), PDO::PARAM_INT);
				$q->bindParam(":pOrigem", $alt->getOrigem(), PDO::PARAM_STR);
					
				$q->execute();

				if ($q->errorCode() == Comuns::QUERY_OK)
				{
					if (($alt->getTipoConsequencia() == 2) || ($alt->getTipoConsequencia() == 3))
					{
						switch($alt->getTipoConsequencia())
						{
							case 2:
								$sqlE2  = "INSERT INTO mesproximapergunta(CodPergunta) ";
								$sqlE2 .= "VALUES(:pValorAcao);";
								break;
							case 3:
								$sqlE2 = "INSERT INTO mesperguntaapoio";
						}
							
						$q2 = $cnn->prepare($sqlE2);
						$q2->bindParam(":pValorAcao", $alt->getValorConsequencia(), PDO::PARAM_INT);
						$q2->execute();
						$codacao = $cnn->lastInsertId();
							
						if ($codacao > 0)
						{
							$sqlE3  = "UPDATE mesalternativa ";
							$sqlE3 .= "SET ValorConsequencia = :pCodAcaoGerado ";
							$sqlE3 .= "WHERE CodPergunta = :pCodPergunta AND Sequencia = :pCodSequencia;";
	
							$q3 = $cnn->prepare($sqlE3);
							$q3->bindParam(":pCodAcaoGerado", $codacao, PDO::PARAM_INT);
							$q3->bindParam(":pCodPergunta", $this->getCodigo(), pdo::PARAM_INT);
							$q3->bindParam(":pCodSequencia", $proximo, PDO::PARAM_INT);
	
							$q3->execute();
	
							$cnn->commit();
						}
						else
						{
							$cnn->rollBack();
							echo("Erro 2035");
						}
					}
					else
					{
						$cnn->commit();
					}
				}
				else
				{
					$cnn->rollBack();
					$msg = $q->errorInfo();
					echo($msg[2]);
				}
			}
			catch (PDOException $e)
			{
				$cnn->rollBack();
				echo("Erro 2054");
			}
				
			$this->RecarregarAlternativas();

			return true;
		}
		catch (PDOException $ex)
		{
			echo($ex->getMessage());
			$this->msg_erro[] = $ex->getMessage();
			return false;
		}
	}

	public function AtualizaAlternativa($alt)
	{
		try
		{
			$img = "";
			if ($_REQUEST['hdnOrigem'] == "banco")
			{
				foreach ($_REQUEST['chkUsar'] as $imagem)
				{
					$value = base64_decode($imagem);
					$valores = split("::::", $value);
					
					$img = $valores[0];
				}
			}
			$sql  = "UPDATE mesalternativa ";
			$sql .= "SET Texto = :pTexto, ";
			$sql .= "    Correto = :pCorreto, ";
			$sql .= "    Explicacao = :pExplicacao, ";
			$sql .= "    ExibirExplicacao = :pExibir, ";
			$sql .= "    Origem = :pOrigem ";
			if($img != "")
			{
				$sql .= "    ,Imagem = :pURL ";
			}
			$sql .= "WHERE CodPergunta = :pCodPergunta ";
			$sql .= "  AND Sequencia = :pSequencia;";

			//$alt = new Alternativa();

			$cnn = Conexao2::getInstance();
			$q = $cnn->prepare($sql);
			$q->bindParam(":pTexto", $alt->getTexto(), PDO::PARAM_STR);
			$q->bindParam(":pCorreto", $alt->getCorreto(), PDO::PARAM_INT);
			$q->bindParam(":pExplicacao", $alt->getExplicacao(), PDO::PARAM_STR);
			$q->bindParam(":pExibir", $alt->getExibirExplicacao(), PDO::PARAM_INT);
			$q->bindParam(":pCodPergunta", $this->getCodigo(), PDO::PARAM_INT);
			$q->bindParam(":pSequencia", $alt->getSequencia(), PDO::PARAM_INT);
			$q->bindParam(":pOrigem", $alt->getOrigem(), PDO::PARAM_STR);
			if($img != "")
			{
				$q->bindParam(":pURL", $img, PDO::PARAM_STR);
			}

			$q->execute();

			if ($q->errorCode() == Comuns::QUERY_OK)
			{
				if ((isset($_FILES["realupload"])) && ($_FILES["realupload"]!= ""))
				{
					$up = new Upload();
					$up->setArquivo($_FILES["realupload"]);
					
					if ($up->ValidaImagem($up->getTipo()))
					{
						$imgatual = $this->BuscaImagemAtual($this->getCodigo(), $alt->getSequencia());
						if ($imgatual != false)
						{
							if (! $up->RealizaTrocaImagem($imgatual))
							{
								$this->msg_erro[] = $up->getStatus();
								return false;
							}
						}
						else
						{
							return false;
						}
					}
					else
					{
						unset($this->msg_erro);
						$this->msg_erro[] = "@lng[Os dados textuais foram atualizados porem o arquivo enviado não é uma imagem válida e a imagem antiga não foi substituída]";
					}
				}
			}
			else
			{
				$msg = $q->errorInfo();
				$this->msg_erro[] = $msg[2];
				return false;
			}
			
			$this->RecarregarAlternativas();

			return true;
		}
		catch (PDOException $ex)
		{
			unset($this->msg_erro);
			$this->msg_erro[] = $ex->getMessage();
			return false;
		}
	}

	public function BuscaImagemAtual($perg, $seq)
	{
		$sql  = "select Imagem from mesalternativa ";
		$sql .= "where CodPergunta = :pCodPergunta and Sequencia = :pSequencia";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodPergunta", $perg, PDO::PARAM_INT);
		$cmd->bindParam(":pSequencia", $seq, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$valor = $cmd->fetchColumn();
			return $valor;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function ReordenaAlternativa($seqCorreta)
	{
		try
		{
			$idsUnicos = explode(",",$seqCorreta);
			
			for($i=0;$i<count($idsUnicos);$i++)
			{
				// Exclui a alternativa do banco de dados
				$sql = "UPDATE mesalternativa SET Sequencia = ".($i+1)." WHERE CodPergunta = :pCodPerg AND CodUnico = :pCodUni;";
	
				$cnn = Conexao2::getInstance();
	
				$q = $cnn->prepare($sql);
	
				$q->bindParam(":pCodPerg", $this->getCodigo(), PDO::PARAM_INT);
				$q->bindParam(":pCodUni", base64_decode($idsUnicos[$i]), PDO::PARAM_INT);
	
				$q->execute();
				$q->closeCursor();
			}
			
			return true;
		}
		catch (PDOException $ex)
		{
			unset($this->msg_erro);
			$this->msg_erro[] = $ex->getMessage();
			return false;
		}
		catch (Exception $ex2)
		{
			unset($this->msg_erro);
			$this->msg_erro[] = $ex2->getMessage();
			return false;
		}
	}
	
	public function DeletaAlternativa($alt)
	{
		try
		{
			//$p = unserialize($_SESSION['perg']);

			if (($alt->getOrigem() == "upload") && file_exists($alt->getImagem()))
			{
				// Se o arquivo da imagem existir, exclui o mesmo.
				unlink($alt->getImagem());
			}

			// Verifica se tem consequencias associadas com a alternativa
			$acao = $alt->getTipoConsequencia();
			$qual_acao = (($acao > 1) && ($alt->getValorConsequencia() > 0)) ? $alt->getValorConsequencia() : null;
			$seq = $alt->getSequencia();

			// Exclui a alternativa do banco de dados
			$sql = "DELETE FROM mesalternativa WHERE CodPergunta = :pCodPerg AND Sequencia = :pCodSeq;";

			$cnn = Conexao2::getInstance();

			$q = $cnn->prepare($sql);

			$q->bindParam(":pCodPerg", $this->getCodigo(), PDO::PARAM_INT);
			$q->bindParam(":pCodSeq", $seq, PDO::PARAM_INT);

			$q->execute();
			$q->closeCursor();

			if ($qual_acao != null)
			{
				// Se tem alguma consequencia...
				if ($acao == 2)
				{
					// Se for uma pergunta, exclui esse vinculo
					$sql = "DELETE FROM mesproximapergunta WHERE Codigo = :pCodAcao;";
				}
				else if ($acao == 3)
				{
					// Se for um apoio, exclui essas informações
					$sql = "DELETE FROM mesperguntaapoio WHERE Codigo = :pCodAcao;";
				}
					
				$q = $cnn->prepare($sql);
				$q->bindParam(":pCodAcao", $qual_acao, pdo::PARAM_INT);

				$q->execute();
				$q->closeCursor();
			}

			if ($this->maiorseq > $seq)
			{
				// Se existiam alternativas com sequencia mair que a que está sendo excluida,
				// atualiza essas sequencias, decrescendo seu código.
				$sql = "UPDATE mesalternativa SET Sequencia = Sequencia - 1 WHERE CodPergunta = :pCodPerg AND Sequencia > :pCodSeq;";

				$q = $cnn->prepare($sql);

				$q->bindParam(":pCodPerg", $this->getCodigo(), pdo::PARAM_INT);
				$q->bindParam(":pCodSeq", $seq, PDO::PARAM_INT);

				$q->execute();
				$q->closeCursor();
			}

			return true;
		}
		catch (PDOException $ex)
		{
			unset($this->msg_erro);
			$this->msg_erro[] = $ex->getMessage();
			return false;
		}
		catch (Exception $ex2)
		{
			unset($this->msg_erro);
			$this->msg_erro[] = $ex2->getMessage();
			return false;
		}
	}

	public function ListaTabela($pagina = 1, $nporpagina = 10)
	{
		$ini  = (($pagina * $nporpagina) - $nporpagina);
		$sql  = "select  p.Codigo, case when length(pt.Texto) > 50 then concat(left(pt.Texto, 50), '...') else pt.Texto end as Texto ";
		$sql .= "		,u.Codigo as CodAutor, u.NomeCompleto as Autor, cp.Descricao as Classe, tp.Descricao as Tipo, p.Ativo ";
		$sql .= "from mespergunta p ";
		$sql .= "inner join mesclassepergunta cp on cp.Codigo = p.CodClass ";
		$sql .= "inner join mesperguntatexto pt on pt.CodPergunta = p.Codigo and pt.Linha = 1 ";
		$sql .= "inner join mesusuario u on u.Codigo = p.Codusuario ";
		$sql .= "inner join mestipopergunta tp on tp.Codigo = p.CodTipo LIMIT " . $ini . ", " . $nporpagina . ";";

		$cnn = Conexao2::getInstance();
		$q = $cnn->prepare($sql);
		$q->execute();

		if ($q->rowCount() > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Lista de Exercícios",
				"PerguntasCad",
			array('Descrição', 'Autor', 'Classe', 'Tipo', 'Ativo', 'Ações')
			);

			while ($rs = $q->fetch(PDO::FETCH_OBJ))
			{
				$cod = base64_encode($rs->Codigo);

				$ret .= '<tr>';
				$ret .= '  <td>' . $rs->Texto . '</td>';
				$ret .= '  <td>' . $rs->Autor . '</td>';
				$ret .= '  <td>' . $rs->Classe . '</td>';
				$ret .= '  <td>' . $rs->Tipo . '</td>';

				// Exibe o status atual da pergunta.
				if ($rs->Ativo == 1)
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAA\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_ATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}
				else
				{
					$ret .= '  <td><a href="javascript:void(0);" onclick="javascript:fntAlteraStatus(\'AAAA\', \'' . $cod . '\');">' . Comuns::IMG_STATUS_INATIVO . '</a></td>';
					$ret = str_replace("##id##", 'id="'. $cod .'"', $ret);
				}

				$ret .= '  <td>';
				$ret .= '    <a href="vwpergunta.php?r=' . $cod . '">' . Comuns::IMG_ACAO_EDITAR . '</a>';
				$ret = str_replace("##id##", "", $ret);

				$ret .= '    <a href="vwalternativas.php?p=' . $cod . '">' . Comuns::IMG_ACAO_OPCOES . '</a>';

				// O Autor da pergunta é o único que pode excluir ela.
				if ($this->usuario == $rs->CodAutor)
				{
					$ret .= '    <a href="javascript:void(0);" onclick="javascript:fntExcluirPergunta(' . $cod . ');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
					$ret = str_replace("##id##", "", $ret);
				}
				$ret .= '  </td>';


				$ret .= '</tr>';
			}

			$ret .= '  </tbody>';
			$ret .= '</table>';
			
			$registros = Comuns::NRegistros("mespergunta");
			if ($registros > 0)
			{
				$ret .= Comuns::GeraPaginacao($registros, $pagina, $nporpagina, $this->form);
			}
		}
		else
		{
			$ret = "@lng[Nenhuma pergunta cadastrada]";
		}

		return $ret;
	}

	/**
	 * Retorna um array de objetos de perguntas ativas
	 * @param $classe int: A classe a ser filtrada
	 * @param $tipo int: O tipo de pergunta a ser filtrada
	 * @param $string string: O texto a ser filtrado nas perguntas
	 * @param $menos int: Código que deve ser eliminado da consulta
	 * @param $usuario int: Código do usuário logado no sistema
	 * */
	public function ListaPerguntasAtivas($classe = null, $tipo = null, $string = "", $menos = 0, $usuario)
	{
		$string = str_replace(" ", "%", $string);

		$sql  = "SELECT Codigo, Texto, CASE WHEN Autor = " . $usuario . " THEN 0 ELSE 1 END as Prioridade ";
		$sql .= "FROM vwperguntasativas ";
		$sql .= "WHERE Texto LIKE '%" . $string . "%' AND Codigo <> " . $menos;

		if ($tipo != null)
		{
			$sql .= " AND CodTipo = " . $tipo;
		}

		if ($classe != null)
		{
			$sql .= " AND CodClass = " . $classe;
		}

		$sql .= " ORDER BY CASE WHEN Autor = " . $usuario . " THEN 0 ELSE 1 END, DtCadastro;";

		$cnn = Conexao2::getInstance();
		$q = $cnn->prepare($sql);
		$q->execute();

		$perguntas = $q->fetchAll(PDO::FETCH_OBJ);

		return $perguntas;
	}
	
	public function ListaPerguntasCaso($codcaso)
	{
		$sql  = "select cp.CodCaso, cp.CodPergunta, pa.Tipo, pa.Classe, pa.Texto, pa.Alternativas ";
		$sql .= "from mescasoperguntas cp ";
		$sql .= "inner join vwperguntasativas pa ";
		$sql .= "		on pa.Codigo = cp.CodPergunta ";
		$sql .= "where cp.CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhum registro encontrado]";
				return false;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
}

?>