<?php
session_start();

include_once 'cls/conexao.class.php';
include_once 'cls/log.class.php';
include_once 'wsclient/wsclient.class.php';
include_once 'inc/comuns.inc.php';

function BuscaCacheTipo($remoto = true)
{
	$sql  = "SELECT CodTipo, Descricao ";
	$sql .= "FROM siscachetipoconsulta ";
	if ($remoto)
	{
		$sql .= "WHERE MINUTE(TIMEDIFF(CURRENT_TIMESTAMP, ( ";
		$sql .= "              SELECT MIN(DataHora) as DataHora FROM siscachetipoconsulta))) <= 20;";
	}
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			return $cmd->fetchAll(PDO::FETCH_KEY_PAIR);
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function BuscaCacheSubTipo($tipo, $remoto = true)
{
	$sql  = "SELECT CodSubTipo, DescricaoSubTipo ";
	$sql .= "FROM siscachesubtipoconsulta ";
	$sql .= "WHERE CodTipo = :pCodTipo ";
	if ($remoto)
	{
		$sql .= "  AND MINUTE(TIMEDIFF(CURRENT_TIMESTAMP, ( ";
		$sql .= "              SELECT MIN(DataHora) as DataHora FROM siscachesubtipoconsulta hora  ";
		$sql .= "              WHERE hora.CodTipo = siscachesubtipoconsulta.CodTipo))) <= 20;";
	}
	
	$cnn = Conexao2::getInstance();
	
	$cmd = $cnn->prepare($sql);
	$cmd->bindParam(":pCodTipo", $tipo, PDO::PARAM_INT);
	$cmd->execute();
	
	if ($cmd->errorCode() == Comuns::QUERY_OK)
	{
		if ($cmd->rowCount() > 0)
		{
			return $cmd->fetchAll(PDO::FETCH_KEY_PAIR);
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function CriaCacheTipo($tipos_pesquisa)
{
	$sqldel = "DELETE FROM siscachetipoconsulta;";
	
	$cnn = Conexao2::getInstance();

	$n = $cnn->exec($sqldel);
	
	$sql  = "INSERT INTO siscachetipoconsulta(CodTipo, Descricao, DataHora) ";
	$sql .= "VALUES(:pCodTipo, :pDescricao, CURRENT_TIMESTAMP);";
	
	foreach ($tipos_pesquisa as $nodo)
	{
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodTipo", $nodo['id'], PDO::PARAM_INT);
		$cmd->bindParam(":pDescricao", $nodo['nome'], PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() != Comuns::QUERY_OK)
		{
			print_r($cmd->errorInfo());
		}
		
		$cmd->closeCursor();
	}
	Log::RegistraLog("Cache dos Tipos de pesquisa ao SIAP criado");
}

function CriaCacheSubTipo($sub_tipos_pesquisa, $tipo)
{
	$sqldel = "DELETE FROM siscachesubtipoconsulta WHERE CodTipo = " . $tipo . ";";
	
	$cnn = Conexao2::getInstance();
	
	$n = $cnn->exec($sqldel);
	
	$sql  = "INSERT INTO siscachesubtipoconsulta(CodTipo, CodSubTipo, DescricaoSubTipo, DataHora) ";
	$sql .= "VALUES(:pCodTipo, :pCodSubTipo, :pDescricaoSubTipo, CURRENT_TIMESTAMP);";
	
	foreach ($sub_tipos_pesquisa as $nodo)
	{
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodTipo", $tipo, PDO::PARAM_INT);
		$cmd->bindParam(":pCodSubTipo", $nodo['id'], PDO::PARAM_INT);
		$cmd->bindParam(":pDescricaoSubTipo", $nodo['nome'], PDO::PARAM_STR);
		$cmd->execute();
		
		if ($cmd->errorCode() != Comuns::QUERY_OK)
		{
			print_r($cmd->errorInfo());
		}
		
		$cmd->closeCursor();
	}
	Log::RegistraLog("Cache dos Subtipos de pesquisa ao SIAP criado");
}

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$ret = "";
	
	$cnn = Conexao2::getInstance();
	$cmd = $cnn->prepare("select Valor from sisparametros where Nome = 'URLWebServiceSIAP';");
	$cmd->execute();
	$UrlWS = $cmd->fetchColumn();
	$cmd->closeCursor();
	
	$cmd = $cnn->prepare("select Valor from sisparametros where Nome = 'URLSIAP';");
	$cmd->execute();
	$UrlSIAP = $cmd->fetchColumn();
	$cmd->closeCursor();
	
	//$ws = new WebServiceClient('http://siap.ufcspa.edu.br/ws/siap_ws.php?wsdl');
	$ws = new WebServiceClient($UrlWS);
	if (!$ws)
	{
		$ret = "@lng[Erro ao conectar o banco de imagens. Detalhes:]" . " " . $ws->getErro();
	}
	else
	{
		if (!isset($_REQUEST['r']))
		{
			$rotina = "tipos";
		}
		else
		{
			$rotina = $_REQUEST['r'];
		}
		
		if ($rotina == "tipos")
		{
			$search_types = $ws->call_soap_method('get_search_types', array());
			
			if ($search_types)
			{
				$opcoes = '<option value="">@lng[Selecione]</option>';
				
				foreach ($search_types as $nodo)
				{
					$opcoes .= '<option value="' . $nodo['id'] . '">' . $nodo['nome'] . '</option>';
				}
				$ret = $opcoes;
			}
			else
			{
				Log::RegistraLog("ERRO. Não foi possível carregar os Tipos de pesquisa ao SIAP", true);
				$ret = 'ERRO: @lng[Não foi possível carregar os Tipos de pesquisa ao banco de imagens. Tente novamente em alguns minutos.]<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Tentar novamente]</a>';
			}
		}
		else if ($rotina == "subtipos")
		{
			$codigo_search = array("search_type" => $_REQUEST['selTipos']);
			$search_sub_types = $ws->call_soap_method('get_search_type_keywords', $codigo_search);
			
			if ($search_sub_types)
			{
				$opcoes = '<option value="">@lng[Selecione]</option>';
				
				foreach ($search_sub_types as $nodo)
				{
					$opcoes .= '<option value="' . $nodo['id'] . '">' . $nodo['nome'] . '</option>';
				}
				$ret = $opcoes;
			}
			else
			{
				Log::RegistraLog("ERRO. Não foi possível carregar os Subtipos de pesquisa ao SIAP", true);
				$ret = 'ERRO: @lng[Não foi possível carregar os Subtipos de pesquisa ao banco de imagens. Tente novamente em alguns minutos.]<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Tentar novamente]</a>';
			}
		}
		else if ($rotina == "imagens")
		{
			if (urldecode($_REQUEST['type_key']) == "Sistema")
			{
				$parametros = array('search_request' => array(
					"palavra" => ((!isset($_REQUEST['txtPalavraChave'])) ? '' : $_REQUEST['txtPalavraChave']),
					"sistema" => $_REQUEST['selSubTipos'],
					"procedencia" => "",
					"patologia" => ""
				));
			}
			else if ($_REQUEST['type_key'] == "Procedência")
			{
				$parametros = array('search_request' => array(
					"palavra" => ((!isset($_REQUEST['txtPalavraChave'])) ? '' : $_REQUEST['txtPalavraChave']),
					"sistema" => "",
					"procedencia" => $_REQUEST['selSubTipos'],
					"patologia" => ""
				));
			}
			else if ($_REQUEST['type_key'] == "Patologia")
			{
				$parametros = array('search_request' => array(
					"palavra" => ((!isset($_REQUEST['txtPalavraChave'])) ? '' : $_REQUEST['txtPalavraChave']),
					"sistema" => "",
					"procedencia" => "",
					"patologia" => $_REQUEST['selSubTipos']
				));
			}
			
			$nmax = $_REQUEST['nmax'];
			
			try
			{
				$list_images = $ws->call_soap_method('search', $parametros);
			}
			catch (Exception $e)
			{
				Log::RegistraLog("ERRO: O servidor do banco de imagens não respondeu no tempo máximo de 60 segundos. Detalhes: " . $e->getMessage(), true);
				$ret = 'ERRO: @lng[O servidor do banco de imagens não respondeu no tempo máximo de 60 segundos.]<br /><br />@lng[Tente repetir a consulta.]';
			}
			
			if ($list_images)
			{
				$opcoes = '';
				if (count($list_images) < $nmax)
					$nmax = count($list_images);
				
				for ($i = 0; $i < $nmax; $i++)
				{
					$UrlImg = $UrlSIAP . substr($list_images[$i]['url'], stripos($list_images[$i]['url'], "upload"));
					
					$opcoes .= '<div class="find-result">';
					$opcoes .= '  <input type="checkbox" name="chkUsar[]" id="chkUsar_' . $i . '" value="' . base64_encode($UrlImg . "::::" . $list_images[$i]['nome']) . '" class="campo" />@lng[Selecionar]<br />';
					$opcoes .= '  <img src="' . str_replace("/sis_imagem/","/sis_imagem_p/", $UrlImg) . '" class="img-preview-2" title="' . $list_images[$i]['nome'] . '" alt="' . $list_images[$i]['nome'] . '">';
					$opcoes .= '</div>';
				}
				$opcoes .= '<input type="hidden" name="hdnHorigem" id="hdnHorigem" value="banco" class="campo" />';
				$ret = $opcoes;
			}
			else
			{
				if ($ws->getErro() != "")
				{
					Log::RegistraLog("ERRO. Erro ao consulta imagens do SIAP. Detalhes: " . $ws->getErro(), true);
					$ret = 'ERRO: @lng[Não foi possível realizar a pesquisa no banco de imagens. Detalhes do erro:] ' . $ws->getErro() . '.<br /><br />@lng[Tente novamente em alguns minutos.]<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Tentar novamente]</a>';
				}
				else
				{
					$ret = "@lng[Nenhum item encontrado com a pesquisa realizada]";
				}
			}
		}
	}
	
	echo( Comuns::Idioma($ret) );
}

Main()

?>