<?php
session_start();
require_once 'cls/usuario.class.php';

function Main()
{
	header('Content-Type: text/html; charset=utf-8');
	
	$usuario = $_POST["txtUsuario"];
	$senha = $_POST["txtSenha"];

	if (isset($usuario) && $usuario != "")
	{
		if (isset($senha) && $senha != "")
		{
			$senha = md5($senha);
			if (Usuario::ValidaLogin($usuario, $senha))
			{
				$u = new Usuario();
				$u->Carrega($usuario);
				try
				{
					$id = $u->RegistraAcesso();
					$u->setLogado(true);
					$u->setIdAcessoAtual($id);
					setcookie('siacc_lang', $u->getCodIdioma(), (time()+60*60*24*2)); 
					setcookie('siacc_lang_sigla', $u->getSiglaIdioma(), (time()+60*60*24*2));
					$_SESSION["usu"] = serialize($u);
					
					if ((($u->TemGrupo(1)) || ($u->TemGrupo(4))) && ($u->TemGrupo(2)))
					{
						header("Location:vwopcoeslogin.php");
					}
					else if (($u->TemGrupo(1)) || ($u->TemGrupo(4)))
					{
						/*
						 * 1 - Administradores
						 * 4 - Professores
						 * */
						header("Location:interna.php");
					}
					else
					{
						
						/*
						 * 2 - Aluno
						 * */
						if ($u->TemGrupo(2))
						{
							header("Location:aluno.php");
						}
						else
						{
							$_SESSION['origem'] = "actvalidalogin.php";
							header("Location:ativacao.php");
						}
					}
				}
				catch (Exception $ex)
				{
					$u->setLogado(false);
					$_SESSION["usu"] = null;
					$msg = base64_encode($ex->getMessage());
				}
			}
			else
			{
				$msg = base64_encode("@lng[Usuário ou senha inválidos]");
				header("Location:index.php?m=" . $msg);
			}
		} 
		else
		{
			$msg = base64_encode("@lng[Informe um usuário e uma senha]");
			header("Location:index.php?m=" . $msg);
		}
	}
	else
	{
		$msg = base64_encode("@lng[Informe um usuário e uma senha]");
		header("Location:index.php?m=" . $msg);
	}
}


Main();
?>