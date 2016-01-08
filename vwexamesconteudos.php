<?php
//--utf8_encode --
session_start();
include_once 'cls/menus.class.php';
include_once 'cls/caminhos.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/exame.class.php';
include_once 'cls/conteudo.class.php';
include_once 'cls/midia.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	if ((isset($_SESSION['caso'])) && ($_SESSION['caso'] > 0))
	{
		$u = unserialize($_SESSION['usu']);
		$menu = Menus::MenusConteudosExames();
		
		$e = new Exame();
		$c = new Conteudo();
		
		//$rsbaterias = $e->ListaRecordSetBaterias($_SESSION['caso']);
		$rsexames = $e->ListaRecordSet($_SESSION['caso']);
		$rsconteudos = $c->ListaRecordSet($_SESSION['caso']);
		$javinculados = $e->ListaConteudosVinculados($_SESSION['caso']);
		$javinculados .= $e->ListaMidiasVinculados($_SESSION['caso']);
		
		// Opções das baterias
		if (count($rsexames) > 0)
		{
			$options = '<option value="">@lng[Selecione]</option>';
			
			foreach ($rsexames as $item)
			{
				$options .= '<option value="' . base64_encode($item->CodExame) . '">' . $item->Descricao . '</option>';
			}
		}
		else
		{
			$options .= '<option value="">@lng[Nenhum bateria encontrada]</option>';
		}
		
		// Opções dos conteudos
		$numReg = 0;
		$optconteudos = '<option value="">@lng[Selecione]</option>';
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
		$m = new Midia();
		$m->setCodCaso($_SESSION['caso']);
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
		
		$tpl = file_get_contents("tpl/frm-cad-cont-exames.html");
		//$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($u), $tpl);
		$tpl = str_replace("<!--itens-toolbar-->", $menu, $tpl);
		$tpl = str_replace("<!--selExames-->", $options, $tpl);
		$tpl = str_replace("<!--selConteudos-->", $optconteudos, $tpl);
		$tpl = str_replace("<!--jaVinculados-->", $javinculados, $tpl);
		//$tpl = str_replace("<!--caminho-->", Caminhos::MontaCaminhoExamesConteudos(), $tpl);
		
		echo($tpl);
	}
	else
	{
		echo("@lng[Caso de estudo não encontrado]");
	}
}

if (Comuns::EstaLogado())
{
	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}

?>