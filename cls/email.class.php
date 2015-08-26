<?php

class Email
{
	private $remetente;
	private $destinatarios;
	private $assunto;
	private $mensagem;
	
	public function __construct()
	{
		$this->remetente = null;
		$this->destinatarios = null;
		$this->assunto = null;
		$this->mensagem = null;
	}
	
	public function getRemetente()
	{
		return $this->remetente;
	}
	
	public function setRemetente($p_remetente)
	{
		$this->remetente = $p_remetente;
	}
	
	public function getDestinatarios()
	{
		return $this->destinatarios;
	}
	
	public function getDestinatariosEnviar()
	{
		$destino = "";
		foreach ($this->destinatarios as $endereco)
		{
			$destino .= ($destino != "" ? ", " : "") . $endereco;
		}
		return $destino;
	}
	
	/**
	 * Destinatario ou destinatarios que receberão o email
	 * @param 	array	$p_destinatario	Nome <email@dominio.com> ou somente email@dominio.com
	 * @access	public 
	 * */
	public function setDestinatario($p_destinatario)
	{
		$this->destinatarios[] = $p_destinatario;
	}
	
	public function getAssunto()
	{
		return $this->assunto;
	}
	
	public function setAssunto($p_assunto)
	{
		$this->assunto = $p_assunto;
	}
	
	public function getMensagem()
	{
		return $this->mensagem;
	}
	
	public function setMensagem($p_mensagem)
	{
		$this->mensagem = $p_mensagem;
	}
	
	public function Enviar()
	{
		if (!$this->destinatarios)
			return false;
		
		if (!$this->assunto)
			return false;
		
		if (!$this->remetente)
			return false;
		
		if (!$this->mensagem)
			return false;
		
		$headers  = "From: " . $this->remetente . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		
		return mail($this->getDestinatariosEnviar(), $this->assunto, $this->mensagem, $headers);
	}
	
}

?>