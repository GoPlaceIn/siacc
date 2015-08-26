<?php
session_start();
include_once 'inc/comuns.inc.php';
include_once 'cls/conexao.class.php';
include_once 'cls/hipoteses.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/pergunta.class.php';
include_once 'cls/diagnostico.class.php';
include_once 'cls/tratamento.class.php';
include_once 'cls/components/hashtable.class.php';

header('Content-Type: text/html; charset=iso-8859-1');

function BuscaRespostas($classe, $codcaso)
{
	$obj = new $classe;
	
	$registros = $obj->ListaRecordSet($codcaso);
	
	if (count($registros) > 0)
	{
		$tpl = file_get_contents("tpl/aluno/caso-item-resposta.html");
		$cont = 1;
		foreach ($registros as $reg)
		{
			$copia = $tpl;
			
			$copia = str_replace("<!--id-item-->", $cont, $copia);
			$copia = str_replace("<!--desc-item-->", $reg->Descricao, $copia);
			if ($reg->Correto == 1)
			{
				$copia = str_replace("<!--img-item-->", "correto", $copia);
			}
			else
			{
				$copia = str_replace("<!--img-item-->", "errado", $copia);
			}
			$copia = str_replace("<!--justif-item-->", $reg->Justificativa, $copia);
			
			$conteudo .= $copia;
			$cont++;
 		}
 		$conteudo = '<div class="respostas">' . $conteudo . '</div>';
	}
	else
	{
		$conteudo = "@lng[Nenhum registro encontrado]";
	}
 	return $conteudo;
}

function BuscaRespostasHipoteses($codcaso, $chave)
{
	$sql  = "select  hip.CodHipotese ";
	$sql .= "		,hip.Descricao ";
	$sql .= "		,hip.Correto ";
	$sql .= "		,hip.Justificativa ";
	$sql .= "		,hip.ConteudoAdicional ";
	$sql .= "from mescasohipotdiagnperguntaguia hippg ";
	$sql .= "inner join mescasohipotdiagn hip ";
	$sql .= "		on hip.codcaso = hippg.codcaso ";
	$sql .= "	   and hip.sequencia = hippg.grupohipotese ";
	$sql .= "where hippg.CodCaso = :pCodCaso ";
	$sql .= "  and hippg.Chave = :pCodChave;";
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
	$cmd->bindParam(":pCodChave", $chave, PDO::PARAM_STR);
	
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			$registros = $cmd->fetchAll(PDO::FETCH_OBJ);
			$tpl = file_get_contents("tpl/aluno/caso-item-resposta.html");
			$cont = 1;
			
			foreach ($registros as $reg)
			{
				$copia = $tpl;
				
				$copia = str_replace("<!--id-item-->", $cont, $copia);
				$copia = str_replace("<!--desc-item-->", $reg->Descricao, $copia);
				if ($reg->Correto == 1)
				{
					$copia = str_replace("<!--img-item-->", "correto", $copia);
				}
				else
				{
					$copia = str_replace("<!--img-item-->", "errado", $copia);
				}
				$copia = str_replace("<!--justif-item-->", $reg->Justificativa, $copia);
				
				$conteudo .= $copia;
				$cont++;
	 		}
	 		$conteudo = '<div class="respostas">' . $conteudo . '</div>';
		}
		else
		{
			$conteudo = "@lng[Nenhum registro encontrado]";
		}
	}
	else
	{
		$msg = $cmd->errorInfo();
		$conteudo = $msg[2];
	}
	
	return $conteudo;
}

function BuscaRespostasExames($codcaso, $chave)
{
	$sql  = "select ex.CodExame ";
	$sql .= "		,ex.Descricao ";
	$sql .= "		,ex.Correto ";
	$sql .= "		,ex.Justificativa ";
	$sql .= "		,ex.ConteudoAdicional ";
	$sql .= "from mescasoexameschaves ech ";
	$sql .= "inner join mescasoexames ex ";
	$sql .= "		on ex.codcaso = ech.codcaso ";
	$sql .= "	   and ex.numbateria = ech.numbateria ";
	$sql .= "	   and ex.codexame = case when ech.codexame = -1 then ex.codexame else ech.CodExame end ";
	$sql .= "	   and ex.MostraQuando = case when ech.tiporegistro = 1 then 0 else ex.MostraQuando end ";
	$sql .= "where ech.codcaso = :pCodCaso ";
	$sql .= "  and ech.chave = :pCodChave;";
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pCodCaso", $codcaso, PDO::PARAM_INT);
	$cmd->bindParam(":pCodChave", $chave, PDO::PARAM_STR);
	
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			$registros = $cmd->fetchAll(PDO::FETCH_OBJ);
			$tpl = file_get_contents("tpl/aluno/caso-item-resposta.html");
			$cont = 1;
			
			foreach ($registros as $reg)
			{
				$copia = $tpl;
				
				$copia = str_replace("<!--id-item-->", $cont, $copia);
				$copia = str_replace("<!--desc-item-->", $reg->Descricao, $copia);
				if ($reg->Correto == 1)
				{
					$copia = str_replace("<!--img-item-->", "correto", $copia);
				}
				else
				{
					$copia = str_replace("<!--img-item-->", "errado", $copia);
				}
				$copia = str_replace("<!--justif-item-->", $reg->Justificativa, $copia);
				
				$conteudo .= $copia;
				$cont++;
	 		}
	 		$conteudo = '<div class="respostas">' . $conteudo . '</div>';
		}
		else
		{
			$conteudo = "@lng[Nenhum registro encontrado]";
		}
	}
	else
	{
		$msg = $cmd->errorInfo();
		$conteudo = $msg[2];
	}
	
	return $conteudo;
}

function VerificaAcerto($codpergunta, $marcadas)
{
	$p = new Pergunta();
	$p->Carregar($codpergunta);
	$alternativas = $p->getAlternativas();
	$acertou = false;

	if (($p->getTipo()->getCodigo() == 1) || ($p->getTipo()->getCodigo() == 3))
	{
		// Somente uma alternativa correta porque vai ser um radio button;
		$escolha = $marcadas;
		
		foreach ($alternativas as $alt)
		{
			if (($alt->getCodUnico() == $escolha[0]) && ($alt->getCorreto() == 1))
			{
				$acertou = true;
				break;
			}
		}
	}
	else if($p->CodTipo == 2)
	{
		// Pode ter mais de uma alternativa correta porque vai ser um checkbox
		$escolhas = $marcadas;
		
		for ($i = 0; $i < count($escolhas); $i++)
		{
			foreach ($alternativas as $alt)
			{
				if ($alt->getCodUnico() == $escolhas[$i])
				{
					if ($alt->getCorreto() == 1)
					{
						$acertou = true;
					}
					else
					{
						$acertou = false;
					}
				}
			}
		}
	}
	
	return $acertou;
}

function BuscaRespostasExercicios($codcaso, $chave)
{
	$sql  = "select Codigo, CodTipo ";
	$sql .= "from mespergunta ";
	$sql .= "where chave = :pCodChave;";
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pCodChave", $chave, PDO::PARAM_STR);
	
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			$rspergunta = $cmd->fetch(PDO::FETCH_OBJ);
			
			$p = new Pergunta();
			$p->Carregar($rspergunta->Codigo);
			
			$acertou = VerificaAcerto($rspergunta->Codigo, $_POST['rdoAlternativa']);
			$alternativas = $p->getAlternativas();
			
			// Cria o diálogo dizendo se acertou ou se errou
			if ($acertou)
				$conteudo  = file_get_contents("tpl/aluno/resposta-certa.html");
			else
				$conteudo  = file_get_contents("tpl/aluno/resposta-errada.html");
			
			if ($p->getTextoExplicacaoGeral() != null)
			{
				$conteudo .= '<div id="perg-exp-geral">' . $p->getTextoExplicacaoGeral() . '</div>';
			}
			
			$tpl = file_get_contents("tpl/aluno/caso-item-resposta.html");
			$letra = 65;
			$cont = 1;
			foreach ($alternativas as $alt)
			{
				if (($alt->getExplicacao() != null) && (strip_tags($alt->getExplicacao()) != ""))
				{
					$copia = $tpl;
					
					$copia = str_replace("<!--id-item-->", $cont, $copia);
					$copia = str_replace("<!--desc-item-->", $alt->getTexto() . " (imagem " . chr($letra) . ")" , $copia);
					if ($alt->getCorreto() == 1)
					{
						$copia = str_replace("<!--img-item-->", "correto", $copia);
					}
					else
					{
						$copia = str_replace("<!--img-item-->", "errado", $copia);
					}
					$copia = str_replace("<!--justif-item-->", $alt->getExplicacao(), $copia);
					
					$conteudo .= $copia;
					$cont++;
					$letra++;
				}
				else
				{
					$conteudo += "";
				}
				
			}
		}
		else
		{
			$conteudo = "@lng[Nenhum registro encontrado]";
		}
	}
	else
	{
		$msg = $cmd->errorInfo();
		$conteudo = $msg[2];
	}
	
	return $conteudo;
}

function BuscaRespostaAgrupadores($codcaso, $chave)
{
	$hash = new HashTable();
	$explicacoes = "";
	
	foreach ($_POST as $campo => $valor)
	{
		if (substr($campo, 0, 3) == "rdo")
		{
			$detalhes = split("_", $campo);
			$pergunta = $detalhes[1];
			$p = new Pergunta();
			
			$acertou = VerificaAcerto($pergunta, $_POST[$campo]);
			$hash->AddItem($pergunta, ($acertou === true ? 's' : 'n'));
			
			$p->Carregar($pergunta);
			$alternativas = $p->getAlternativas();
			foreach ($alternativas as $alt)
			{
				if ((!is_null($alt->getExplicacao())) && (strip_tags($alt->getExplicacao()) != ""))
				{
					$explicacoes .= '<div class="explicacao">' . $alt->getExplicacao() . '</div>';
				}
			}
			
			if (! is_null($p->getTextoExplicacaoGeral()))
			{
				$explicacoes = '<div class="explicacao">' . $p->getTextoExplicacaoGeral() . '</div>' . $explicacoes;
			}
		}
	}
	
	$retornos = $hash->ToArray();
	$certas = 0;
	$erradas = 0;
	foreach ($retornos as $chave => $item)
	{
		if ($item == 's')
			$certas++;
		else
			$erradas++;
		
		$imgs .= (($imgs != "") ? "," : "") . $chave . '_' . $item;
	}
	
	$conteudo = "<p>@lng[Você] ";
	
	if (($certas > 0) && ($erradas > 0))
		$conteudo .= "@lng[acertou] " . $certas;
	else if (($certas > 0) && ($erradas == 0))
		$conteudo .= "@lng[acertou todas as questões]";
		
	if (($certas > 0) && ($erradas > 0))
		$conteudo .= " @lng[e errou] " . $erradas;
	else if (($certas == 0) && ($erradas > 0))
		$conteudo .= " @lng[errou as] " . $erradas . " @lng[questões.]";
		
	return '<texto>' . $conteudo . '</p><p>' . $explicacoes . '</p></texto><imgs>' .$imgs . '</imgs>';
}

function BuscaRespostasTratamentos($codcaso, $chave)
{
	$tr = new Tratamento();
	$tratamentos = $tr->ListaRecordSet($codcaso);
	
	$conteudo = "";
	$cont = 0;
	
	foreach ($tratamentos as $trat)
	{
		if ($trat->Correto == 1)
		{
			$conteudo .= '<rt_' . $cont . '>@lng[correto]</rt_' . $cont . '>';
		}
		else
		{
			$conteudo .= '<rt_' . $cont . '>@lng[errado]</rt_' . $cont . '>';
		}
		
		if (($trat->Justificativa != null) && ($trat->Justificativa != ""))
		{
			$conteudo .= '<just_des_' . $cont . '>' . $trat->Justificativa . '</just_des_' . $cont . '>';
		}
		$cont++;
	}
	
	return $conteudo;
}

function Main()
{
	$sql  = "select Prefixo ";
	$sql .= "from mescasoordenacao ";
	$sql .= "where CodCaso = :pCodCaso ";
	$sql .= "  and Chave = :pChave;";
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pCodCaso", $_SESSION['casores']);
	$cmd->bindParam(":pChave", $_POST['k']);
	
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			$prefixo = $cmd->fetchColumn();

			switch ($prefixo)
			{
				case "HIP":
					$ret = BuscaRespostasHipoteses($_SESSION['casores'], $_POST['k']);
					break;
				case "EXA":
					$ret = BuscaRespostasExames($_SESSION['casores'], $_POST['k']);
					break;
				case "EXE":
					$ret = BuscaRespostasExercicios($_SESSION['casores'], $_POST['k']);
					break;
				case "AGR":
					$ret = BuscaRespostaAgrupadores($_SESSION['casores'], $_POST['k']);
					break;
				case "DIA":
					$ret = BuscaRespostas("Diagnostico", $_SESSION['casores']);
					break;
				case "TRA":
					$ret = BuscaRespostasTratamentos($_SESSION['casores'], $_POST['k']);
					break;
				case "DES":
					$ret = BuscaRespostas("Desfecho", $_SESSION['casores']);
					break;
			}
			
			$retorno = $ret;
		}
		else
		{
			$retorno = "@lng[Nenhum registro encontrado]";
		}
	}
	else
	{
		$msg = $cmd->errorInfo();
		$retorno = $msg[2];
	}
	
	echo($retorno);
}

Main();

?>