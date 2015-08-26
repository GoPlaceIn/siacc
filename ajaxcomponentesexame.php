<?php
include_once 'cls/conexao.class.php';
include_once 'cls/tipoexame.class.php';
include_once 'cls/componenteexame.class.php';

include_once 'inc/comuns.inc.php';

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$tpl = file_get_contents("tpl/cad-componenteexame.html");
	
	$codexame = base64_decode($_POST["c"]);
	$registro = base64_decode($_POST['r']);
	
	$tpl = str_replace("<!--hdnCodigoExame-->", $_POST["c"], $tpl);
	$tpl = str_replace("<!--nomeexame-->", TipoExame::ConsultaNomeExame($codexame), $tpl);

	// Lista os componentes já cadastrados
	$componentes = new Componente();
	$componentes->setCodexame($codexame);
	
	if ($registro == "")
	{
		$tpl = str_replace("<!--txtDescricao-->", "", $tpl);
		$tpl = str_replace("<!--hdnCodigoComp-->", "", $tpl);
	}
	else
	{
		$componentes->setCodcomponente($registro);
		
		$retorno = $componentes->Carrega();
		
		$tpl = str_replace("<!--txtDescricao-->", $retorno->getDescricao(), $tpl);
		$tpl = str_replace("<!--hdnCodigoComp-->", base64_encode($retorno->getCodcomponente()), $tpl);
	}
	
	$rs = $componentes->Lista();
	
	if ( count($rs) > 0 )
	{
		$tab = Comuns::TopoTabelaListagem(
			"Componentes cadastrados",
			"componentes",
			array('Descrição', 'Ações')
		);
		
		foreach ($rs as $comp)
		{
			$excri = base64_encode($comp->CodExame);
			$compcri = base64_encode($comp->Codigo);
			
			$tab .= '    <tr id="' . $excri . '_' . $compcri . '">';
			$tab .= '      <td>' . $comp->Descricao . '</td>';
			$tab .= '      <td>';
			$tab .= '        <a href="javascript:void(0);" onclick="javascript:fntEditaComponente(\'' . $excri . '\',\'' . $compcri . '\');">' . Comuns::IMG_ACAO_EDITAR . '</a>';
			$tab .= '        <a href="javascript:void(0);" onclick="javascript:fntDeletaComponente(\'' . $excri . '\',\'' . $compcri . '\')">' . Comuns::IMG_ACAO_DELETAR . '</a>';
			$tab .= '        <a href="javascript:void(0);" onclick="javascript:fntAbreValorRef(\'' . $excri . '\',\'' . $compcri . '\')">' . Comuns::IMG_ACAO_VALORES_REF . '</a>';
			$tab .= '        <a href="javascript:void(0);" onclick="javascript:fntMoverComponente(\'' . $excri . '\',\'' . $compcri . '\')">' . Comuns::IMG_ACAO_MOVER . '</a>';
			$tab .= '      </td>';
			$tab .= '    </tr>';
		}
		
		$tab .= '  </tbody>';
		$tab .= '</table>';
	}
	else
	{
		$tab = "<br />@lng[Nenhum componente cadastrado]";
	}
	
	$tpl = str_replace("<!--tabela-->", $tab, $tpl);
	
	echo( Comuns::Idioma($tpl) );
}

Main();

?>