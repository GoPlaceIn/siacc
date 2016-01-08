<?php
//--utf8_encode --
session_start();

include_once 'cls/conteudo.class.php';
include_once 'cls/midia.class.php';

include_once 'cls/components/hashtable.class.php';
include_once 'inc/comuns.inc.php';

class Montagem
{
	private $codcaso;
	private $nummontagem;
	private $msg_erro;
	
	public function getCodCaso()
	{
		return $this->codcaso;
	}
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function setCodCaso($p_codcaso)
	{
		$this->codcaso = $p_codcaso;
	}
	
	public function __construct()
	{
		$this->codcaso = 0;
		$this->nummontagem = 1;
		$this->msg_erro = "";
	}
	
	public function ExisteArvore()
	{
		$sql  = "SELECT Chave FROM mescasomontagem ";
		$sql .= "WHERE Organizador = 'raiz' AND CodCaso = :pCodCaso";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$chave = $cmd->fetchColumn();
				return $chave;
			}
			else
			{
				return null;
			}
		}
	}
	
	public function AddRais()
	{
		$sqlins = "INSERT INTO mescasomontagem(CodCaso, CodMontagem, Chave, TipoConteudo, Ordem, ChavePai, Organizador, ContReferencia) ";
		$sqlins .= "values(:pCodCaso, :pCodMontagem, :pChave, :pTipoConteudo, :pOrdem, :pChavePai, :pOrganizador, :pContReferencia)";
		
		$codunico = Comuns::CodigoUnico();
		$ordem = 0;
		$referencia = 0;
		$tipo = "raiz";
		$chavepai = null;
		
		$cnn = Conexao2::getInstance();
		
		$cmdins = $cnn->prepare($sqlins);
		$cmdins->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdins->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmdins->bindParam(":pChave", $codunico, PDO::PARAM_STR);
		$cmdins->bindParam(":pTipoConteudo", $tipo, PDO::PARAM_STR);
		$cmdins->bindParam(":pOrdem", $ordem, PDO::PARAM_INT);
		$cmdins->bindParam(":pChavePai", $chavepai, PDO::PARAM_STR);
		$cmdins->bindParam(":pOrganizador", $tipo, PDO::PARAM_STR);
		$cmdins->bindParam(":pContReferencia", $referencia, PDO::PARAM_INT);
		
		$cmdins->execute();
		
		if ($cmdins->errorCode() == Comuns::QUERY_OK)
		{
			return $codunico;
		}
		else
		{
			$msg = $cmdins->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function AddItem($sTCo, $iOrd, $sPai, $iRef, $sOrg)
	{
		/*
		$sqlins = "INSERT INTO mescasomontagem(CodCaso, CodMontagem, Chave, TipoConteudo, Ordem, ChavePai, Organizador, ContReferencia) ";
		$sqlins .= "values(:pCodCaso, :pCodMontagem, :pChave, :pTipoConteudo, :pOrdem, :pChavePai, :pOrganizador, :pContReferencia)";
		*/
		
		$sqlins  = "INSERT INTO mescasomontagem(CodCaso, CodMontagem, Chave, TipoConteudo, Ordem, ChavePai, Organizador, ContReferencia, ValorOpt) ";
		$sqlins .= "SELECT :pCodCaso, ";
		$sqlins .= "	   :pCodMontagem, ";
		$sqlins .= "	   :pChave, ";
		$sqlins .= "	   :pTipoConteudo, ";
		$sqlins .= "	   :pOrdem, ";
		$sqlins .= "	   :pChavePai, ";
		$sqlins .= "	   :pOrganizador, ";
		$sqlins .= "	   :pContReferencia, ";
		$sqlins .= "	   CASE WHEN :pOrganizador = 'cont' AND :pTipoConteudo NOT IN('an','aninv','exfis') THEN ";
		$sqlins .= "	   		IFNULL(((SELECT MAX(ValorOpt) FROM mescasomontagem ";
		$sqlins .= "	   				 WHERE CodCaso = :pCodCaso AND CodMontagem = :pCodMontagem AND ChavePai = :pChavePai) * 2), 1) ";
		$sqlins .= "	   ELSE 0 END ";
		
		$codunico = Comuns::CodigoUnico();
		
		$cnn = Conexao2::getInstance();
		
		$cmdins = $cnn->prepare($sqlins);
		$cmdins->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdins->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmdins->bindParam(":pChave", $codunico, PDO::PARAM_STR);
		$cmdins->bindParam(":pTipoConteudo", $sTCo, PDO::PARAM_STR);
		$cmdins->bindParam(":pOrdem", $iOrd, PDO::PARAM_INT);
		$cmdins->bindParam(":pChavePai", $sPai, PDO::PARAM_STR);
		$cmdins->bindParam(":pOrganizador", $sOrg, PDO::PARAM_STR);
		$cmdins->bindParam(":pContReferencia", $iRef, PDO::PARAM_INT);
		
		$cmdins->execute();
		
		if ($cmdins->errorCode() == Comuns::QUERY_OK)
		{
			return $sOrg . '_'. $sTCo . '_' . $iRef . '_' . $codunico;
		}
		else
		{
			$msg = $cmdins->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function ExcluiItem($item)
	{
		/* Verifica se o conteúdo já não teve acesso por Alunos (grupos diferente de Administradores e Especialistas) */
		$sqlpode  = "SELECT 1 AS Tem ";
		$sqlpode .= "FROM mesresolucaovisconteudo ";
		$sqlpode .= "INNER JOIN mesacessousuario ";
		$sqlpode .= "		 ON mesresolucaovisconteudo.CodAcesso = mesacessousuario.NumAcesso ";
		$sqlpode .= "WHERE mesresolucaovisconteudo.CodCaso = :pCodCaso ";
		$sqlpode .= "  AND mesresolucaovisconteudo.CodMontagem = 1 ";
		$sqlpode .= "  AND mesresolucaovisconteudo.CodChave = :pChave ";
		$sqlpode .= "  AND mesacessousuario.CodUsuario NOT IN( ";
		$sqlpode .= "										 SELECT DISTINCT CodUsuario ";
		$sqlpode .= "										 FROM mesusuariogrupo ";
		$sqlpode .= "										 WHERE CodGrupoUsuario IN(1, 4) ";
		$sqlpode .= "										 );";
		
		$cnn = Conexao2::getInstance();
		
		$cmdpode = $cnn->prepare($sqlpode);
		$cmdpode->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmdpode->bindParam(":pChave", $item, PDO::PARAM_STR);
		$cmdpode->execute();
		
		if ($cmdpode->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmdpode->rowCount() == 0)
			{
				/* Verifica se o item atual tem filhos para excluí-los primeiro */
				$sqlfilhos = "SELECT Chave FROM mescasomontagem where CodCaso = :pCodCaso AND CodMontagem = 1 AND ChavePai = :pChave;";
				$cmdfilhos = $cnn->prepare($sqlfilhos);
				$cmdfilhos->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
				$cmdfilhos->bindParam(":pChave", $item, PDO::PARAM_STR);
				$cmdfilhos->execute();
				
				if ($cmdfilhos->errorCode() == Comuns::QUERY_OK)
				{
					if ($cmdfilhos->rowCount() > 0)
					{
						Log::RegistraLog("DEBUG - Encontrou filhos. Vai chamar a função novamente");
						self::ExcluiItem($cmdfilhos->fetchColumn());
					}
					
					$sqlinfo  = "SELECT ChavePai, Ordem FROM mescasomontagem ";
					$sqlinfo .= "WHERE CodCaso = :pCodCaso AND CodMontagem = 1 AND Chave = :pChave;";
					
					$cmdinfo = $cnn->prepare($sqlinfo);
					$cmdinfo->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
					$cmdinfo->bindParam(":pChave", $item, PDO::PARAM_STR);
					$cmdinfo->execute();
					
					if ($cmdinfo->errorCode() == Comuns::QUERY_OK)
					{
						if ($cmdinfo->rowCount() > 0)
						{
							$infos = $cmdinfo->fetch(PDO::FETCH_OBJ);
						}
						else 
						{
							$infos = false;
						}
						
						$cnn->beginTransaction();
						
						/* Transformar isso em recursividade */
						/* Exclui as configurações dos itens */
						$sqldelconf  = "delete from mescasomontagemvalconfigs ";
						$sqldelconf .= "where CodCaso = :pCodCaso ";
						$sqldelconf .= "  and codmontagem = 1 ";
						$sqldelconf .= "  and Chave IN( ";
						$sqldelconf .= "			select Chave "; 
						$sqldelconf .= "			from mescasomontagem m ";
						$sqldelconf .= "			where m.CodCaso = :pCodCaso ";
						$sqldelconf .= "			  and m.CodMontagem = 1 ";
						$sqldelconf .= "			  and (m.Chave = :pChave or m.ChavePai = :pChave) ";
						$sqldelconf .= "			);";
						
						$cmddelconf = $cnn->prepare($sqldelconf);
						$cmddelconf->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmddelconf->bindParam(":pChave", $item, PDO::PARAM_STR);
						$cmddelconf->execute();
						
						/* Transformar isso em recursividade */
						/* Exclui os anexos dos itens */
						$sqldelanexos  = "delete from mescasomontagemanexos ";
						$sqldelanexos .= "where CodCaso = :pCodCaso ";
						$sqldelanexos .= "  and codmontagem = 1 ";
						$sqldelanexos .= "  and CodChave IN( ";
						$sqldelanexos .= "			select Chave "; 
						$sqldelanexos .= "			from mescasomontagem m ";
						$sqldelanexos .= "			where m.CodCaso = :pCodCaso ";
						$sqldelanexos .= "			  and m.CodMontagem = 1 ";
						$sqldelanexos .= "			  and (m.Chave = :pChave or m.ChavePai = :pChave) ";
						$sqldelanexos .= "			);";
	
						$cmddelanexos = $cnn->prepare($sqldelanexos);
						$cmddelanexos->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmddelanexos->bindParam(":pChave", $item, PDO::PARAM_STR);
						$cmddelanexos->execute();
						
						/* Transformar isso em recursividade */
						/* Exclui os desvios condicionais dos itens */
						$sqldelsaltos  = "delete from mescasomontagemsaltos ";
						$sqldelsaltos .= "where CodCaso = :pCodCaso ";
						$sqldelsaltos .= "  and codmontagem = 1 ";
						$sqldelsaltos .= "  and CodAtual IN( ";
						$sqldelsaltos .= "			select Chave ";
						$sqldelsaltos .= "			from mescasomontagem m ";
						$sqldelsaltos .= "			where m.CodCaso = :pCodCaso ";
						$sqldelsaltos .= "			  and m.CodMontagem = 1 ";
						$sqldelsaltos .= "			  and (m.Chave = :pChave or m.ChavePai = :pChave) ";
						$sqldelsaltos .= "			);";
						
						$cmddelsaltos = $cnn->prepare($sqldelsaltos);
						$cmddelsaltos->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmddelsaltos->bindParam(":pChave", $item, PDO::PARAM_STR);
						$cmddelsaltos->execute();
						
						/* Exclui o item da montagem propriamente dito */
						$sqldel  = "DELETE FROM mescasomontagem ";
						$sqldel .= "WHERE CodCaso = :pCodCaso AND CodMontagem = 1 ";
						$sqldel .= "  AND (Chave = :pChave OR ChavePai = :pChave);";
						
						$cmddel = $cnn->prepare($sqldel);
						$cmddel->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
						$cmddel->bindParam(":pChave", $item, PDO::PARAM_STR);
						$cmddel->execute();
						
						if ($cmddel->errorCode() == Comuns::QUERY_OK)
						{
							if ($infos !== false)
							{
								$sqlupd  = "UPDATE mescasomontagem ";
								$sqlupd .= "SET Ordem = Ordem - 1 ";
								$sqlupd .= "WHERE CodCaso = :pCodCaso ";
								$sqlupd .= "  AND CodMontagem = 1 ";
								$sqlupd .= "  AND ChavePai = :pChavePai ";
								$sqlupd .= "  AND Ordem > :pOrdemDel;";
								
								$cmdupd = $cnn->prepare($sqlupd);
								$cmdupd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
								$cmdupd->bindParam(":pChavePai", $infos->ChavePai, PDO::PARAM_STR);
								$cmdupd->bindParam(":pOrdemDel", $infos->Ordem, PDO::PARAM_INT);
								$cmdupd->execute();
								
								if ($cmdupd->errorCode() == Comuns::QUERY_OK)
								{
									$cnn->commit();
									return true;
								}
								else
								{
									$msg = $cmdupd->errorInfo();
									$this->msg_erro = $msg[2];
									$cnn->rollBack();
									return false;
								}
							}
							else
							{
								$cnn->commit();
								Log::RegistraLog("Excluiu o item " . $item . " da montagem do caso");
								return true;
							}
						}
						else
						{
							$msg = $cmddel->errorInfo();
							$this->msg_erro = $msg[2];
							$cnn->rollBack();
							return false;
						}
					}
					else
					{
						$msg = $cmdinfo->errorInfo();
						$this->msg_erro = $msg[2];
						return false;
					}
				}
			}
			else
			{
				$this->msg_erro = "@lng[Este item já foi acessado por alunos. Não é possível exclui-lo.]";
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
	
	public function ReordenaItem($item, $itempai, $posAnt, $posNova)
	{
		$posNovaOrig = $posNova;
		
		if ($posNova < $posAnt)
		{
			$posAnt = $posAnt - 1;
			
			$sql  = "UPDATE mescasomontagem ";
			$sql .= "SET Ordem = Ordem + 1 ";
			$sql .= "WHERE CodCaso = :pCodCaso ";
			$sql .= "  AND CodMontagem = 1 ";
			$sql .= "  AND ChavePai = :pChavePai ";
			$sql .= "  AND Chave <> :pChaveItem ";
			$sql .= "  AND Ordem BETWEEN :pPosNova AND :pPosAnt;";
		}
		else if ($posNova > $posAnt)
		{
			$posAnt = $posAnt + 1;
			
			$sql  = "UPDATE mescasomontagem ";
			$sql .= "SET Ordem = Ordem - 1 ";
			$sql .= "WHERE CodCaso = :pCodCaso ";
			$sql .= "  AND CodMontagem = 1 ";
			$sql .= "  AND ChavePai = :pChavePai ";
			$sql .= "  AND Chave <> :pChaveItem ";
			$sql .= "  AND Ordem BETWEEN :pPosAnt AND :pPosNova;";
		}
		
		$cnn = Conexao2::getInstance();
		$cnn->beginTransaction();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChavePai", $itempai, PDO::PARAM_STR);
		$cmd->bindParam(":pChaveItem", $item, PDO::PARAM_STR);
		$cmd->bindParam(":pPosNova", $posNova, PDO::PARAM_INT);
		$cmd->bindParam(":pPosAnt", $posAnt, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$sqlfin  = "UPDATE mescasomontagem ";
			$sqlfin .= "SET Ordem = :pOrdem ";
			$sqlfin .= "WHERE CodCaso = :pCodCaso ";
			$sqlfin .= "  AND CodMontagem = 1 ";
			$sqlfin .= "  AND Chave = :pChaveItem ";
			$sqlfin .= "  AND ChavePai = :pChavePai; ";
			
			$cmdfin = $cnn->prepare($sqlfin);
			$cmdfin->bindParam(":pOrdem", $posNovaOrig, PDO::PARAM_INT);
			$cmdfin->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			$cmdfin->bindParam(":pChaveItem", $item, PDO::PARAM_STR);
			$cmdfin->bindParam(":pChavePai", $itempai, PDO::PARAM_STR);
			$cmdfin->execute();
			
			if ($cmdfin->errorCode() == Comuns::QUERY_OK)
			{
				$cnn->commit();
				return true;
			}
			else
			{
				$msg = $cmdfin->errorInfo();
				$this->msg_erro = $msg[2] . "erro 2";
				$cnn->rollBack();
				return false;
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2] . "erro 1";
			$cnn->rollBack();
			return false;
		}
	}
	
	public function SalvaParamItem($item, $param, $valor)
	{
		$sql  = "SELECT 1 AS Tem ";
		$sql .= "FROM mescasomontagemvalconfigs ";
		$sql .= "WHERE CodCaso = :pCodCaso ";
		$sql .= "  AND CodMontagem = 1 ";
		$sql .= "  AND Chave = :pChave ";
		$sql .= "  AND CodConfig = :pCodConfig; ";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $item, PDO::PARAM_STR);
		$cmd->bindParam(":pCodConfig", $param, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$sqlact  = "UPDATE mescasomontagemvalconfigs ";
				$sqlact .= "SET Valor = :pValor ";
				$sqlact .= "WHERE CodCaso = :pCodCaso ";
				$sqlact .= "  AND CodMontagem = 1 ";
				$sqlact .= "  AND Chave = :pChave ";
				$sqlact .= "  AND CodConfig = :pCodConfig;";
			}
			else
			{
				$sqlact  = "INSERT INTO mescasomontagemvalconfigs(CodCaso, CodMontagem, Chave, CodConfig, Valor) ";
				$sqlact .= "VALUES(:pCodCaso, 1, :pChave, :pCodConfig, :pValor);";
			}
			
			$cmdact = $cnn->prepare($sqlact);
			$cmdact->bindParam(":pValor", $valor, PDO::PARAM_STR);
			$cmdact->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
			$cmdact->bindParam(":pChave", $item, PDO::PARAM_STR);
			$cmdact->bindParam(":pCodConfig", $param, PDO::PARAM_INT);
			
			$cmdact->execute();
			
			if ($cmdact->errorCode() == Comuns::QUERY_OK)
			{
				return true;
			}
			else
			{
				$msg = $cmdact->errorInfo();
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
	
	public function RetornaArvoreLista()
	{
		$sql  = "SELECT vw.CodCaso, vw.CodMontagem, vw.Chave, vw.TipoConteudo, vw.Conteudo, vw.Ordem";
		$sql .= ", CASE WHEN vw.ChavePai IS NULL THEN 0 ELSE vw.ChavePai END AS ChavePai";
		$sql .= ", vw.Organizador, vw.ContReferencia ";
		$sql .= ", CASE WHEN vwdesc.DescricaoFilhos IS NULL THEN '' ELSE vwdesc.DescricaoFilhos END AS DescricaoFilhos ";
		$sql .= "FROM vwarvorecaso vw ";
		$sql .= "LEFT OUTER JOIN vwarvoredescextra vwdesc ";
		$sql .= " ON vwdesc.CodCaso = vw.CodCaso ";
		$sql .= " AND vwdesc.CodMontagem = vw.CodMontagem ";
		$sql .= " AND vwdesc.Chave = vw.Chave ";
		$sql .= "WHERE vw.codcaso = :pCodCaso ";
		$sql .= "ORDER BY vw.ChavePai, vw.Ordem;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			while ($item = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$DescricaoExtra = "";
				if($item->DescricaoFilhos != "")
				{
					$DescricaoExtra = ' <span title="' . $item->DescricaoFilhos . '">';
					//$DescricaoExtra .= substr($item->DescricaoFilhos, 0, ((strlen($item->DescricaoFilhos) > 20) ? 20 : strlen($item->DescricaoFilhos)));
					$DescricaoExtra .= '...';
					$DescricaoExtra .= '</span>';
				}
				$arvoreItens[$item->ChavePai][$item->Chave] = array('Chave' => $item->Chave, 'Descricao' => ($item->Conteudo.$DescricaoExtra), 'TipoCont' => $item->TipoConteudo, 'ContRef' => $item->ContReferencia, 'Organ' => $item->Organizador);
				//$arvoreItens[$item->ChavePai][$item->Chave] = array('Chave' => $item->Chave, 'Descricao' => $item->Conteudo, 'TipoCont' => $item->TipoConteudo, 'ContRef' => $item->ContReferencia, 'Organ' => $item->Organizador);
			}
			$ret = "";
			self::ImprimeArvoreLista($arvoreItens, $ret);
			$ret = $ret . "</div>";
			
			return $ret;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	private static function ImprimeArvoreLista(array $todos , &$ret, $idPai = 0, $nivel = 0, $inicial = true)
	{
		if ($inicial == true)
		{
			$ret .= '<div id="tree"><ul id="arvore-caso">';
		}
		else
		{
			$ret .= '<ul>';
		}

		foreach( $todos[$idPai] as $chaveItem => $arvoreItem)
		{
			// imprime o item do menu
			$ret .= '<li id="' . $arvoreItem['Organ'] . '_' . $arvoreItem['TipoCont'] . '_' . $arvoreItem['ContRef'] . '_' . $arvoreItem['Chave'] . '"><span>' . $arvoreItem['Descricao'] . '</span>';
			// se o menu desta iteração tiver submenus, chama novamente a função
			if( isset( $todos[$chaveItem] ) ) self::ImprimeArvoreLista( $todos , $ret, $chaveItem , $nivel + 2, false);
			// fecha o li do item do menu
			$ret .= '</li>';
		}
		// fecha o ul do menu principal
		$ret .= '</ul>';
	}
	
	public function RetornaArvoreJSon()
	{
		
	}
	
	public function RetornaConfigs($tipo, $item)
	{
		$sql .= "SELECT conf.CodConfig, conf.Prefixo, conf.Nome, val.Valor ";
		$sql .= "FROM mescasomontagemconfigs conf ";
		$sql .= "LEFT OUTER JOIN mescasomontagemvalconfigs val ";
		$sql .= "			 ON val.CodConfig = conf.CodConfig ";
		$sql .= "			AND val.CodCaso = :pCodCaso ";
		$sql .= "			AND val.CodMontagem = 1 ";
		$sql .= "			AND val.Chave = :pChave ";
		$sql .= "WHERE ((conf.Grupo & (SELECT CodBinario FROM mestipoitem WHERE Codigo = :pTipoItem)) > 0);";
		
		/*
		$sql  = "SELECT val.CodConfig, val.Valor, conf.Prefixo ";
		$sql .= "FROM mescasomontagemvalconfigs val ";
		$sql .= "INNER JOIN mescasomontagemconfigs conf ";
		$sql .= "		 ON conf.CodConfig = val.CodConfig ";
		$sql .= "WHERE CodCaso = :pCodCaso ";
		$sql .= "  AND CodMontagem = 1 ";
		$sql .= "  AND Chave = :pChave";
		*/
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $item, PDO::PARAM_STR);
		$cmd->bindParam(":pTipoItem", $tipo, PDO::FETCH_OBJ);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$hash = new HashTable();
				$arrconfs = "";
				while ($item = $cmd->fetch(PDO::FETCH_OBJ))
				{
					$hash->AddItem($item->Prefixo . "Config_" . $item->CodConfig, $item->Valor);
					$arrconfs .= ($arrconfs != '' ? ';' : '') . $item->CodConfig;
				}
				$hash->AddItem("ArrConfs", $arrconfs);
				return $hash->ToXML();
			}
			else
			{
				$this->msg_erro = "@lng[Nada cadastrado]";
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
	
	public function RetornaListaConfSaltos($strNodoAtual)
	{
		$sql  = "select ";
		$sql .= "	  saltos.ChaveAtual ";
		$sql .= "	, (	select Conteudo ";
		$sql .= "		from vwarvorecaso at "; 
		$sql .= "		where at.CodCaso = saltos.codcaso "; 
		$sql .= "		  and at.codmontagem = saltos.codmontagem "; 
		$sql .= "		  and at.Chave = saltos.chaveatual) as DesChaveAtual ";
		$sql .= "	, (	select CASE WHEN atdsc.DescricaoFilhos IS NULL THEN '' ELSE atdsc.DescricaoFilhos END AS DescricaoFilhos ";
		$sql .= "		from vwarvoredescextra atdsc "; 
		$sql .= "		where atdsc.CodCaso = saltos.codcaso "; 
		$sql .= "		  and atdsc.codmontagem = saltos.codmontagem "; 
		$sql .= "		  and atdsc.Chave = saltos.chaveatual) as DesChaveAtualExtra ";
		$sql .= "	, saltos.ChaveDestino ";
		$sql .= "	, (	select Conteudo  ";
		$sql .= "		from vwarvorecaso des "; 
		$sql .= "		where des.CodCaso = saltos.codcaso "; 
		$sql .= "		  and des.codmontagem = saltos.codmontagem "; 
		$sql .= "		  and des.Chave = saltos.chavedestino) as DesChaveDestino ";
		$sql .= "	, (	select CASE WHEN atdsc.DescricaoFilhos IS NULL THEN '' ELSE atdsc.DescricaoFilhos END AS DescricaoFilhos ";
		$sql .= "		from vwarvoredescextra atdsc "; 
		$sql .= "		where atdsc.CodCaso = saltos.codcaso "; 
		$sql .= "		  and atdsc.codmontagem = saltos.codmontagem "; 
		$sql .= "		  and atdsc.Chave = saltos.chavedestino) as DesChaveDestinoExtra ";
		$sql .= "	, saltos.ChaveCond ";
		$sql .= "	, (	select Conteudo  ";
		$sql .= "		from vwarvorecaso des  ";
		$sql .= "		where des.CodCaso = saltos.codcaso  ";
		$sql .= "		  and des.codmontagem = saltos.codmontagem  ";
		$sql .= "		  and des.Chave = saltos.ChaveCond) as DesChaveCond ";
		$sql .= "	, (	select CASE WHEN atdsc.DescricaoFilhos IS NULL THEN '' ELSE atdsc.DescricaoFilhos END AS DescricaoFilhos ";
		$sql .= "		from vwarvoredescextra atdsc "; 
		$sql .= "		where atdsc.CodCaso = saltos.codcaso "; 
		$sql .= "		  and atdsc.codmontagem = saltos.codmontagem "; 
		$sql .= "		  and atdsc.Chave = saltos.ChaveCond) as DesChaveCondExtra ";
		$sql .= "	, saltos.CodPergunta ";
		$sql .= "	, (	select Texto from vwperguntasativas perg where perg.Codigo = saltos.CodPergunta ) ";
		$sql .= "	, saltos.RespostaCond ";
		$sql .= "	, saltos.Prioridade ";
		$sql .= "from mescasomontagemsaltos saltos ";
		$sql .= "where saltos.CodCaso = :pCodCaso ";
		$sql .= "  and saltos.CodMontagem = :pCodMontagem "; 
		$sql .= "  and saltos.ChaveAtual = :pChaveAtual ";
		$sql .= "order by saltos.Prioridade, ";
		$sql .= "		  saltos.ChaveCond, ";
		$sql .= "		  saltos.CodPergunta; ";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $strNodoAtual, PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$html  = Comuns::TopoTabelaListagem("", 'tabDesvios', array('Item', 'Destino', 'Condição', 'Prior.', '&nbsp'));
				
				while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
				{
					/*
					$strCondicao = "Quando no item " . $linha->DesChaveCond;
					
					if ($linha->CodPergunta != null)
					{
						$pergunta = new Pergunta();
						$pergunta->Carregar($linha->CodPergunta);
						$strCondicao
					}
					*/
					
					$html .= '<tr>';
					$html .= '<td>' . $linha->DesChaveAtual;
					if($linha->DesChaveAtualExtra != "")
						$html .= ' <span title="' . $linha->DesChaveAtualExtra . '">...</span>';
					$html .= '</td>';
					$html .= '<td>' . $linha->DesChaveDestino;
					if($linha->DesChaveDestinoExtra != "")
						$html .= ' <span title="' . $linha->DesChaveDestinoExtra . '">...</span>';
					$html .= '</td>';
					$html .= '<td>' . (is_null($linha->DesChaveCond) ? 'Nenhuma' : $linha->DesChaveCond);
					if($linha->DesChaveCondExtra != "")
						$html .= ' <span title="' . $linha->DesChaveCondExtra . '">...</span>';
					$html .= '</td>';
					$html .= '<td>';
					$html .= '<span class="alt-prior">'; 
					$html .= '<a href="javascript:void(0);" onclick="javascript:fntMudaPrioridade(\'1\', \'' . base64_encode($linha->ChaveAtual) . '\', \'' . base64_encode($linha->ChaveDestino) . '\');">' . Comuns::IMG_ACAO_DIMINUIR . '</a>';
					$html .= '<a href="javascript:void(0);" onclick="javascript:fntMudaPrioridade(\'-1\', \'' . base64_encode($linha->ChaveAtual) . '\', \'' . base64_encode($linha->ChaveDestino) . '\');">' . Comuns::IMG_ACAO_AUMENTAR . '</a>';
					$html .= '</span>';
					$html .= '</td>';
					$html .= '<td><a href="javascript:void(0);" onclick="javascript:fntDeletaSalto(\'' . base64_encode($linha->ChaveAtual) . '\', \'' . base64_encode($linha->ChaveDestino) . '\');">' . Comuns::IMG_ACAO_DELETAR . '</a></td>';
					$html .= '</tr>';
				}
				
				$html .= '</tbody></table>';
				return $html;
			}
			else
			{
				$html = "@lng[Nenhuma configuração salva até o momento]";
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}

	public function InsereSalto($strChaveAtual, $strChaveDestino, $strChaveCond, $intCodPergunta, $intRespostaCond, $intPrioridade = 1)
	{
		$sql  = "insert into mescasomontagemsaltos(CodCaso, CodMontagem, ChaveAtual, ChaveDestino, ChaveCond, CodPergunta, RespostaCond, Prioridade) ";
		$sql .= "values(:pCodCaso, :pCodMontagem, :pChaveAtual, :pChaveDestino, :pChaveCond, :pCodPergunta, :pRespostaCond, :pPrioridade);";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $strChaveAtual, PDO::PARAM_STR);
		$cmd->bindParam(":pChaveDestino", $strChaveDestino, PDO::PARAM_STR);
		$cmd->bindParam(":pChaveCond", $strChaveCond, PDO::PARAM_STR);
		$cmd->bindParam(":pCodPergunta", $intCodPergunta, PDO::PARAM_INT); 
		$cmd->bindParam(":pRespostaCond", $intRespostaCond, PDO::PARAM_INT);
		$cmd->bindParam(":pPrioridade", $intPrioridade, PDO::PARAM_INT);
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
	
	public function AlteraSalto($strChaveAtual, $strChaveDestino, $strChaveCond, $intRespostaCond)
	{
		$sql  = "update mescasomontagemsaltos ";
		$sql .= "set ChaveCond = :pChaveCond, ";
		$sql .= "	 CodPergunta = :pCodPergunta, ";
		$sql .= "	 RespostaCond = :pRespostaCond, ";
		$sql .= "	 Prioridade = :pPrioridade ";
		$sql .= "where CodCaso = :pCodCaso ";
		$sql .= "  and CodMontagem = :pCodMontagem ";
		$sql .= "  and ChaveAtual = :pChaveAtual ";
		$sql .= "  and ChaveDestino = :pChaveDestino;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $strChaveAtual, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveDestino", $strChaveDestino, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveCond", $strChaveCond, PDO::PARAM_INT);
		$cmd->bindParam(":pCodPergunta", $intCodPergunta, PDO::PARAM_INT);
		$cmd->bindParam(":pRespostaCond", $intRespostaCond, PDO::PARAM_INT);
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
	
	public function DeletaSalto($strChaveAtual, $strChaveDestino)
	{
		$sql  = "delete from mescasomontagemsaltos ";
		$sql .= "where CodCaso = :pCodCaso ";
		$sql .= "  and CodMontagem = :pCodMontagem ";
		$sql .= "  and ChaveAtual = :pChaveAtual ";
		$sql .= "  and ChaveDestino = :pChaveDestino;";
				
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $strChaveAtual, PDO::PARAM_STR);
		$cmd->bindParam(":pChaveDestino", $strChaveDestino, PDO::PARAM_STR);
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
	
	public function AlteraPrioridadeSalto($intMaisMenos, $strNodoOrigem, $strNodoDestino)
	{
		$sql  = "UPDATE mescasomontagemsaltos SET Prioridade = Prioridade + :pMaisMenos ";
		$sql .= "where CodCaso = :pCodCaso ";
		$sql .= "  and CodMontagem = :pCodMontagem ";
		$sql .= "  and ChaveAtual = :pChaveAtual ";
		$sql .= "  and ChaveDestino = :pChaveDestino;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pMaisMenos", $intMaisMenos, PDO::PARAM_INT);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChaveAtual", $strNodoOrigem, PDO::PARAM_STR);
		$cmd->bindParam(":pChaveDestino", $strNodoDestino, PDO::PARAM_STR);
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
	
	public function InsereAnexo($strChaveAtual, $intCodAnexo, $strTipoConteudo, $intCodUsuario)
	{
		$sql  = "insert into mescasomontagemanexos(CodCaso, CodMontagem, CodChave, CodConteudo, TipoConteudo, DtCadastro, CodUsuario) ";
		$sql .= "values(:pCodCaso, 1, :pCodChave, :pCodConteudo, :pTipoConteudo, CURRENT_TIMESTAMP, :pCodUsuario);";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodChave", $strChaveAtual, PDO::PARAM_STR);
		$cmd->bindParam(":pCodConteudo", $intCodAnexo, PDO::PARAM_INT);
		$cmd->bindParam(":pTipoConteudo", $strTipoConteudo, PDO::PARAM_STR);
		$cmd->bindParam(":pCodUsuario", $intCodUsuario, PDO::PARAM_INT);
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
	
	public function DeletaAnexo($strChaveAtual, $intCodAnexo, $strTipoConteudo)
	{
		$sql  = "delete from mescasomontagemanexos ";
		$sql .= "where CodCaso = :pCodCaso ";
		$sql .= "  and CodMontagem = 1 ";
		$sql .= "  and CodChave = :pCodChave ";
		$sql .= "  and CodConteudo = :pCodConteudo ";
		$sql .= "  and TipoConteudo = :pTipoConteudo;";
		
		//Log::RegistraLog("Debug - delete from mescasomontagemanexos -> $this->codcaso, $strChaveAtual, $intCodAnexo, $strTipoConteudo");
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodChave", $strChaveAtual, PDO::PARAM_STR);
		$cmd->bindParam(":pCodConteudo", $intCodAnexo, PDO::PARAM_INT);
		$cmd->bindParam(":pTipoConteudo", $strTipoConteudo, PDO::PARAM_STR);
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
	
	public function RetornaListaConfAnexos($strChaveAtual)
	{
		$sql  = "select CodConteudo, TipoConteudo ";
		$sql .= "from mescasomontagemanexos ";
		$sql .= "where CodCaso = :pCodCaso ";
		$sql .= "  and CodMontagem = 1 ";
		$sql .= "  and CodChave = :pCodChave ";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodChave", $strChaveAtual, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$html = Comuns::TopoTabelaListagem("", "tabAnexos", array('Descrição', 'Tipo', 'Ações'));
				while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
				{
					if ($linha->TipoConteudo == 'C')
					{
						$c = new Conteudo();
						$c->Carrega($this->codcaso, $linha->CodConteudo);

						$html .= '<tr>';
						$html .= '<td>' . $c->getDescricao() . '</td>';
						$html .= '<td>@lng[Hipertexto]</td>';
						$html .= '<td>';
						$html .= '<a href="javascript:void(0);" onclick="javascript:fntDeletaAnexo(\'' . base64_encode($strChaveAtual) . '\', \'C' . base64_encode($linha->CodConteudo) . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>';
						$html .= '</td>';
						$html .= '</tr>';
					}
					else
					{
						$m = new Midia();
						$m->setCodCaso($this->codcaso);
						$m->setCodMidia($linha->CodConteudo);
						$m->CarregaPorCodigoEspecifico();
						
						$html .= '<tr>';
						$html .= '<td>' . $m->getDescricao() . '</td>';
						$html .= '<td>' . Comuns::DescreveTipoMidia($m->getTipoMidia()) . '</td>';
						$html .= '<td>';
						$html .= '<a href="javascript:void(0);" onclick="javascript:fntDeletaAnexo(\'' . base64_encode($strChaveAtual) . '\', \'M' . base64_encode($linha->CodConteudo) . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>';
						$html .= '</td>';
						$html .= '</tr>';
					}
				}
				return $html;
			}
			else
			{
				return '<strong>@lng[Nenhum item cadastrado]</strong>';
			}
		}
		else
		{
			$msg = $cmd->errorInfo();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
	
	public function ListaPerguntasNodo($strNodo)
	{
		$arrDetNodo = split("_", $strNodo);
		if ($arrDetNodo[1] == 'perg')
		{
			$sql  = "select ";
			$sql .= "	 a.Chave ";
			$sql .= "	,a.TipoConteudo ";
			$sql .= "	,p.Codigo ";
			$sql .= "	,p.Texto ";
			$sql .= "from vwarvorecaso a ";
			$sql .= "inner join vwperguntasativas p ";
			$sql .= "		on p.Codigo = a.ContReferencia ";
			$sql .= "where a.CodCaso = :pCodCaso ";
			$sql .= "  and a.CodMontagem = :pCodMontagem ";
			$sql .= "  and a.ChavePai = :pChave;";
		}
		else
		{
			$sql  = "select ";
			$sql .= "	 a.Chave ";
			$sql .= "	,a.TipoConteudo ";
			$sql .= "	,p.Codigo ";
			$sql .= "	,p.Texto ";
			$sql .= "from vwarvorecaso a ";
			$sql .= "inner join mescasoagrupamentos ag ";
			$sql .= "		on ag.CodCaso = a.CodCaso ";
			$sql .= "	   and ag.CodAgrupamento = a.ContReferencia ";
			$sql .= "inner join mesperguntaagrupamentos agp ";
			$sql .= "		on agp.CodAgrupador = ag.CodAgrupamento ";
			$sql .= "inner join vwperguntasativas p ";
			$sql .= "		on p.Codigo = agp.CodPergunta ";
			$sql .= "where a.CodCaso = :pCodCaso ";
			$sql .= "  and a.CodMontagem = :pCodMontagem ";
			$sql .= "  and a.ChavePai = :pChave;";
		}
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $this->codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $this->nummontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $arrDetNodo[3], PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return $cmd->fetchAll(PDO::FETCH_OBJ);
			}
			else
			{
				$this->msg_erro = "@lng[Nenhuma pergunta encontrada]";
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
	
	public function RetornaComboConteudosExtras()
	{
		$c = new Conteudo();
		$m = new Midia();
		$m->setCodCaso($this->codcaso);
		$numReg = 0;
		$optconteudos = '<option value="">@lng[Selecione]</option>';
		
		// Conteúdos HTML
		$rsconteudos = $c->ListaRecordSet($this->codcaso);
		if (!($rsconteudos===false))
		{	
			$optconteudos .= '<optgroup label="@lng[Hipertexto]">';
			foreach ($rsconteudos as $item)
			{
				$numReg++;
				$optconteudos .= '<option value="C' . base64_encode($item->CodConteudo) . '">' . $item->Descricao . '</option>';
			}	
			$optconteudos .= '</optgroup>';
		}
		
		// Documentos
		$rsconteudos = $m->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_DOCUMENTO);
		if (!($rsconteudos===false))
		{
			$optconteudos .= '<optgroup label="@lng[Documentos]">';
			foreach ($rsconteudos as $item)
			{
				$numReg++;
				$optconteudos .= '<option value="M' . base64_encode($item->CodMidia) . '">' . $item->Descricao . '</option>';
			}
			$optconteudos .= '</optgroup>';
		}
		
		// Vídeos
		$rsconteudos = $m->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_VIDEO);
		if (!($rsconteudos===false))
		{
			$optconteudos .= '<optgroup label="@lng[Vídeo]">';
			foreach ($rsconteudos as $item)
			{
				$numReg++;
				$optconteudos .= '<option value="M' . base64_encode($item->CodMidia) . '">' . $item->Descricao . '</option>';
			}
			$optconteudos .= '</optgroup>';
		}
		
		// Imagens
		$rsconteudos = $m->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_IMAGEM);
		if (!($rsconteudos===false))
		{
			$optconteudos .= '<optgroup label="@lng[Imagem]">';
			foreach ($rsconteudos as $item)
			{
				$numReg++;
				$optconteudos .= '<option value="M' . base64_encode($item->CodMidia) . '">' . $item->Descricao . '</option>';
			}
			$optconteudos .= '</optgroup>';
		}
		
		// Sons
		$rsconteudos = $m->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_AUDIO);
		if (!($rsconteudos===false))
		{
			$optconteudos .= '<optgroup label="@lng[Áudio]">';
			foreach ($rsconteudos as $item)
			{
				$numReg++;
				$optconteudos .= '<option value="M' . base64_encode($item->CodMidia) . '">' . $item->Descricao . '</option>';
			}
			$optconteudos .= '</optgroup>';
		}
		
		if($numReg==0)
		{
			$optconteudos = '<option value="">@lng[Nenhum registro encontrado]</option>';
		}
		
		return $optconteudos;
	}
	
	public static function TemFilhos($codcaso, $codmontagem, $chave)
	{
		$sql  = "select 1 as Tem from mescasomontagem ";
		$sql .= "where CodCaso = :pCodCaso and CodMontagem = :pCodMontagem ";
		$sql .= "and chavepai = :pChave ";
		$sql .= "limit 0,1;";
		
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $codmontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				return true;
			}
			else
			{
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
	
	public static function RetornaDescricaoItem($codcaso, $codmontagem, $chave)
	{
		$sql  = "select ifnull(case when configs.valor = '' then null else configs.valor end, mestipoitem.Descricao) as Descricao ";
		$sql .= "from mescasomontagem ";
		$sql .= "inner join mestipoitem ";
		$sql .= "		on mestipoitem.codigo = mescasomontagem.TipoConteudo ";
		$sql .= "left outer join mescasomontagemvalconfigs configs ";
		$sql .= "			 on configs.CodCaso = mescasomontagem.CodCaso ";
		$sql .= "			and configs.CodMontagem = mescasomontagem.CodMontagem ";
		$sql .= "			and configs.Chave = mescasomontagem.Chave ";
		$sql .= "			and configs.CodConfig = 5 ";
		$sql .= "where mescasomontagem.codcaso = :pCodCaso "; 
		$sql .= "  and mescasomontagem.codmontagem = :pCodMontagem ";
		$sql .= "  and mescasomontagem.chave = :pChave;";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
		$cmd->bindParam(":pCodMontagem", $codmontagem, PDO::PARAM_INT);
		$cmd->bindParam(":pChave", $chave, PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$cmd->fetchColumn();
			}
			else
			{
				return '';
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