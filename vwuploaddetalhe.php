<?php
session_start();
include_once 'cls/midia.class.php';
include_once 'inc/comuns.inc.php';

function fntRetornaTemplate()
{
	if ((!isset($_REQUEST['type'])) || (is_null($_REQUEST['type'])) || ($_REQUEST['type'] == ""))
	{
		$tipo = "img";
	}
	else
	{
		$tipo = $_REQUEST['type'];
	}
	
	if ($tipo == "img")
	{
		$tpl = file_get_contents("tpl/caso-upload-exame.html");
		
		//busca mídias para carregar na aba de mídias internas
		$mid = new Midia();
	
		$mid->setCodCaso($_SESSION['caso']);
		$lista_midias = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_IMAGEM);
		
		$lista = '';
		if ($lista_midias)
		{
			foreach ($lista_midias as $midia)
			{
				$lista .= '<div class="selecDasMidias">';
				$lista .= '	<label for="chk' . $midia->CodMidia . '">';
				$lista .= '		<input type="checkbox" class="campo" name="chkDasMidias[]" id="chk' . $midia->CodMidia . '" value="' . base64_encode($midia->CodMidia) . '" />';
				$lista .= '		<span>' . $midia->Descricao . '</span>';
				$lista .= '	</label>';
				$lista .= '	<br />';
				$lista .= '	<img src="' . $midia->url . '" alt="' . $midia->Descricao . '" title="' . $midia->Descricao . '" />';
				$lista .= '</div>';
			}
		}
		else
		{
			$lista .= '@lng[Sem mídia cadastrada]';
		}
		
		$tpl = str_replace("<!--strMidiasInternas-->", $lista, $tpl);
	}
	else if ($tipo == "som")
	{
		$tpl = file_get_contents("tpl/caso-upload-audio.html");
	}
	else if ($tipo == "vid")
	{
		$tpl = file_get_contents("tpl/caso-upload-video.html");
		$tpl = str_replace("<!--Listararquivos-->", "", $tpl);
	}
	else if ($tipo == "doc")
	{
		$tpl = file_get_contents("tpl/caso-upload-documento.html");
		
		//busca mídias para carregar na aba de mídias internas
		$mid = new Midia();
	
		$mid->setCodCaso($_SESSION['caso']);
		$lista_midias = $mid->ListaRecordSetPorTipo(Comuns::TIPO_MIDIA_DOCUMENTO);
		
		$lista = '';
		if ($lista_midias)
		{
			foreach ($lista_midias as $midia)
			{
				$lista .= '<div class="selecDasMidias">';
				$lista .= '	<label for="chk' . $midia->CodMidia . '">';
				$lista .= '		<input type="checkbox" class="campo" name="chkDasMidias[]" id="chk' . $midia->CodMidia . '" value="' . base64_encode($midia->CodMidia) . '" />';
				$lista .= '		<span>' . $midia->Descricao . '</span>';
				$lista .= '	</label>';
				$lista .= '</div>';
			}
		}
		else
		{
			$lista .= '@lng[Sem mídia cadastrada]';
		}
		
		$tpl = str_replace("<!--strMidiasInternas-->", $lista, $tpl);
	}
	
	$tpl = str_replace("<!--txtTipo-->", $_GET['o'] == 1 ? "conteudo" : "exame", $tpl);
	echo( Comuns::Idioma($tpl) );
}

function fntRetornaTemplateEditar()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] != 0))
	{
		$mid = new Midia();
		$mid->setCodCaso($_SESSION['caso']);
		$mid->setCodMidia(base64_decode($_POST['img']));
		
		if($mid->CarregaPorCodigoEspecifico())
		{
			$tpl = file_get_contents("tpl/caso-edita-midia.html");
			
			$tpl = str_replace("<!-- idMidia -->", $_POST['img'], $tpl);
			$tpl = str_replace("<!-- txtURL -->", $mid->getURL(), $tpl);
			$tpl = str_replace("<!-- txtDescricao -->", $mid->getDescricao(), $tpl);
			$tpl = str_replace("<!-- txtComplemento -->", $mid->getComplemento(), $tpl);
			$tpl = str_replace("<!-- txtLargura -->", $mid->getLargura(), $tpl);
			$tpl = str_replace("<!-- txtAltura -->", $mid->getAltura(), $tpl);
			header('Content-Type: text/html; charset=iso-8859-1');
		}
		else
		{
			$tpl = "@lng[Não será possível carregar a mídia.]";
		}
	}
	else
	{
		$tpl = "@lng[Não será possível carregar a mídia (caso).]";
	}
	echo( Comuns::Idioma($tpl) );
}

function fntRetornaImagemURLWeb()
{
	if ($_REQUEST['urlimg'])
	{
		$sURL = $_REQUEST['urlimg'];
		$img = file_get_contents($sURL);
	}
}

function Main()
{
	if ((!isset($_REQUEST['act'])) || (is_null($_REQUEST['act'])) || ($_REQUEST['act'] == ""))
	{
		if ($_POST['img'])
		{
			fntRetornaTemplateEditar();
		}
		else
		{
			fntRetornaTemplate();
		}
	}
	else
	{
		switch ($_REQUEST['act'])
		{
			case "cURLWebImg":
				fntRetornaImagemURLWeb();
				break;
		}
	}
}

Main();

?>