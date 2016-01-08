<?php
//--utf8_encode --
session_start();
include_once 'cls/usuario.class.php';
include_once 'cls/conexao.class.php';
include_once 'cls/midia.class.php';
include_once 'cls/exame.class.php';
include_once('inc/comuns.inc.php');

function Main()
{
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$u = unserialize($_SESSION['usu']);
	$msgRet = "";
	
	if ($u->TemPermissao(26))
	{
		if ($_REQUEST['hdnHorigem'] == "banco")
		{
			foreach ($_REQUEST['chkUsar'] as $imagem)
			{
				$value = base64_decode($imagem);
				$valores = split("::::", $value);
				
				$m = new Midia();
				$m->setCodCaso($_SESSION['caso']);
				$m->setTipoMidia(Comuns::TIPO_MIDIA_IMAGEM);
				$m->setURL($valores[0]);
				$m->setDescricao($valores[1]);
				$m->setComplemento("@lng[Imagem do banco de imagens da UFCSPA]");
				$m->setOrigem("banco");
				if (!$m->Insere())
				{
					$msgRet = "ERRO: " . $m->getErro();
				}
				else
				{
					if ($_POST['txtTipo'] == "exame")
					{
						$e = new Exame();
						// Se tem alguma indicação de que seja um exame, então grava na tabela de exames
						if ($e->InsereImagemExame($_SESSION['caso'], $_SESSION['exame'], $m->getCodMidia(), $m->getDescricao(), $m->getComplemento(), $m->getOrigem()))
						{
							Log::RegistraLog('@lng[Realizado upload da imagem] ' . $m->getURL() . ' - ' . $m->getDescricao());
							$msgRet = '@lng[Realizado upload da imagem] ' . $m->getURL() . ' - ' . $m->getDescricao();
						}
						else
						{
							Log::RegistraLog('@lng[Falha ao realizar upload da imagem]' . $m->getURL() . ' - ' . $m->getDescricao() . '. @lng[Detalhes:] ' . $e->getErro(), true);
							$m->Deteta();
							$up->DeletaArquivo($up->getFullPath());
							$msgRet = '@lng[Não foi possível cadastrar a imagem] ' . $m->getURL() . '. @lng[Detalhes:] ' . $e->getErro() . '<br /><br /><a href="vwuploaddetalhe.php?type=img">@lng[Voltar]</a>';
						}
					}
					else
					{
						$msgRet = "@lng[Imagem carregada]";
					}
				}
			}
		}
		else
		{
			$msgRet = "ERRO: @lng[Origem inválida]";
		}
	}
	else
	{
		$msgRet = "ERRO: @lng[Usuário sem permissão para cadastrar imagens]";
	}
	
	echo( Comuns::Idioma($msgRet));
}

Main();

?>