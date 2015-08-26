<?php
session_start();
include_once 'cls/midia.class.php';
include_once 'inc/comuns.inc.php';

$output = '';
$output .= 'var tinyMCEImageList = new Array(';

if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
{
	$mid = new Midia();
	$tipo = $_GET['type'];
	
	$mid->setCodCaso($_SESSION['caso']);
	
	switch ($tipo)
	{
		case "img":
			$lista_midias = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_IMAGEM);
			break;
		case "vid":
			$lista_midias = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_VIDEO);
			break;
		case "aud":
			$lista_midias = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_AUDIO);
			break;
	}
	
	/*
	 * necessario criar uma lista com:
		Nome para apresentar na combo, URL
	        ["Imagem 1", "imagem/img01.jpg"],
	        ["Imagem 2", "imagem/img02.jpg"]
	 */
	if ($lista_midias)
	{
		//$tabmidias = Comuns::TopoTabelaListagem("", "tabMidias", array('&nbsp;', 'Midia', 'Tipo'));
		$outputLoc = '';
		foreach ($lista_midias as $midia)
		{
			$outputLoc .= (($outputLoc!='') ? ',' : '') . '["' . $midia->Descricao . '", "' . $midia->url . '"]';
		}
		if($outputLoc == '')
		{
			$outputLoc .= '["@lng[Sem mídia cadastrada]", ""]';
		}
	}
	else
	{
		$outputLoc .= '["@lng[Sem mídia cadastrada]", ""]';
	}
}
else
{
	$outputLoc .= '["@lng[Caso não definido]", ""]';
}
$output .= $outputLoc . ');';

header('Content-type: text/javascript');
header('pragma: no-cache');
header('expires: 0');
echo $output;

?>