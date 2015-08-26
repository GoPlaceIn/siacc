<?php
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';
include_once 'cls/nivelpergunta.class.php';
include_once 'cls/area.class.php';
include_once 'cls/hipoteses.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/examefisico.class.php';
include_once 'cls/tratamento.class.php';
include_once 'cls/diagnostico.class.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/simnao.class.php';
include_once 'cls/components/hashtable.class.php';

class Temp
{
	private function fntRegistraReplicacao($intCodNovo)
	{
		$sqlNumVer = "SELECT IFNULL(MAX(NumVersao), 1) + 1 AS NumVersao FROM mescasoversao WHERE CodCasoOrigem = :pCodOrigem";
		
		$cnn = Conexao2::getInstance();
		
		$cmdNumVer = $cnn->prepare($sqlNumVer);
		$cmdNumVer->bindParam(":pCodOrigem", $this->codigo, PDO::PARAM_INT);
		$cmdNumVer->execute();
		
		$intNumVer = $cmdNumVer->fetchColumn(0);
		
		$cmdNumVer->closeCursor();
		$u = unserialize($_SESSION["usu"]);
		
		$sql  = "INSERT INTO mescasoversao(CodCasoOrigem, CodCasoNovo, NumVersao, DtVersao, CodUsuario) ";
		$sql .= "VALUES(:pCodCasoOrigem, :pCodCasoNovo, :pNumVersao, CURRENT_TIMESTAMP, :pCodUsuario); ";
		
		$cmdVers = $cnn->prepare($sql);
		$cmdVers->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT); 
		$cmdVers->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
		$cmdVers->bindParam(":pNumVersao", $intNumVer, PDO::PARAM_INT); 
		$cmdVers->bindParam(":pCodUsuario", $u->getCodigo(), PDO::PARAM_INT);
		$cmdVers->execute();
		
		if ($cmdVers->errorCode() == Comuns::QUERY_OK)
		{
			$sqlCol  = "INSERT INTO mescasocolaborador(CodCaso, CodUsuario) ";
			$sqlCol .= "SELECT :pCodCasoNovo, CodUsuario ";
			$sqlCol .= "FROM mescasocolaborador WHERE CodCaso = :pCodCasoOrigem; ";
			
			$cmdCol = $cnn->prepare($sqlCol);
			$cmdCol->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT); 
			$cmdCol->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
			$cmdCol->execute();
			
			if ($cmdCol->errorCode() == Comuns::QUERY_OK)
			{
				$sqlAnam  = "insert into mescasoanamnese(CodCaso, Identificacao, QueixaPri, HistAtual, HistPregressa, HistFamiliar, PerfilPsicoSocial, RevSistemas) ";
				$sqlAnam .= "select :pCodCasoNovo, Identificacao, QueixaPri, HistAtual, HistPregressa, HistFamiliar, PerfilPsicoSocial, RevSistemas ";
				$sqlAnam .= "from mescasoanamnese where CodCaso = :pCodCasoOrigem;";
				
				$cmdAnam = $cnn->prepare($sqlAnam);
				$cmdAnam->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT); 
				$cmdAnam->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
				$cmdAnam->execute();
				
				if ($cmdAnam->errorCode() == Comuns::QUERY_OK)
				{
					$sqlExFis  = "insert into mescasoexamefisico(CodCaso, Cabeca, Pescoco, AuscultaPulmonar, AuscultaCardiaca, SinaisVitais, Abdomen, Pele, Extremidades, midCabeca, midPescoco, midAusPulmonar, midAusCardiaca, midSinaisVitais, midAbdomen, midPele, midExtremidades, Geral, midGeral) ";
					$sqlExFis .= "select :pCodCasoNovo, Cabeca, Pescoco, AuscultaPulmonar, AuscultaCardiaca, SinaisVitais, Abdomen, Pele, Extremidades, midCabeca, midPescoco, midAusPulmonar, midAusCardiaca, midSinaisVitais, midAbdomen, midPele, midExtremidades, Geral, midGeral ";
					$sqlExFis .= "from mescasoexamefisico where CodCaso = :pCodCasoOrigem;";
					
					$cmdExFis = $cnn->prepare($sqlExFis);
					$cmdExFis->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT);
					$cmdExFis->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
					$cmdExFis->execute();
					
					if ($cmdExFis->errorCode() == Comuns::QUERY_OK)
					{
						$sqlHipDia  = "insert into mescasohipotdiagn(CodCaso, Descricao, Correto, Justificativa, ConteudoAdicional, Sequencia, CodHipoteseOrigem) ";
						$sqlHipDia .= "select :pCodCasoNovo, Descricao, Correto, Justificativa, ConteudoAdicional, Sequencia, CodHipotese ";
						$sqlHipDia .= "from mescasohipotdiagn where CodCaso = :pCodCasoOrigem;";
						
						$cmdHipDia = $cnn->prepare($sqlHipDia);
						$cmdHipDia->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT); 
						$cmdHipDia->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
						$cmdHipDia->execute();
						
						if ($cmdHipDia->errorCode() == Comuns::QUERY_OK)
						{
							$sqlDiag  = "insert into mescasodiagnostico(CodCaso, Descricao, Correto, Justificativa, ConteudoAdicional, CodDiagnosticoOrigem) ";
							$sqlDiag .= "select :pCodCasoNovo, Descricao, Correto, Justificativa, ConteudoAdicional, CodDiagnostico ";
							$sqlDiag .= "from mescasodiagnostico where CodCaso = :pCodCasoOrigem;";
							
							$cmdDiag = $cnn->prepare($sqlDiag);
							$cmdDiag->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT); 
							$cmdDiag->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
							$cmdDiag->execute();
							
							if ($cmdDiag->errorCode() == Comuns::QUERY_OK)
							{
								$sqlTrat  = "insert into mescasotratamento(CodCaso, Titulo, Descricao, Correto, Justificativa, ConteudoAdicional, CodTratamentoOrigem) ";
								$sqlTrat .= "select :pCodCasoNovo, Titulo, Descricao, Correto, Justificativa, ConteudoAdicional, Codtratamento ";
								$sqlTrat .= "from mescasotratamento where CodCaso = :pCodCasoOrigem;";
								
								$cmdTrat = $cnn->prepare($sqlTrat);
								$cmdTrat->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT);
								$cmdTrat->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
								$cmdTrat->execute();
								
								if ($cmdTrat->errorCode() == Comuns::QUERY_OK)
								{
									$sqlDes  = "insert into mescasodesfecho(CodCaso, Titulo, Desfecho, CodDesfechoOrigem) ";
									$sqlDes .= "select :pCodCasoNovo, Titulo, Desfecho, CodDesfecho ";
									$sqlDes .= "from mescasodesfecho where CodCaso = :pCodCasoOrigem;";
									
									$cmdDes = $cnn->prepare($sqlDes);
									$cmdDes->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT);
									$cmdDes->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
									$cmdDes->execute();
									
									if ($cmdDes->errorCode() == Comuns::QUERY_OK)
									{
										$sqlCont = "insert into mescasoconteudo(CodCaso, Descricao, Texto, Chave, Tipo, NaoExibeNaMontagem, CodConteudoOrigem) ";
										$sqlCont = "select :pCodCasoNovo, Descricao, Texto, Chave, Tipo, NaoExibeNaMontagem, CodConteudo ";
										$sqlCont = "from mescasoconteudo where CodCaso = :pCodCasoOrigem;";
										
										$cmdCont = $cnn->prepare($sqlCont);
										$cmdCont->bindParam(":pCodCasoOrigem", $this->codigo, PDO::PARAM_INT);
										$cmdCont->bindParam(":pCodCasoNovo", $intCodNovo, PDO::PARAM_INT);
										$cmdCont->execute();
									}
									else
									{
										$msg = $cmdDes->errorInfo();
										$cnn->rollBack();
										$this->msg_erro = $msg[2];
										return false;
									}
								}
								else
								{
									$msg = $cmdTrat->errorInfo();
									$cnn->rollBack();
									$this->msg_erro = $msg[2];
									return false;
								}
							}
							else
							{
								$msg = $cmdDiag->errorInfo();
								$cnn->rollBack();
								$this->msg_erro = $msg[2];
								return false;
							}
						}
						else
						{
							$msg = $cmdHipDia->errorInfo();
							$this->msg_erro = $msg[2];
							return false;
						}
					}
					else
					{
						$msg = $cmdExFis->errorInfo();
						$cnn->rollBack();
						$this->msg_erro = $msg[2];
						return false;
					}
				}
				else
				{
					$msg = $cmdAnam->errorInfo();
					$cnn->rollBack();
					$this->msg_erro = $msg[2];
					return false;
				}
			}
			else
			{
				$msg = $cmdCol->errorInfo();
				$cnn->rollBack();
				$this->msg_erro = $msg[2];
				return false;
			}
		}
		else
		{
			$msg = $cmdVers->errorInfo();
			$cnn->rollBack();
			$this->msg_erro = $msg[2];
			return false;
		}
	}
}

?>