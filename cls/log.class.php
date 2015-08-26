<?php
session_start();

include_once 'cls/conexao.class.php';
include_once 'cls/usuario.class.php';
include_once 'inc/comuns.inc.php';

class Log
{
	
	/**
	 * Registra um evento ocorrido no sistema
	 * @param $evento string : O evento ocorrido
	 * @param $erro bool : Se o evento é um erro 
	 */
	public static function RegistraLog($evento, $erro = false)
	{
		$u = unserialize($_SESSION['usu']);
		$incase = -1;

		$datahora = date("Y-m-d H:i:s");
		
		$sqlultimo  = "select Contador, CodAcesso, Acao, DataHora ";
		$sqlultimo .= "from mesusuariologacoes ";
		$sqlultimo .= "where CodAcesso = :pCodAcesso ";
		$sqlultimo .= "  and Contador =( ";
		$sqlultimo .= "		select max(Contador) ";
		$sqlultimo .= "		from mesusuariologacoes ";
		$sqlultimo .= "		where CodAcesso = :pCodAcesso);";
		
		$cnn = Conexao2::getInstance();
		
		$cmdultimo = $cnn->prepare($sqlultimo);
		if ($u)
			$cmdultimo->bindParam(":pCodAcesso", $u->getIdAcessoAtual(), PDO::PARAM_INT);
		else
			$cmdultimo->bindParam(":pCodAcesso", $incase, PDO::PARAM_INT);
		
		$cmdultimo->execute();
		
		if ($cmdultimo->rowCount() > 0)
		{
			$ultimaacao = $cmdultimo->fetchColumn(2);
			
			if ($ultimaacao != $evento)
			{
				$faz = true;
			}
			else
			{
				$faz = false;
			}
		}
		else
		{
			$faz = true;
		}
		
		if ($faz)
		{
			$sql  = "INSERT INTO mesusuariologacoes(CodAcesso, Acao, DataHora, Erro) ";
			$sql .= "VALUES(:pCodAcesso, :pAcao, :pDataHora, :pErro);";
			
			$falha = ($erro ? 1 : 0);
			
			$cmd = $cnn->prepare($sql);
			if ($u)
				$cmd->bindParam(":pCodAcesso", $u->getIdAcessoAtual(), PDO::PARAM_INT);
			else
				$cmd->bindParam(":pCodAcesso", $incase, PDO::PARAM_INT);
			$cmd->bindParam(":pAcao", $evento, PDO::PARAM_STR);
			$cmd->bindParam(":pDataHora", $datahora, PDO::PARAM_STR);
			$cmd->bindParam(":pErro", $falha, PDO::PARAM_INT);
			
			$cmd->execute();
			
			if ($cmd->errorCode() != Comuns::QUERY_OK)
			{
				$msg = $cmd->errorInfo();
				echo($msg[2]);
			}
		}
	}
	
	public static function DetalhaLog($idacesso)
	{
		$u = unserialize($_SESSION['usu']);
		
		$sql  = "select  acoes.CodAcesso, acessos.CodUsuario, usuario.NomeCompleto, acoes.Acao, acoes.DataHora ";
		$sql .= "		,case when acessos.Host is null then '' else acessos.Host end AS Host ";
		$sql .= "from mesusuariologacoes acoes ";
		$sql .= "inner join mesacessousuario acessos ";
		$sql .= "		on acessos.numacesso = acoes.codacesso ";
		$sql .= "inner join mesusuario usuario ";
		$sql .= "		on usuario.codigo = acessos.codusuario ";
		$sql .= "where CodAcesso = :pCodAcesso ";
		$sql .= "order by DataHora desc";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodAcesso", $idacesso, PDO::PARAM_INT);
		
		$cmd->execute();
		
		if ($cmd->rowCount() > 0)
		{
			$ret = Comuns::TopoTabelaListagem(
				"Ações realizadas", 
				"actrealizadas", 
				array("Usuário", "Ação", "Data/Hora", "Host")
			);
			
			while ($linha = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$ret .= '<tr>';
				$ret .= '  <td>' . $linha->NomeCompleto . '</td>';
				$ret .= '  <td>' . $linha->Acao . '</td>';
				$ret .= '  <td>' . date('d/m/Y H:i:s', strtotime($linha->DataHora)) . '</td>';
				$ret .= '  <td>' . $linha->Host . '</td>';
				$ret .= '</tr>';
			}
			
			$ret .= '</tbody></table>';
		}
		else
		{
			$ret = "Falha ao recuperar detalhes";
		}
		
		$cmd->closeCursor();
		
		return $ret;
	}
}

?>