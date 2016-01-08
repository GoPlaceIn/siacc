<?php
//--utf8_encode --
include_once 'cls/conexao.class.php';
include_once 'cls/tipoexame.class.php';
include_once 'cls/simnao.class.php';
include_once 'cls/mostrarquando.class.php';
include_once 'cls/upload.class.php';
include_once 'cls/midia.class.php';
include_once 'cls/log.class.php';
include_once 'cls/caso.class.php';

class Exame
{
	private $codcaso;
	private $codexame;
	private $descricao;
	private $tipo;
	private $correto;
	private $justificativa;
	private $conteudoadicional;
	private $laudo;
	private $temcomponentes;
	private $bateria;
	private $mostraquando;
	private $agrupar;

	private $msg_erro;

	// get's ------------------------------------------------------------
	public function getCodcaso()
	{
		return $this->codcaso;
	}

	public function getCodexame()
	{
		return $this->codexame;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getTipo()
	{
		return $this->tipo;
	}

	public function getCorreto()
	{
		return $this->correto;
	}

	public function getJustificativa()
	{
		return $this->justificativa;
	}

	public function getConteudoadicional()
	{
		return $this->conteudoadicional;
	}

	public function getLaudo()
	{
		return $this->laudo;
	}
	
	public function getTemComponentes()
	{
		return $this->temcomponentes;
	}
	
	public function getBateria()
	{
		return $this->bateria;
	}
	
	public function getMostraQuando()
	{
		return $this->mostraquando;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function getMostrarAgrupado()
	{
		return $this->agrupar;
	}
	// fim get's --------------------------------------------------------

	// set's ------------------------------------------------------------
	public function setCodcaso($p_codcaso)
	{
		$this->codcaso = $p_codcaso;
	}

	public function setCodexame($p_codexame)
	{
		$this->codexame = $p_codexame;
	}

	public function setDescricao($p_descricao)
	{
		$this->descricao = $p_descricao;
	}

	public function setTipo($p_tipo)
	{
		$this->tipo = $p_tipo;
	}

	public function setCorreto($p_correto)
	{
		$this->correto = $p_correto;
	}

	public function setJustificativa($p_justificativa)
	{
		$this->justificativa = $p_justificativa;
	}

	public function setConteudoadicional($p_conteudoadicional)
	{
		$this->conteudoadicional = $p_conteudoadicional;
	}
	
	public function setLaudo($p_laudo)
	{
		$this->laudo = $p_laudo;
	}
	
	public function setTemComponentes($p_temcomponentes)
	{
		$this->temcomponentes = $p_temcomponentes;
	}
	
	public function setBateria($p_bateria)
	{
		$this->bateria = $p_bateria;
	}
	
	public function setMostraQuando($p_mostraquando)
	{
		$this->mostraquando = $p_mostraquando;
	}
	
	public function setMostrarAgrupado($p_agrupado)
	{
		$this->agrupar = $p_agrupado;
	}
	// fim set's --------------------------------------------------------


	// funções ----------------------------------------------------------
	public function __construct()
	{
		$this->codcaso = 0;
		$this->codexame = 0;
		$this->descricao = null;
		$this->tipo = null;
		$this->correto = null;
		$this->justificativa = null;
		$this->conteudoadicional = null;
		$this->laudo = null;
		$this->temcomponentes = null;
		$this->bateria = null;
		$this->mostraquando = null;
	}


	public function Insere()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->descricao))
			{
				if (isset($this->tipo))
				{
					if (isset($this->correto))
					{
						if (isset($this->justificativa))
						{
							//if (isset($this->bateria))
							//{
								//if (isset($this->mostraquando))
								//{
									$sql  = "INSERT INTO mescasoexames(CodCaso, Descricao, Tipo, Correto, Justificativa, ConteudoAdicional, NumBateria, MostraQuando, AgrupaComABateria) ";
									$sql .= "VALUES(:pCodCaso, :pDescricao, :pTipo, :pCorreto, :pJustificativa, :pConteudoAdicional, :pNumBateria, :pMostraQuando, :pAgrupaComABateria);";
		
									$cnn = Conexao2::getInstance();
									$cnn->beginTransaction();
		
									$cmd = $cnn->prepare($sql);
		
									$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
									$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
									$cmd->bindParam(":pTipo", $this->tipo, PDO::PARAM_INT);
									$cmd->bindParam(":pCorreto", $this->correto, PDO::PARAM_INT);
									$cmd->bindParam(":pJustificativa", $this->justificativa, PDO::PARAM_STR);
									$cmd->bindParam(":pConteudoAdicional", $this->conteudoadicional, PDO::PARAM_STR);
									$cmd->bindParam(":pNumBateria", $nada, PDO::PARAM_NULL);
									$cmd->bindParam(":pMostraQuando", $nada, PDO::PARAM_NULL);
									$cmd->bindParam(":pAgrupaComABateria", $this->agrupar, PDO::PARAM_INT);
		
									$cmd->execute();
		
									if ($cmd->errorCode() == Comuns::QUERY_OK)
									{
										$this->codexame = $cnn->lastInsertId();
										$cnn->commit();
										return true;
									}
									else
									{
										$cnn->rollBack();
										$msg = $cmd->errorInfo();
										$this->msg_erro = $msg[2] . " linha 207";
										return false;
									}
								//}
								//else
								//{
								//	$this->msg_erro = "Não foi informado quando o exame será exibido";
								//	return false;
								//}
							//}
							//else
							//{
							//	$this->msg_erro = "Bateria não informada";
							//	return false;
							//}
						}
						else
						{
							$this->msg_erro = "@lng[Justificativa não informada]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Campo Correto não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Tipo de exame não informado]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Descrição do exame não informado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não informado]";
			return false;
		}
	}

	public function Atualiza()
	{
		if (isset($this->codcaso))
		{
			if (isset($this->descricao))
			{
				if (isset($this->tipo))
				{
					if (isset($this->correto))
					{
						if (isset($this->justificativa))
						{
							//if (isset($this->bateria))
							//{
								//if (isset($this->mostraquando))
								//{
									$sql  = "UPDATE mescasoexames ";
									$sql .= "SET Descricao = :pDescricao, ";
									$sql .= "    Tipo = :pTipo, ";
									$sql .= "    Correto = :pCorreto, ";
									$sql .= "    Justificativa = :pJustificativa, ";
									$sql .= "    ConteudoAdicional = :pConteudoAdicional, ";
									$sql .= "    NumBateria = :pNumBateria, ";
									$sql .= "    MostraQuando = :pMostraQuando, ";
									$sql .= "    AgrupaComABateria = :pAgrupaComABateria ";
									$sql .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame;";
		
									$cnn = Conexao2::getInstance();
		
									$cmd = $cnn->prepare($sql);
		
									$cmd->bindParam(":pDescricao", $this->descricao, PDO::PARAM_STR);
									$cmd->bindParam(":pTipo", $this->tipo, PDO::PARAM_INT);
									$cmd->bindParam(":pCorreto", $this->correto, PDO::PARAM_INT);
									$cmd->bindParam(":pJustificativa", $this->justificativa, PDO::PARAM_STR);
									$cmd->bindParam(":pConteudoAdicional", $this->conteudoadicional, PDO::PARAM_STR);
									$cmd->bindParam(":pNumBateria", $nada, PDO::PARAM_NULL);
									$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
									$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
									$cmd->bindParam(":pMostraQuando", $nada, PDO::PARAM_NULL);
									$cmd->bindParam(":pAgrupaComABateria", $this->agrupar, PDO::PARAM_INT);
		
									$cmd->execute();
		
									if ($cmd->errorCode() == Comuns::QUERY_OK)
									{
										return true;
									}
									else
									{
										$erro = $cmd->errorInfo();
										$this->msg_erro = $erro[2] + " linha 305";
										return false;
									}
								//}
								//else
								//{
								//	$this->msg_erro = "Não foi informado quando o exame será exibido";
								//	return false;
								//}
							//}
							//else
							//{
							//	$this->msg_erro = "Bateria não informada";
							//	return false;
							//}
						}
						else
						{
							$this->msg_erro = "@lng[Justificativa não informada]";
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Campo correto não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Tipo de exame não informado]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Descrição não informada]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não informado]";
			return false;
		}
	}

	public function Deleta()
	{
		$sqlpode  = "select 1 as Tem "; 
		$sqlpode .= "from mescasomontagem ";
		$sqlpode .= "where codcaso = :pCodCaso ";
		$sqlpode .= "  and codmontagem = 1 ";
		$sqlpode .= "  and TipoConteudo in('optex','resex') ";
		$sqlpode .= "  and Organizador = 'cont' ";
		$sqlpode .= "  and ContReferencia = :pCodExame";
		
		$cnn = Conexao2::getInstance();
		
		$cmdpode = $cnn->prepare($sqlpode);
		$cmdpode->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdpode->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmdpode->execute();
		
		if ($cmdpode->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmdpode->rowCount() == 0)
			{
				$sql1 = "DELETE FROM mescasoexamesconteudos WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame;";
				$sql2 = "DELETE FROM mescasoexamesitens WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame;";
				$sql3 = "DELETE FROM mescasoexames WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame;";
				
				$cnn->beginTransaction();
				
				$cmd = $cnn->prepare($sql1);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					$cmd->closeCursor();
					$cmd = $cnn->prepare($sql2);
					$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
					$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
					$cmd->execute();
					
					if ($cmd->errorCode() == Comuns::QUERY_OK)
					{
						$cmd->closeCursor();
						$cmd = $cnn->prepare($sql3);
						$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
						$cmd->execute();
						
						if ($cmd->errorCode() == Comuns::QUERY_OK)
						{
							$cnn->commit();
							return true;
						}
						else
						{
							$msg = $cmd->errorInfo();
							$this->msg_erro = $msg[2];
							$cnn->rollBack();
							return false;
						}
					}
					else
					{
						$msg = $cmd->errorInfo();
						$this->msg_erro = $msg[2];
						$cnn->rollBack();
						return false;
					}
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
					$cnn->rollBack();
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Este exame está sendo utilizado na montagem do caso. Não pode ser excluído.]";
				return false;
			}
		}
		else
		{
			$msg = $cmdpode->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function Carrega($codcaso, $codexame)
	{
		$sql  = "select exames.CodCaso, exames.CodExame, exames.Descricao, exames.Tipo, ";
		$sql .= "		exames.Correto, exames.Justificativa, exames.ConteudoAdicional, exames.Laudo, ";
		$sql .= "		exames.NumBateria, exames.MostraQuando, exames.AgrupaComABateria, tipo.TemComponentes, ";
		$sql .= "		tipo.PermiteImagem, tipo.PermiteDocs, tipo.PermiteValores ";
		$sql .= "from mescasoexames exames ";
		$sql .= "inner join mestipoexame tipo on tipo.Codigo = exames.Tipo ";
		$sql .= "where exames.CodCaso = :pCodCaso AND exames.CodExame = :pCodExame;";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);

		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);

		$cmd->execute();

		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$exame = $cmd->fetch(PDO::FETCH_OBJ);
				$this->setCodcaso($exame->CodCaso);
				$this->setCodexame($exame->CodExame);
				$this->setDescricao($exame->Descricao);
				$this->setCorreto($exame->Correto);
				$this->setJustificativa($exame->Justificativa);
				$this->setConteudoadicional($exame->ConteudoAdicional);
				$this->setLaudo($exame->Laudo);
				$this->setTemComponentes($exame->TemComponentes);
				$this->setBateria($exame->NumBateria);
				$this->setMostraQuando($exame->MostraQuando);
				$this->setMostrarAgrupado($exame->AgrupaComABateria);
				
				$this->setTipo($exame->Tipo);
				
				return true;
			}
			else
			{
				$this->msg_erro = "@lng[Registro não encontrado]";
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

	public function ListaExamesCaso($codcaso)
	{
		try
		{
			$sql  = "select ex.CodExame, ex.Descricao, ex.Tipo, t.Descricao as DescricaoTipo,  ex.Correto, ";
			$sql .= "ex.Justificativa, ex.ConteudoAdicional, ex.NumBateria, ex.MostraQuando ";
			$sql .= "from mescasoexames ex ";
			$sql .= "inner join mestipoexame t on t.Codigo = ex.Tipo ";
			$sql .= "where ex.CodCaso = :pCodCaso order by ex.Descricao;";

			$cnn = Conexao2::getInstance();

			$cmd = $cnn->prepare($sql);

			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);

			$cmd->execute();

			if ($cmd->rowCount() > 0)
			{
				$tiporesp = Caso::BuscaConfiguracao($codcaso, "exames", "TipoResp");
				
				switch ($tiporesp)
				{
					case "CE":
						$labelResposta = "@lng[Correto]";
						break;
					case "ORD":
						$labelResposta = "@lng[Importancia (ordem)]";
						break;
				}
				
				$tabela = Comuns::TopoTabelaListagem(
					"Exames cadastrados", 
					"exames",
					array("Descrição", "Tipo", /*"Mostrar este exame",*/ $labelResposta, /*"Bateria",*/ "Ações")
				);

				while ($exame = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$tabela .= '<tr>';
					$tabela .= '<td>' . $exame->Descricao . "</td>";
					$tabela .= '<td>' . $exame->DescricaoTipo . "</td>";
					//$tabela .= '<td>' . MostraQuando::Descreve($exame->MostraQuando) . '</td>';
					$tabela .= '<td width="90px">' . (($tiporesp == "CE") ? SimNao::Descreve($exame->Correto) : $exame->Correto) . "</td>";
					//$tabela .= '<td>' . $exame->NumBateria . "</td>";
					$tabela .= '<td width="100px">';
					$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntExibeCadastroEtapa(\'' . base64_encode($exame->CodExame) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
					$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntLoadItemDetalhes(\'exames\', \'' . base64_encode($exame->CodExame) . '\');">' . Comuns::IMG_ACAO_DETALHES . '</a>';
					$tabela .= '  <a href="javascript:void(0);" onclick="javascript:fntDeletaExame(\'' . base64_encode($exame->CodExame) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a>';
					$tabela .= '</td>';
					$tabela = str_replace("##id##", "", $tabela);

					$tabela .= "</tr>";
				}

				$tabela .= "</tbody></table>";
			}
			else
			{
				$tabela = "@lng[Nenhum exame cadastrado até o momento]";
			}
		}
		catch (PDOException $ex)
		{
			$this->msg_erro = $ex->getMessage();
			$tabela = $this->msg_erro;
		}

		header('Content-Type: text/html; charset=iso-8859-1');
		return $tabela;
	}

	public function ListaRecordSet($codcaso, $numbateria = 0, $ExcluiSoRespostas = "N")
	{
		$sql  = "select ex.CodExame, ex.Descricao, ex.Tipo, t.Descricao as DescricaoTipo,  ex.Laudo, ex.Correto, ";
		$sql .= "ex.Justificativa, ex.ConteudoAdicional, ex.NumBateria, ex.MostraQuando, ex.AgrupaComABateria ";
		$sql .= "from mescasoexames ex ";
		$sql .= "inner join mestipoexame t on t.Codigo = ex.Tipo ";
		$sql .= "where ex.CodCaso = :pCodCaso ";
		
		if ($numbateria != 0)
		{
			$sql .= "and ex.NumBateria = " . $numbateria . " ";
		}
		if ($ExcluiSoRespostas != "N")
		{
			$sql .= "and ex.MostraQuando = 0 ";
		}
		
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
	
	public function ListaRecordSetImagensItensExame()
	{
		$sql  = "select CodItem, Descricao, ";
		$sql .= "		Valor, Complemento ";
		$sql .= "from mescasoexamesitens ";
		$sql .= "where TipoItem = 'img' ";
		$sql .= "  and codcaso = :pCodCaso";
		$sql .= "  and codexame = :pCodExame";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "0";
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

	public function ListaRecordSetDocumentosItensExame()
	{
		$sql  = "select CodItem, Descricao, ";
		$sql .= "		Valor, Complemento ";
		$sql .= "from mescasoexamesitens ";
		$sql .= "where TipoItem = 'doc' ";
		$sql .= "  and codcaso = :pCodCaso";
		$sql .= "  and codexame = :pCodExame";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "0";
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
	
	
	public function ListaArquivosExame($codcaso, $codexame, $tipo)
	{
		$descricao = (($tipo == "img") ? "Imagens" : "Documentos");

		$sql  = "select CodItem, Descricao, Valor ";
		$sql .= "from mescasoexamesitens ";
		$sql .= "where TipoItem = :pTipo and CodCaso = :pCodCaso and CodExame = :pCodExame; ";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pTipo", $tipo, PDO::PARAM_STR);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);

		$cmd->execute();

		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$lstimgs = Comuns::TopoTabelaListagem(
					"",
					"lst" . $tipo,
				array($descricao, "Ações")
				);

				while ($imagem = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$lstimgs .= '<tr>';
					$lstimgs .= '  <td>' . $imagem->Descricao . '</td>';
					$lstimgs .= '  <td style="width:100px;">';
					if($tipo == "img")
					{
						$lstimgs .= '    <a href="javascript:void(0);" onclick="javascript:fntDeletaImgExame(\'' . base64_encode($imagem->CodItem) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a> ';
						//$lstimgs .= '    <a href="javascript:void(0);" onclick="javascript:fntEditaImgExame(\'' . base64_encode($imagem->CodItem) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a> ';
						$lstimgs .= '    <a href="javascript:void(0);" onclick="javascript:fntLoadItemDetalhes(\'atualizaexame\', \'' . base64_encode($imagem->CodItem) . '\');">' . Comuns::IMG_ACAO_ATUALIZAR . '</a> ';
						$lstimgs .= '    <a href="javascript:void(0);" onclick="javascript:fntLoadItemDetalhes(\'veimagemexame\', \'' . base64_encode($imagem->Valor) . '\');">' . Comuns::IMG_ACAO_VISUALIZAR . '</a>';
					}
					else
					{
						$midia = new Midia();
						$midia->setCodCaso($codcaso);
						$midia->setCodMidia($imagem->Valor);
						
						$lstimgs .= '    <a href="javascript:void(0);" onclick="javascript:fntDeletaDocExame(\'' . base64_encode($imagem->CodItem) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a> ';
						//$lstimgs .= '    <a href="javascript:void(0);" onclick="javascript:fntEditaDocExame(\'' . base64_encode($imagem->CodItem) . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a> ';
						//$lstimgs .= '    <a href="javascript:void(0);" onclick="javascript:fntLoadItemDetalhes(\'atualizaexamedoc\', \'' . base64_encode($imagem->CodItem) . '\');">' . Comuns::IMG_ACAO_ATUALIZAR . '</a> ';
						if($midia->CarregaPorCodigoEspecifico())
							$lstimgs .= '    <a href="' . $midia->getURL() . '" target="_blank">' . Comuns::IMG_ACAO_VISUALIZAR . '</a>';
					}
					$lstimgs .= '  </td>';
					$lstimgs = str_replace("##id##", "", $lstimgs);
					$lstimgs .= '</tr>';
				}

				$lstimgs .= "</tbody></table>";

			}
			else
			{
				$lstimgs = "@lng[Nenhum arquivo cadastrado.]";
			}
			return $lstimgs;
		}
		else
		{
			$erro = $cmd->errorInfo();
			$this->msg_erro = $erro[2];
			return false;
		}
	}

	public function InsereImagemExame($codcaso, $codexame, $caminho, $descricao, $complemento, $origem)
	{
		if (isset($codcaso))
		{
			if (isset($codexame))
			{
				if (isset($caminho))
				{
					if (isset($descricao))
					{
						$sql  = "insert into mescasoexamesitens(CodCaso, CodExame, Descricao, Valor, TipoItem, Complemento, DtCadastro) ";
						$sql .= "values(:pCodCaso, :pCodExame, :pDescricao, :pValor, :pTipoItem, :pComplemento, :pDtCadastro);";

						$tipo = "img";
						$data = date("Y-m-d H:i:s");

						$cnn = Conexao2::getInstance();

						$cmd = $cnn->prepare($sql);

						$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
						$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
						$cmd->bindParam(":pDescricao", $descricao, PDO::PARAM_STR);
						$cmd->bindParam(":pValor", $caminho, PDO::PARAM_STR);
						$cmd->bindParam(":pTipoItem", $tipo, PDO::PARAM_STR);
						$cmd->bindParam(":pComplemento", $complemento, PDO::PARAM_STR);
						$cmd->bindParam(":pDtCadastro", $data, PDO::PARAM_STR);

						$cmd->execute();

						if ($cmd->errorCode() == Comuns::QUERY_OK)
						{
							return true;
						}
						else
						{
							$erro = $cmd->errorInfo();
							$this->msg_erro = $erro[2];
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Descrição do arquivo não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Caminho não informado]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Exame não enontrado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não encontrado]";
			return false;
		}
	}

	public function InsereMidiaExame($codcaso, $codexame, $caminho, $descricao, $complemento, $origem)
	{
		if (isset($codcaso))
		{
			if (isset($codexame))
			{
				if (isset($caminho))
				{
					if (isset($descricao))
					{
						$sql  = "insert into mescasoexamesitens(CodCaso, CodExame, Descricao, Valor, TipoItem, Complemento, DtCadastro) ";
						$sql .= "values(:pCodCaso, :pCodExame, :pDescricao, :pValor, :pTipoItem, :pComplemento, :pDtCadastro);";

						$data = date("Y-m-d H:i:s");

						$cnn = Conexao2::getInstance();

						$cmd = $cnn->prepare($sql);

						$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
						$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
						$cmd->bindParam(":pDescricao", $descricao, PDO::PARAM_STR);
						$cmd->bindParam(":pValor", $caminho, PDO::PARAM_STR);
						$cmd->bindParam(":pTipoItem", $origem, PDO::PARAM_STR);
						$cmd->bindParam(":pComplemento", $complemento, PDO::PARAM_STR);
						$cmd->bindParam(":pDtCadastro", $data, PDO::PARAM_STR);

						$cmd->execute();

						if ($cmd->errorCode() == Comuns::QUERY_OK)
						{
							return true;
						}
						else
						{
							$erro = $cmd->errorInfo();
							$this->msg_erro = $erro[2];
							return false;
						}
					}
					else
					{
						$this->msg_erro = "@lng[Descrição do arquivo não informado]";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Caminho não informado]";
					return false;
				}
			}
			else
			{
				$this->msg_erro = "@lng[Exame não enontrado]";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso de estudo não encontrado]";
			return false;
		}
	}
	
	public function AtualizaImagemExame($codcaso, $codexame, $coditem, $descricao, $complemento)
	{
		$sql  = "UPDATE mescasoexamesitens ";
		$sql .= "SET Descricao = :pDescricao, ";
		$sql .= "    Complemento = :pComplemento ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame AND CodItem = :pCodItem;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);

		$cmd->bindParam(":pDescricao", $descricao, PDO::PARAM_STR);
		$cmd->bindParam(":pComplemento", $complemento, PDO::PARAM_STR);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return true;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function CarregaImagemExame($codcaso, $codexame, $coditem)
	{
		$sql  = "SELECT  mescasoexamesitens.CodExame, "; 
		$sql .= "		mescasoexamesitens.CodItem, ";
		$sql .= "		mescasoexamesitens.Descricao, ";
		$sql .= "		mescasoexamesitens.Valor, ";
		$sql .= "		mescasoexamesitens.TipoItem, ";
		$sql .= "		mescasoexamesitens.Complemento, ";
		$sql .= "		mesmidia.Url, ";
		$sql .= "		mesmidia.Largura, ";
		$sql .= "		mesmidia.Altura ";
		$sql .= "FROM mescasoexamesitens ";
		$sql .= "INNER JOIN mesmidia ";
		$sql .= "		ON mesmidia.CodCaso = mescasoexamesitens.CodCaso ";
		$sql .= "	   AND mesmidia.CodMidia = mescasoexamesitens.Valor ";
		$sql .= "WHERE mescasoexamesitens.CodCaso = :pCodCaso ";
		$sql .= "  AND mescasoexamesitens.CodExame = :pCodExame ";
		$sql .= "  AND mescasoexamesitens.CodItem = :pCodItem;";
		
		/*
		$sql  = "SELECT Descricao, Valor, TipoItem, Complemento ";
		$sql .= "FROM mescasoexamesitens ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame AND CodItem = :pCodItem;";
		*/
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$item = $cmd->fetch(PDO::FETCH_OBJ);
				return $item;
			}
			else
			{
				$this->msg_erro = "@lng[Item não encontrado]";
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
	
	/**
	 * Apaga uma imagem do caso de estudo. Apaga no banco de dados e o arquivo físico
	 * @param $codcaso int : Código do caso de estudos
	 * @param $codexame int : Código do exame
	 * @param $coditem int : Código do item a ser excluido
	 * @return bool : verdadeiro caso sucesso e falso caso contrário
	 * */
	public function DetelaImagemExame($codcaso, $codexame, $coditem)
	{
		$cnn = Conexao2::getInstance();

		$sql  = "select Valor from mescasoexamesitens ";
		$sql .= "where CodCaso = :pCodCaso and CodExame = :pCodExame and CodItem = :pCodItem;";

		$cmdvalor = $cnn->prepare($sql);
		$cmdvalor->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmdvalor->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmdvalor->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);

		$cmdvalor->execute();

		$valor = $cmdvalor->fetchColumn();

		$sqldel  = "delete from mescasoexamesitens ";
		$sqldel .= "where CodCaso = :pCodCaso and CodExame = :pCodExame and CodItem = :pCodItem;";

		$cmd = $cnn->prepare($sqldel);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);

		$cmd->execute();

		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$u = new Upload();
			if ($u->DeletaArquivo($valor))
			{
				return true;
			}
			else
			{
				$this->msg_erro = $u->getStatus();
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

	public function DetelaDocumentoExame($codcaso, $codexame, $coditem)
	{
		$cnn = Conexao2::getInstance();

		$sql  = "select Valor from mescasoexamesitens ";
		$sql .= "where CodCaso = :pCodCaso and CodExame = :pCodExame and CodItem = :pCodItem;";

		$cmdvalor = $cnn->prepare($sql);
		$cmdvalor->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmdvalor->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmdvalor->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);

		$cmdvalor->execute();

		$valor = $cmdvalor->fetchColumn();

		$sqldel  = "delete from mescasoexamesitens ";
		$sqldel .= "where CodCaso = :pCodCaso and CodExame = :pCodExame and CodItem = :pCodItem;";

		$cmd = $cnn->prepare($sqldel);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);

		$cmd->execute();

		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$u = new Upload();
			if ($u->DeletaArquivo($valor))
			{
				return true;
			}
			else
			{
				$this->msg_erro = $u->getStatus();
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
	
	public function CarregaPerguntaNorteadora($codcaso)
	{
		$sql  = "SELECT TextoExames FROM mescaso ";
		$sql .= "WHERE Codigo = :pCodCaso;";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);

		$cmd->execute();

		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$per = $cmd->fetch(PDO::FETCH_OBJ);
				return (is_null($per->TextoExames) ? "" : $per->TextoExames);
			}
			else
			{
				return "";
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function SalvaPerguntaNorteadora($codcaso, $texto)
	{
		$sql  = "UPDATE mescaso set TextoExames = :pTexto ";
		$sql .= "WHERE Codigo = :pCodCaso;";

		$cnn = Conexao2::getInstance();

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pTexto", $texto, PDO::PARAM_STR);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);

		$cmd->execute();

		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return true;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ListaRelacoesExame($codcaso, $codexame)
	{
		if (Caso::ERespostaImediata($codcaso) == false)
		{
			$sql  = "select hip.CodHipotese, hip.Descricao ";
			$sql .= ",case when relexames.codexame is null then 0 else 1 end as TemRelacao ";
			$sql .= "from mescasohipotdiagn hip ";
			$sql .= "left outer join mesrelhipotesesexames relexames ";
			$sql .= "			 on relexames.CodCaso = hip.CodCaso ";
			$sql .= "			and relexames.CodHipotese = hip.CodHipotese ";
			$sql .= "			and relexames.CodExame = :pCodExame ";
			$sql .= "where hip.CodCaso = :pCodCaso;";

			$cnn = Conexao2::getInstance();

			$cmd = $cnn->prepare($sql);

			$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);

			$cmd->execute();

			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				if ($cmd->rowCount() > 0)
				{
					$cont = 1;
					while ($hipo = $cmd->fetch(PDO::FETCH_OBJ))
					{
						$checks .= '<input type="checkbox" name="chkHipXExames[]" id="chkHipXExames_' . $cont . '" value="' . base64_encode($hipo->CodHipotese) . '" ' . (($hipo->TemRelacao == 0) ? "": 'checked="checked"') . ' class="checkrels campo" />' . $hipo->Descricao . '<br />';
						$cont++;
					}
				}
				else
				{
					$checks = "@lng[Nenhuma hipótese diagnóstica cadastrada]";
				}
				return $checks;
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = $msg[2];
				return $this->msg_erro;
			}
		}
		else
		{
			$checks = "Este Caso de estudo é do tipo Feedback instantaneo e por isso não possui relações";
			return $checks;
		}
	}

	public function SalvaRelacoesExame(array $hipoteses)
	{
		$sqlDel  = "DELETE FROM mesrelhipotesesexames ";
		$sqlDel .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame;";

		$cnn = Conexao2::getInstance();

		$cmdDel = $cnn->prepare($sqlDel);
		$cmdDel->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdDel->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);

		$cmdDel->execute();

		if ($cmdDel->errorCode() == Comuns::QUERY_OK)
		{
			$sqlIns  = "insert into mesrelhipotesesexames(CodCaso, CodHipotese, CodExame) ";
			$sqlIns .= "values(:pCodCaso, :pCodHipotese, :pCodExame); ";

			foreach ($hipoteses as $hip)
			{
				$cmdIns = $cnn->prepare($sqlIns);
				$cmdIns->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
				$cmdIns->bindParam(":pCodHipotese", base64_decode($hip), PDO::PARAM_INT);

				$cmdIns->execute();

				if ($cmdIns->errorCode() == Comuns::QUERY_OK)
				{
					$cmdIns->closeCursor();
				}
				else
				{
					$msg = $cmdIns->errorInfo();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
			return true;
		}
		else
		{
			$msg = $cmdIns->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ListaValoresReferencia($codcaso, $codexame)
	{
		$sql  = "SELECT TemComponentes ";
		$sql .= "FROM mescasoexames ce ";
		$sql .= "INNER JOIN mestipoexame te ON te.codigo = ce.tipo ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		
		$cmd->execute();
		$temcomp = $cmd->fetchColumn();
		
		if ($temcomp == 1)
		{
			$sql  = "select  e.CodCaso ";
			$sql .= "		,e.CodExame ";
			$sql .= "		,c.codigo as CodComponente ";
			$sql .= "		,t.Codigo as TipoExame ";
			$sql .= "		,c.descricao as DesComponente ";
			$sql .= "		,v.Agrupador ";
			$sql .= "		,case when v.tipo = 1 then ";
			$sql .= "			concat(tvr.Descricao, ' ', v.valmin, ' e ', v.valmax) ";
			$sql .= "		 else ";
			$sql .= "			case when v.tipo = 4 then ";
			$sql .= "				v.valmin ";
			$sql .= "			else ";
			$sql .= "				concat(Simbolo, ' ', case when v.tipo = 2 then ValMin else ValMax end) ";
			$sql .= "			end ";
			$sql .= "		 end as Padrao ";
			$sql .= "		,i.Valor ";
			$sql .= "		,i.Complemento ";
			$sql .= "from mescasoexames e ";
			$sql .= "inner join mestipoexame t ";
			$sql .= "		 on t.codigo = e.tipo ";
			$sql .= "inner join mestipoexamecomponente c ";
			$sql .= "		 on c.codexame = t.codigo ";
			$sql .= "left join mestipoexamevalref v ";
			$sql .= "		 on v.codexame = c.codexame ";
			$sql .= "	    and v.codcomponente = c.codigo ";
			$sql .= "left join mestipovalorreferencia tvr ";
			$sql .= "		on tvr.Codigo = v.Tipo ";
			$sql .= "left join mescasoexamesitens i ";
			$sql .= "		on i.codcaso = e.codcaso ";
			$sql .= "	   and i.codexame = e.codexame ";
			$sql .= "	   and i.descricao = c.codigo ";
			$sql .= "	   and i.tipoitem = 'vlr' ";
			$sql .= "where e.codcaso = :pCodCaso ";
			$sql .= "  and e.codexame = :pCodExame;";
		}
		else
		{
			$sql  = "select distinct e.CodCaso ";
			$sql .= "				,e.CodExame ";
			$sql .= "				,0 as CodComponente ";
			$sql .= "				,t.Codigo as TipoExame ";
			$sql .= "				,t.Descricao as DesComponente ";
			$sql .= "				,v.Agrupador ";
			$sql .= "				,case when v.tipo = 1 then ";
			$sql .= "					concat(tvr.Descricao, ' ', v.valmin, ' e ', v.valmax) ";
			$sql .= "				 else ";
			$sql .= "					case when v.tipo = 4 then ";
			$sql .= "						v.valmin ";
			$sql .= "					else ";
			$sql .= "						concat(Simbolo, ' ', case when v.tipo = 2 then ValMin else ValMax end) ";
			$sql .= "					end ";
			$sql .= "				 end as Padrao ";
			$sql .= "				,i.Valor ";
			$sql .= "				,i.Complemento ";
			$sql .= "from mescasoexames e ";
			$sql .= "inner join mestipoexame t ";
			$sql .= "		 on t.Codigo = e.tipo ";
			$sql .= "left join mestipoexamevalref v ";
			$sql .= "		 on v.codexame = t.Codigo ";
			$sql .= "left join mestipovalorreferencia tvr ";
			$sql .= "		 on tvr.Codigo = v.Tipo ";
			$sql .= "left join mescasoexamesitens i ";
			$sql .= "		on i.codcaso = e.codcaso ";
			$sql .= "	   and i.codexame = e.codexame ";
			$sql .= "	   and i.tipoitem = 'vlr' ";
			$sql .= "where e.codcaso = :pCodCaso ";
			$sql .= "  and e.codexame = :pCodExame";
		}
		
		$cmd->closeCursor();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$casoatual = null;
				$exameatual = null;
				$componatual = null;
				
				$conteudo .= '<h4>@lng[Lançar resultados do exame]</h4>';
				$conteudo .= '<table>';
				$conteudo .= '  <tr>';
				$conteudo .= '    <th>@lng[Item]</th>';
				$conteudo .= '    <th>@lng[Resultado]</th>';
				$conteudo .= '    <th>@lng[Observação]</th>';
				$conteudo .= '    <th>&nbsp;</th>';
				$conteudo .= '  </tr>';

				while($rs = $cmd->fetch(PDO::FETCH_OBJ))
				{
					if ($componatual != $rs->CodComponente)
					{
						$conteudo .= '  <tr>';
						$conteudo .= '    <td style="text-align:right;">' . $rs->DesComponente . '</td>';
						$conteudo .= '    <td><input type="text" name="txtValRe_' . $rs->CodComponente . '" id="txtValRe_' . $rs->CodComponente . '" value="' . ((is_null($rs->Valor)) ? "" : $rs->Valor) . '" class="campo campocurto"></td>';
						$conteudo .= '    <td><input type="text" name="txtObsRe_' . $rs->CodComponente . '" id="txtValRe_' . $rs->CodComponente . '" value="' . ((is_null($rs->Complemento)) ? "" : $rs->Complemento) . '" class="campo campomedio"></td>';
						$conteudo .= '    <td><a href="javascript:void(0);" onclick="javascript:fntBuscaValores(\'' . base64_encode($rs->TipoExame) . '\', \'' . base64_encode($rs->CodComponente) . '\');">' . comuns::IMG_ACAO_VALORES_REF . '</a></td>';
						$conteudo .= '  </tr>';
						
						$componatual = $rs->CodComponente;
					}
				}
				$conteudo .= '</table>';
			}
			else
			{
				$conteudo = "";
			}
			
			return $conteudo;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	/**
	 * Retorna um Array de objetos contendo CodComponente, NomeComponente, Valor e complemento quando o exame tiver componentes; CodExame, Descricao, Valor e Complemento quando o exame não tive componentes
	 * */
	public function ListaRecordSetResultadosExamesLaboratoriais()
	{
		$cnn = Conexao2::getInstance();
		
		if ($this->temcomponentes == 1)
		{
			$sql  = "select ";
			$sql .= "	 componentes.Codigo as CodComponente ";
			$sql .= "	,componentes.Descricao as NomeComponente ";
			$sql .= "	,itens.Valor ";
			$sql .= "	,itens.Complemento ";
			$sql .= "from mescasoexames exames ";
			$sql .= "inner join mestipoexame tipo ";
			$sql .= "		on tipo.Codigo = exames.Tipo ";
			$sql .= "inner join mestipoexamecomponente componentes ";
			$sql .= "		on componentes.CodExame = tipo.Codigo ";
			$sql .= "left outer join mescasoexamesitens itens ";
			$sql .= "			 on itens.CodCaso = exames.CodCaso ";
			$sql .= "			and itens.CodExame = exames.CodExame ";
			$sql .= "			and itens.Descricao = componentes.Codigo ";
			$sql .= "			and itens.TipoItem = 'vlr' ";
			$sql .= "where exames.codcaso = :pCodCaso ";
			$sql .= "  and exames.codexame = :pCodExame ";
			$sql .= "  and itens.Valor is not null ";
			$sql .= "order by componentes.Ordem ";
		}
		else
		{
			$sql = "select ";
			$sql .= "	 exames.CodExame ";
			$sql .= "	,exames.Descricao ";
			$sql .= "	,itens.Valor ";
			$sql .= "	,itens.Complemento ";
			$sql .= "from mescasoexames exames ";
			$sql .= "inner join mestipoexame tipo ";
			$sql .= "		on tipo.Codigo = exames.Tipo ";
			$sql .= "	   and tipo.TemComponentes = 0 ";
			$sql .= "left outer join mescasoexamesitens itens ";
			$sql .= "			 on itens.CodCaso = exames.CodCaso ";
			$sql .= "			and itens.CodExame = exames.CodExame ";
			$sql .= "			and itens.Descricao = 0 ";
			$sql .= "			and itens.TipoItem = 'vlr' ";
			$sql .= "where exames.codcaso = :pCodCaso ";
			$sql .= "  and exames.codexame = :pCodExame ";
			$sql .= "  and itens.Valor is not null";
		}

		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
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
	
	public static function PodeLancarResultados($codexame)
	{
		$sql  = "select 1 as Tem from mescasoexames e ";
		$sql .= "inner join mestipoexame t ";
		$sql .= "		on t.codigo = e.tipo ";
		$sql .= "inner join mestipoexamevalref v ";
		$sql .= "		on v.codexame = t.Codigo ";
		$sql .= "where e.CodExame = :pCodExame;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodExame", $codexame, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function SalvaResultados($codcomponente, $resultado, $observacao)
	{
		$resultado = (($resultado == "") ? null : $resultado);
		$observacao = (($resultado == "") ? null : $observacao);
		
		$cnn = Conexao2::getInstance();
		
		$sqltem  = "SELECT CodItem FROM mescasoexamesitens ";
		$sqltem .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame AND Descricao = :pDescricao;";
		
		$cmdtem = $cnn->prepare($sqltem);
		$cmdtem->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdtem->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		$cmdtem->bindParam(":pDescricao", $codcomponente, PDO::PARAM_STR);
		
		$cmdtem->execute();
		
		if ($cmdtem->rowCount() > 0)
		{
			$coditem = $cmdtem->fetchColumn();
			
			if (! is_null($resultado))
			{
				$sql  = "UPDATE mescasoexamesitens ";
				$sql .= "SET Valor = :pValor, Complemento = :pComplemento ";
				$sql .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame AND CodItem = :pCodItem;";
	
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pValor", $resultado, PDO::PARAM_STR);
				$cmd->bindParam(":pComplemento", $observacao, PDO::PARAM_STR);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
				$cmd->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					return true;
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
			else
			{
				$sql  = "DELETE FROM mescasoexamesitens ";
				$sql .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame AND CodItem = :pCodItem;";
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
				$cmd->bindParam(":pCodItem", $coditem, PDO::PARAM_INT);
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					return true;
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
		}
		else
		{
			if (! is_null($resultado))
			{
				$sql  = "INSERT INTO mescasoexamesitens(CodCaso, CodExame, Descricao, Valor, TipoItem, Complemento, DtCadastro) ";
				$sql .= "VALUES(:pCodCaso, :pCodExame, :pDescricao, :pValor, :pTipoItem, :pComplemento, :pDtCadastro);";
	
				$agora = date('Y-m-d H:i:s');
				$tipo = "vlr";
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
				$cmd->bindParam(":pValor", $resultado, PDO::PARAM_STR);
				$cmd->bindParam(":pComplemento", $observacao, PDO::PARAM_STR);
				$cmd->bindParam(":pDescricao", $codcomponente, PDO::PARAM_STR);
				$cmd->bindParam(":pTipoItem", $tipo, PDO::PARAM_STR);
				$cmd->bindParam(":pDtCadastro", $agora, PDO::PARAM_STR);
				$cmd->execute();

				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					return true;
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
			else
			{
				return  true;
			}
		}
	}

	public function SalvaLaudo()
	{
		$sql  = "UPDATE mescasoexames ";
		$sql .= "SET Laudo = :pLaudo ";
		$sql .= "WHERE CodCaso = :pCodCaso AND CodExame = :pCodExame;";
		
		$cnn = Conexao2::getInstance();
		
		$this->laudo = (($this->laudo == "") ? null : $this->laudo);
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pLaudo", $this->laudo, PDO::PARAM_STR);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $this->codexame, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return true;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function getNExames()
	{
		$sql  = "select case when count(codexame) is null then 0 else count(codexame) end as Exames ";
		$sql .= "from mescasoexames where CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$ret = $cmd->fetchColumn();
			return $ret;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ProcessarExames($interno = "N")
	{
		if ((isset($this->codcaso)) && ($this->codcaso > 0))
		{
			// Verifica se o exame já não foi processado
			$sql  = "select ExamesProcessados from mescaso ";
			$sql .= "where Codigo = :pCodCaso";
			
			$cnn = Conexao2::getInstance();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				$status = $cmd->fetchColumn();
				
				if (($status == 0) || ($status == 2))
				{
					// 0 é não processado e 2 é Reprocessado
					$cmd->closeCursor();
					
					// Busca a combinação de agrupamentos para a exibição dos resultados dos exames
					$sql  = "SELECT CodCaso, NumBateria, AgrupaComABateria, TipoReg, Exame ";
					$sql .= "FROM( ";
					$sql .= "	SELECT DISTINCT CodCaso ";
					$sql .= "		, NumBateria ";
					$sql .= "		, AgrupaComABateria ";
					$sql .= "		, 2 as TipoReg ";
					$sql .= "		, CASE WHEN AgrupaComABateria = 0 then CodExame else -1 end as Exame ";
					$sql .= "	FROM mescasoexames ";
					$sql .= "	WHERE codcaso = :pCodCaso ";
					$sql .= "	UNION ";
					$sql .= "	SELECT DISTINCT CodCaso, NumBateria, 0 as AgrupaComABateria, 1 as TipoReg, -1 as Exame ";
					$sql .= "	FROM mescasoexames ";
					$sql .= "	WHERE CodCaso = :pCodCaso AND MostraQuando = 0 ";
					$sql .= "	) dados ";
					$sql .= "ORDER BY NumBateria, TipoReg";
					
					$cmd = $cnn->prepare($sql);
					$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
					
					$cmd->execute();
					
					if ($cmd->errorCode() == Comuns::QUERY_OK)
					{
						if ($cmd->rowCount() > 0)
						{
							if ($interno != "S")
								Log::RegistraLog("Processou os exames do caso de estudo " . $this->codcaso);
							
							$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
							$cmd->closeCursor();
							
							$sql  = "INSERT INTO mescasoexameschaves(CodCaso, NumBateria, Agrupado, CodExame, TipoRegistro, Chave) ";
							$sql .= "VALUES(:pCodCaso, :pNumBateria, :pAgrupado, :pCodExame, :pTipoReg, :pChave);";
							
							$cnn->beginTransaction();
							foreach ($rs as $item)
							{
								$chave = Comuns::CodigoUnico();
								
								$cmd = $cnn->prepare($sql);
								$cmd->bindParam(":pCodCaso", $item->CodCaso, PDO::PARAM_INT);
								$cmd->bindParam(":pNumBateria", $item->NumBateria, PDO::PARAM_INT);
								$cmd->bindParam(":pAgrupado", $item->AgrupaComABateria, PDO::PARAM_INT);
								$cmd->bindParam(":pCodExame", $item->Exame, PDO::PARAM_INT);
								$cmd->bindParam(":pTipoReg", $item->TipoReg, PDO::PARAM_INT);
								$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
								
								$cmd->execute();
								
								if ($cmd->errorCode() == Comuns::QUERY_OK)
								{
									$cmd->closeCursor();
								}
								else
								{
									$msg = $cmd->errorInfo();
									$this->msg_erro = $msg[2] . " linha 1304";
									$cnn->rollBack();
									return false;
								}
							}
							
							$sql = "UPDATE mescaso SET ExamesProcessados = 1 WHERE Codigo = :pCodCaso;";
							
							$cmd = $cnn->prepare($sql);
							$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
							
							$cmd->execute();
							
							if ($cmd->errorCode() == Comuns::QUERY_OK)
							{
								$cnn->commit();
								return true;
							}
							else
							{
								$msg = $cmd->errorInfo();
								$this->msg_erro = $msg[2] . " linha 1325";
								$cnn->rollBack();
								return false;
							}
						}
						else
						{
							$this->msg_erro = "@lng[Nenhum exame encontrado para ser processado]";
							return false;
						}
					}
					else
					{
						$msg = $cmd->errorInfo();
						$this->msg_erro = $msg[2] . " linha 1339";
						return false;
					}
				}
				else
				{
					$this->msg_erro = "@lng[Os exames deste caso já foram processados. Se deseja atualiza-los faça um reprocessamento e não um processamento]";
					return false;
				}
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = $msg[2] . " linha 1352";
				return false;
			}
		}
		else
		{
			$this->msg_erro = "@lng[Caso não informado]";
			return false;
		}
	}

	public function ReprocessarExames()
	{
		Log::RegistraLog("Reprocessou os exames do caso de estudo " . $this->codcaso);
		
		// deletar as ordenações já criadas com os exames
		$sql  = "DELETE FROM mescasoordenacao ";
		$sql .= "WHERE codcaso = :pCodCaso AND Prefixo = 'EXA' ";
		$sql .= "AND Chave IN(SELECT Chave FROM mescasoexameschaves WHERE CodCaso = :pCodCaso); ";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$cmd->closeCursor();
			
			$sql = "DELETE FROM mescasoexameschaves WHERE CodCaso = :pCodCaso;";
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				$cmd->closeCursor();
				
				$sql = "UPDATE mescaso SET ExamesProcessados = 2 WHERE Codigo = :pCodCaso;";
				
				$cmd = $cnn->prepare($sql);
				$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				
				$cmd->execute();
				
				if ($cmd->errorCode() == Comuns::QUERY_OK)
				{
					return $this->ProcessarExames("S");
				}
				else
				{
					$msg = $cmd->errorInfo();
					$this->msg_erro = $msg[2];
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
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
		// deletar as chaves já criadas
	}
	
	public static function ExamesJaProcessado($codcaso)
	{
		$sql  = "SELECT ExamesProcessados FROM mescaso WHERE Codigo = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return $cmd->fetchColumn();
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ListaRecordSetBaterias($codcaso)
	{
		$sql  = "SELECT DISTINCT NumBateria ";
		$sql .= "FROM mescasoexames WHERE codcaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return $cmd->fetchAll(PDO::FETCH_OBJ);
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ListaRecordSetConteudosVinculados($codcaso, $chave)
	{
		$sql  = "select distinct excont.CodConteudo, cont.Descricao, cont.Texto ";
		$sql .= "from mescasoexamesconteudos excont ";
		$sql .= "inner join mescasoconteudo cont ";
		$sql .= "		on cont.CodCaso = excont.CodCaso ";
		$sql .= "	   and cont.CodConteudo = excont.CodConteudo ";
		$sql .= "where excont.CodCaso = :pCodCaso ";
		$sql .= "  and NumBateria = (select NumBateria ";
		$sql .= "					 from mescasoexameschaves ";
		$sql .= "					 where chave = :pChave);";

		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
			$cmd->closeCursor();
			return $rs;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function ListaExamesDaBateria($codcaso, $bateria)
	{
		$sql  = "SELECT CodExame, Descricao ";
		$sql .= "FROM mescasoexames ";
		$sql .= "WHERE codcaso = :pCodCaso AND NumBateria = :pNumBateria;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pNumBateria", $bateria, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			return $cmd->fetchAll(PDO::FETCH_OBJ);
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ListaConteudosVinculados($codcaso)
	{
		$sql  = "select distinct excont.CodCaso ";
		$sql .= "		,excont.NumBateria ";
		$sql .= "		,excont.CodExame ";
		$sql .= "		,case when excont.CodExame <> -1 then ex.Descricao else 'Nenhum expecífico' end as Exame ";
		$sql .= "		,excont.CodConteudo ";
		$sql .= "		,cont.Descricao ";
		$sql .= "from mescasoexamesconteudos excont ";
		$sql .= "inner join mescasoexames ex ";
		$sql .= "		on ex.CodCaso = excont.CodCaso ";
		//$sql .= "	   and ex.NumBateria = excont.NumBateria ";
		$sql .= "	   and ex.CodExame = case when excont.CodExame <> -1 then excont.codexame else ex.CodExame end ";
		$sql .= "inner join mescasoconteudo cont ";
		$sql .= "		on cont.CodCaso = excont.CodCaso ";
		$sql .= "	   and cont.CodConteudo = excont.CodConteudo ";
		$sql .= "where excont.CodCaso = :pCodCaso;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$ret = Comuns::TopoTabelaListagem(
					 "Conteudos já vinculados aos exames",
					 "tabContVinc",
					 array(/*"Núm. Bateria", */"Exame", "Conteúdo", "Ações")
				);
				
				while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$ret .= '<tr>';
					//$ret .= '<td>' . $linha->NumBateria . '</td>';
					$ret .= '<td>' . $linha->Exame . '</td>';
					$ret .= '<td>' . $linha->Descricao . '</td>';
					$ret .= '<td><a href="javascript:void(0);" onclick="fntDeletaConteudosExames(\'C' . base64_encode($linha->CodConteudo) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a></td>';
					$ret = str_replace("##id##", "", $ret);
					$ret .= '</tr>';
				}
				
				$ret .= "</tbody></table>";
			}
			else
			{
				$ret = "@lng[Nenhum documento criado até agora]";
			}
			
			return $ret;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ListaMidiasVinculados($codcaso)
	{
		$sql  = "select distinct exmidia.CodCaso ";
		$sql .= "		,exmidia.NumBateria ";
		$sql .= "		,exmidia.CodExame ";
		$sql .= "		,case when exmidia.CodExame <> -1 then ex.Descricao else 'Nenhum expecífico' end as Exame ";
		$sql .= "		,exmidia.CodMidia ";
		$sql .= "		,midia.Descricao ";
		$sql .= "from mescasoexamesmidia exmidia ";
		$sql .= "inner join mescasoexames ex ";
		$sql .= "		on ex.CodCaso = exmidia.CodCaso ";
		//$sql .= "	   and ex.NumBateria = exmidia.NumBateria ";
		$sql .= "	   and ex.CodExame = case when exmidia.CodExame <> -1 then exmidia.codexame else ex.CodExame end ";
		$sql .= "inner join mesmidia midia ";
		$sql .= "		on midia.CodCaso = exmidia.CodCaso ";
		$sql .= "	   and midia.CodMidia = exmidia.CodMidia ";
		$sql .= "where exmidia.CodCaso = :pCodCaso;";

		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$ret = Comuns::TopoTabelaListagem(
					 "Mídias já vinculadas aos exames",
					 "tabMidVinc",
					 array(/*"Núm. Bateria", */"Exame", "Mídia", "Ações")
				);
				
				while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$ret .= '<tr>';
					//$ret .= '<td>' . $linha->NumBateria . '</td>';
					$ret .= '<td>' . $linha->Exame . '</td>';
					$ret .= '<td>' . $linha->Descricao . '</td>';
					$ret .= '<td><a href="javascript:void(0);" onclick="fntDeletaConteudosExames(\'M' . base64_encode($linha->CodMidia) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a></td>';
					$ret = str_replace("##id##", "", $ret);
					$ret .= '</tr>';
				}
				
				$ret .= "</tbody></table>";
			}
			else
			{
				$ret = "@lng[Nenhuma mídia criada até o momento]";
			}
			
			return $ret;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function SalvaVinculoConteudoExame($codcaso, $numBateria, $codExame, $codConteudo)
	{
		$sql  = "INSERT INTO mescasoexamesconteudos(CodCaso, NumBateria, CodExame, CodConteudo) ";
		$sql .= "VALUES(:pCodCaso, :pNumBateria, :pCodExame, :pCodConteudo);";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pNumBateria", $numBateria, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codExame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodConteudo", $codConteudo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$sql  = "UPDATE mescasoconteudo SET NaoExibeNaMontagem = 1 ";
			$sql .= "WHERE CodCaso = :pCodCaso AND CodConteudo = :pCodConteudo;";
			
			$cmd->closeCursor();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodConteudo", $codConteudo, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				return true;
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = "@lng[O conteúdo foi vinculado mas o seguinte erro ocorreu]: " . $msg[2] . ". Linha 1633";
				return false;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2] . ". Linha 1642";
			return false;
		}
	}
	
	public function SalvaVinculoMidiaExame($codcaso, $numBateria, $codExame, $codMidia)
	{
		$sql  = "INSERT INTO mescasoexamesmidia(CodCaso, NumBateria, CodExame, CodMidia) ";
		$sql .= "VALUES(:pCodCaso, :pNumBateria, :pCodExame, :pCodMidia);";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pNumBateria", $numBateria, PDO::PARAM_INT);
		$cmd->bindParam(":pCodExame", $codExame, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMidia", $codMidia, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			/*
			$sql  = "UPDATE mescasoconteudo SET NaoExibeNaMontagem = 1 ";
			$sql .= "WHERE CodCaso = :pCodCaso AND CodConteudo = :pCodConteudo;";
			
			$cmd->closeCursor();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodConteudo", $codConteudo, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
			*/
				return true;
			/*
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = "O conteúdo foi vinculado mas o seguinte erro ocorreu: " . $msg[2] . ". Linha 1633";
				return false;
			}
			*/
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2] . ". Linha 1642";
			return false;
		}
	}
	
	public function DesvincularConteudoExame($codcaso, $numBateria, $codConteudo)
	{
		$sql  = "DELETE FROM mescasoexamesconteudos ";
		$sql .= "WHERE CodCaso = :pCodCaso AND NumBateria = :pNumBateria AND CodConteudo = :pCodConteudo;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pNumBateria", $numBateria, PDO::PARAM_INT);
		$cmd->bindParam(":pCodConteudo", $codConteudo, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$sql  = "UPDATE mescasoconteudo SET NaoExibeNaMontagem = 0 ";
			$sql .= "WHERE CodCaso = :pCodCaso AND CodConteudo = :pCodConteudo;";
			
			$cmd->closeCursor();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodConteudo", $codConteudo, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
				return true;
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = "@lng[O conteúdo foi desvinculado mas o seguinte erro ocorreu]: " . $msg[2] . ". Linha 1679";
				return false;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2] . ". Linha 1686";
			return false;
		}
	}
	
	public function DesvincularMidiaExame($codcaso, $numBateria, $codMidia)
	{
		$sql  = "DELETE FROM mescasoexamesmidia ";
		$sql .= "WHERE CodCaso = :pCodCaso AND NumBateria = :pNumBateria AND CodMidia = :pCodMidia;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pNumBateria", $numBateria, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMidia", $codMidia, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			/*
			$sql  = "UPDATE mescasoconteudo SET NaoExibeNaMontagem = 0 ";
			$sql .= "WHERE CodCaso = :pCodCaso AND CodConteudo = :pCodConteudo;";
			
			$cmd->closeCursor();
			
			$cmd = $cnn->prepare($sql);
			$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
			$cmd->bindParam(":pCodConteudo", $codConteudo, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() == Comuns::QUERY_OK)
			{
			*/
				return true;
			/*
			}
			else
			{
				$msg = $cmd->errorInfo();
				$this->msg_erro = "O conteúdo foi desvinculado mas o seguinte erro ocorreu: " . $msg[2] . ". Linha 1679";
				return false;
			}
			*/
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2] . ". Linha 1686";
			return false;
		}
	}
	
}

?>