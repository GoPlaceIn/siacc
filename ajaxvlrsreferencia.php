<?php
//--utf8_encode --
include_once 'cls/tipoexame.class.php';
include_once 'cls/componenteexame.class.php';
include_once 'cls/valref.class.php';
include_once 'cls/tipovalref.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$tpl = file_get_contents("tpl/cad-valoresreferencia.html");
	
	// Pode ser que o componente do exame seja zero.
	// Isso indica um exame sem componentes 
	$codexame = base64_decode($_POST['e']);
	$codcompo = base64_decode($_POST['c']);
	$registro = base64_decode($_POST['r']);
	
	$nomepai = "";
	
	if ($codcompo == 0)
	{
		$nomepai = TipoExame::ConsultaNomeExame($codexame);
		$tipo = "exame";
	}
	else
	{
		$nomepai = Componente::ConsultaNomeComponente($codexame, $codcompo);
		$tipo = "componente";
	}
	
	$tpl = str_replace("<!--hdnCodigoExame-->", $_POST["e"], $tpl);
	$tpl = str_replace("<!--hdnCodigoCompo-->", $_POST["c"], $tpl);
	$tpl = str_replace("<!--nomeexame-->", $nomepai, $tpl);
	$tpl = str_replace("<!--tipo-->", $tipo, $tpl);
	
	$valref = new ValorReferencia();

	$valref->setCodexame($codexame);
	$valref->setCodcomponente($codcompo);

	if ($registro == "")
	{
		$tpl = str_replace("<!--txtAgrupador-->", "", $tpl);
		$tpl = str_replace("<!--txtValMin-->", "", $tpl);
		$tpl = str_replace("<!--txtValMax-->", "", $tpl);
		$tpl = str_replace("<!--txtValIgual-->", "", $tpl);
		$tpl = str_replace("<!--txtUnidMedida-->", "", $tpl);
		$tpl = str_replace("<!--opcoestipovalor-->", TipoValorReferencia::RetornaSelect(0), $tpl);
		$tpl = str_replace("<!--chkmarcado-->", "", $tpl);
	}
	else
	{
		if ($registro == "--")
			$valref->setAgrupador("");
		else
			$valref->setAgrupador($registro);
		
		$retorno = $valref->Carrega();
		
		$tpl = str_replace("<!--txtAgrupador-->", $retorno->getAgrupador(), $tpl);
		$tpl = str_replace("<!--txtValMin-->", $retorno->getVlrminimo(), $tpl);
		$tpl = str_replace("<!--txtValMax-->", $retorno->getVlrmaximo(), $tpl);
		$tpl = str_replace("<!--txtValIgual-->", $retorno->getVlrminimo(), $tpl);
		$tpl = str_replace("<!--txtUnidMedida-->", $retorno->getUnidadeMedida(), $tpl);
		$tpl = str_replace("<!--opcoestipovalor-->", TipoValorReferencia::RetornaSelect($retorno->getTipo()), $tpl);
		if ($retorno->getTemagrupador() == 1)
		{
			$tpl = str_replace("<!--chkmarcado-->", "", $tpl);
		}
		else
		{
			$tpl = str_replace('<!--chkmarcado-->', 'checked="checked"', $tpl);
		}
	}
	
	$rs = $valref->Lista();
	
	if (count($rs) > 0)
	{
		$tab = Comuns::TopoTabelaListagem(
			"Valores de referência",
			"valref",
			array('Agrupador', 'Referência', 'Unid. Medida', 'Ações')
		);
		
		foreach ($rs as $reg)
		{
			$cri_codexame = base64_encode($reg->CodExame);
			$cri_codcompo = base64_encode($reg->CodComponente);
			$cri_agrupador = base64_encode($reg->Agrupador);
			
			$tab .= '    <tr>';
			$tab .= '      <td>' . $reg->Agrupador . '</td>';
			$tab .= '      <td>' . $reg->Descricao . '</td>';
			$tab .= '      <td>' . $reg->UnidadeMedida . '</td>';
			$tab .= '      <td>';
			$tab .= '        <a href="javascript:void(0);" onclick="javascript:fntEditaValorRef(\'' . $cri_codexame . '\',\'' . $cri_codcompo . '\', \'' . $cri_agrupador . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
			$tab .= '        <a href="javascript:void(0);" onclick="javascript:fntDeletaValorRef(\'' . $cri_codexame . '\',\'' . $cri_codcompo . '\', \'' . $cri_agrupador . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>';
			$tab .= '      </td>';
			$tab .= '    </tr>';
		}
		
		$tab .= '  </tbody>';
		$tab .= '</table>';
	}
	else
	{
		$tab = "<br />@lng[Nenhum valor de referência cadastrado]";
	}
	
	$tpl = str_replace("<!--tabela-->", $tab, $tpl);
	
	echo(Comuns::Idioma($tpl));
}

Main()

?>