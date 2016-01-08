<?php
//--utf8_encode --
session_start();
include_once 'cls/conexao.class.php';
include_once 'cls/resolucao.class.php';
include_once 'cls/log.class.php';
include_once 'cls/usuario.class.php';
include_once 'cls/components/hashtable.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	//header('Content-Type: text/html; charset=iso-8859-1');
	
	if ((isset($_SESSION['casores'])) && ($_SESSION['casores'] > 0))
	{
		if ($_POST['k'])
		{
			$idnodo = $_POST['k'];
			
			$res = new Resolucao();
			$res->setCodcaso($_SESSION['casores']);
			
			$hash = $res->BuscaConteudoPelaChave($idnodo);
			
			if ($hash != false)
			{
				$res->RegistraVisitaNodo($idnodo);
				
				if ($hash->ContainsKey("fim"))
				{
					if ($hash->getValue("fim") == "S")
					{
						// É fim do caso. Deve atualizar status
						$u = unserialize($_SESSION['usu']);
						$res->setCodusuario($u->getCodigo());
						$res->setCodresolucao($_SESSION['codresolucao']);
						
						if (!$res->ConcluiResolucao())
						{
							echo($res->getErro());
						}
					}
				}
				echo( Comuns::Idioma($hash->ToXML()) );
			}
			else
			{
				die(Comuns::Idioma("ERRO: @lng[hash retornou false]"));
			}
		}
		else
		{
			die(Comuns::Idioma("ERRO: @lng[Conteúdo não informado]"));
		}
	}
	else
	{
		die(Comuns::Idioma("ERRO: @lng[Caso não encontrado]"));
	}
}

Main();

?>