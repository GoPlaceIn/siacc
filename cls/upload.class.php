<?php
//--utf8_encode --
include_once 'cls/log.class.php';

class Upload
{
	private $tipo;
	private $nome;
	private $diretorio;
	private $maxsize;
	private $arquivo;
	private $status;
	
	public function getFullPath()
	{
		return $nomefinal = $this->diretorio . '/' . $this->nome . '.' . $this->getExtensao();
	}
	
	public function getExtensao()
	{
		// Recupera extensão do arquivo
		preg_match("/\.(gif|bmp|png|jpg|jpeg|mp3|wma|wav|wmv|asx|flv|mov|swf|mpg|mpeg|mp4|rmvb|rmv|doc|docx|pdf|xls|xlsx|ppt|pptx){1}$/i", $this->arquivo["name"], $ext);
		
		return $ext[1];
	}
	
	public function getOriginalFullName()
	{
		return $this->arquivo["name"];
	}
	
	public function getNewFullName()
	{
		return $this->nome . "." . $this->getExtensao();
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function getTipo()
	{
		return $this->arquivo["type"];
	}
	
	public function setTipo($p_tipo)
	{
		$this->tipo = $p_tipo;
	}
	
	public function setNome($p_nome)
	{
		$this->nome = $p_nome;
	}
	
	public function setDestino($p_destino)
	{
		$this->diretorio = $p_destino;
	}
	
	public function setMaxSize($p_maxsize)
	{
		$this->maxsize = $p_maxsize;
	}
	
	public function setArquivo($p_file)
	{
		$this->arquivo = $p_file;
	}
		
	public function RealizaUpload()
	{
		try
		{
			$nomefinal = $this->getFullPath();
			
			$this->CriaDiretorio($this->diretorio);
			
			move_uploaded_file($this->arquivo["tmp_name"], $nomefinal);
			
			$this->status = "OK";
			return true;
		}
		catch (Exception $e)
		{
			$this->status = $e->getMessage();
			return false;
		}
	}

	public function RealizaTrocaImagem($atual)
	{
		if (isset($this->arquivo))
		{
			try
			{
				move_uploaded_file($this->arquivo["tmp_name"], $atual);
				
				$this->status = "OK";
				return true;
			}
			catch (Exception $e)
			{
				$this->status = $e->getMessage();
				return false;
			}
		}
		else
		{
			$this->status = "@lng[Arquivo não informado]";
			return false;
		}
	}
	
	public function ValidaImagem($mime_type)
	{
		if(!eregi("^image\/(pjpeg|jpeg|png|gif)$", $mime_type))
		{
			Log::RegistraLog("ERRO: MIME Type do imagem enviado inválido: " . $mime_type);
			$this->status = "@lng[Tipo de arquivo enviado inválido. Envie jpeg, gif, png]";
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function ValidaAudio($mime_type)
	{
		//audio/mp3
		//audio/wav
		//audio/x-ms-wma
		if(!eregi("^audio\/(mp3|wav|x-ms-wma)$", $mime_type))
		{
			Log::RegistraLog("ERRO: MIME Type do audio enviado inválido: " . $mime_type);
			$this->status = "@lng[Tipo de arquivo enviado inválido. Envie mp3, wav e wma]";
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function ValidaVideo($mime_type)
	{
		//video/mpeg
		//video/x-ms-wmv
		//video/x-flv
		//application/x-shockwave-flash
		//vídeo/x-ms-asf
		//video/quicktime
		//video/mp4
		
		if(!eregi("^video\/(mpeg|x-ms-wmv|x-flv|x-ms-asf|quicktime|mp4)$", $mime_type))
		{
			if(!eregi("^application\/(x-shockwave-flash)$", $mime_type))
			{
				Log::RegistraLog("ERRO: MIME Type do vídeo enviado inválido: " . $mime_type);
				$this->status = "@lng[Tipo de arquivo inválido. Envie mpg, mpeg, wmv, flv, asx, mov e swf]";
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	
	public function ValidaDocumento($mime_type)
	{
		//application/pdf
		//application/vnd.ms-excel
		//application/vnd.ms-powerpoint
		//application/x-dot
		//application/msword
		//application/vnd.openxmlformats-officedocument.wordprocessingml.document
		//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
		//application/vnd.openxmlformats-officedocument.presentationml.presentation
		if(!eregi("^application\/(pdf|vnd.ms-excel|vnd.ms-powerpoint|x-dot|msword|vnd.openxmlformats-officedocument.wordprocessingml.document|vnd.openxmlformats-officedocument.spreadsheetml.sheet|vnd.openxmlformats-officedocument.presentationml.presentation)$", $mime_type))
		{
			Log::RegistraLog("ERRO: MIME Type do documento enviado inválido: " . $mime_type);
			$this->status = "@lng[Tipo de arquivo inválido. Envie doc, docx, xls, xlsx, ppt, pptx e pdf]";
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function CriaDiretorio($caminho)
	{
		try
		{
			$pastas = split("/", $caminho);
			$atual = "files";
			
			for ($i = 1; $i < count($pastas); $i++)
			{
				$atual .= ($atual != "" ? "/" : "") . $pastas[$i];
				if (!file_exists($atual))
				{
					mkdir($atual);
				}
			}
		}
		catch (Exception $e)
		{
			$this->status = $e->getMessage();
		}
	}
	
	public function DeletaArquivo($arquivo)
	{
		try
		{
			if (file_exists($arquivo))
			{
				unlink($arquivo);
			}
			return true;
		}
		catch (Exception $ex)
		{
			$this->status = $ex->getMessage();
			return false;
		}
	}
	
	public function CopiaArquivoWeb($origem, $destino)
	{
		copy($origem, $destino);
	}
	
}

?>