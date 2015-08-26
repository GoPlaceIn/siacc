<?php
session_start();
include_once('cls/examefisico.class.php');
include_once('inc/comuns.inc.php');

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0))
	{
		try
		{
			$ef = new ExameFisico();
			
			//unset($_SESSION['examefisicoaluno']);
			
			if (! isset($_SESSION['examefisicoaluno']))
			{
				$ef->Carrega($_SESSION['casores']);
				
				$_SESSION['ef_cab'] = nl2br($ef->getCabeca());
				$_SESSION['ef_pes'] = nl2br($ef->getPescoco());
				$_SESSION['ef_cor'] = nl2br($ef->getAuscultacardiaca());
				$_SESSION['ef_pul'] = nl2br($ef->getAuscultapulmonar());
				$_SESSION['ef_abd'] = nl2br($ef->getAbdomen());
				$_SESSION['ef_sin'] = nl2br($ef->getSinaisvitais());
				$_SESSION['ef_pel'] = nl2br($ef->getPele());
				$_SESSION['ef_ext'] = nl2br($ef->getExtremidades());
				$_SESSION['ef_ger'] = nl2br($ef->getEstadoGeral());
				$_SESSION['ef_mid_cab'] = $ef->getMidiasCabeca();
				$_SESSION['ef_mid_pes'] = $ef->getMidiasPescoco();
				$_SESSION['ef_mid_cor'] = $ef->getMidiasAuscultaCardiaca();
				$_SESSION['ef_mid_pul'] = $ef->getMidiasAuscultaPulmonar();
				$_SESSION['ef_mid_abd'] = $ef->getMidiasAbdomen();
				$_SESSION['ef_mid_sin'] = $ef->getMidiasSinaisVitais();
				$_SESSION['ef_mid_pel'] = $ef->getMidiasPele();
				$_SESSION['ef_mid_ext'] = $ef->getMidiasExtremidades();
				$_SESSION['ef_mid_ger'] = $ef->getMidiasEstadoGeral();
				
				$_SESSION['examefisicoaluno'] = "sim";
			}
				
			switch ($_POST['p'])
			{
				case "cab":
					$html = '<strong>@lng[Cabeça]</strong><br /><span>' . $_SESSION['ef_cab'] . '</span>';
					$html .= $_SESSION['ef_mid_cab'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_cab']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "pes":
					$html = '<strong>@lng[Pescoço]</strong><br /><span>' . $_SESSION['ef_pes'] . '</span>';
					$html .= $_SESSION['ef_mid_pes'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_pes']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "cor":
					$html = '<strong>@lng[Ausculta cardiaca]</strong><br /><span>' . $_SESSION['ef_cor'] . '</span>';
					$html .= $_SESSION['ef_mid_cor'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_cor']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "pul":
					$html = '<strong>@lng[Ausculta pulmonar]</strong><br /><span>' . $_SESSION['ef_pul'] . '</span>';
					$html .= $_SESSION['ef_mid_pul'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_pul']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "abd":
					$html = '<strong>@lng[Abdomen]</strong><br /><span>' . $_SESSION['ef_abd'] . '</span>';
					$html .= $_SESSION['ef_mid_abd'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_abd']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "ext":
					$html = '<strong>@lng[Extremidades]</strong><br /><span>' . $_SESSION['ef_ext'] . '</span>';
					$html .= $_SESSION['ef_mid_ext'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_ext']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "pel":
					$html = '<strong>@lng[Pele]</strong><br /><span>' . $_SESSION['ef_pel'] . '</span>';
					$html .= $_SESSION['ef_mid_pel'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_pel']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "sin":
					$html = '<strong>@lng[Sinais vitais]</strong><br /><span>' . $_SESSION['ef_sin'] . '</span>';
					$html .= $_SESSION['ef_mid_sin'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_sin']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
				case "ger":
					$html = '<strong>@lng[Estado geral]</strong><br /><span>' . $_SESSION['ef_ger'] . '</span>';
					$html .= $_SESSION['ef_mid_ger'] > 0 ? '<br /><div class="cont-multimidia"><a href="javascript:void(0);" onclick="javascript:fntCarregaMidias(\'' . base64_encode($_SESSION['ef_mid_ger']) . '\');">' . Comuns::IMG_MIDIA_MULTIMIDIA . '</a></div>' : '';
					break;
			}
		}
		catch (Exception $e)
		{
			$html = "ERRO: " . $e->getMessage();
		}
	}
	else
	{
		$html = "ERRO: @lng[Não foi informado o caso clínico]";
	}
	
	echo(Comuns::Idioma($html));
}

Main();

?>