<?php
//--utf8_encode --
include_once 'cls/conexao.class.php';
include_once 'inc/comuns.inc.php';

class TipoValorReferencia
{
	public static function RetornaSelect($sel = 0)
	{
		$sql  = "SELECT Codigo, Descricao ";
		$sql .= "FROM mestipovalorreferencia";
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->execute();
		
		while ($tipo = $cmd->fetch(PDO::FETCH_OBJ))
		{
			$opts .= '<option value="' . $tipo->Codigo . '"' . (($tipo->Codigo == $sel) ? ' selected': '') . '>' . $tipo->Descricao . '</option>';
		}
		
		return $opts;
	}
}

?>