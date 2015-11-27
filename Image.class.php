<?php

	

####################################################################################################################
#Image.class.php
#Biblioteca com métodos para redimencionar imagens
#
#Desenvolvido pela Head Trust
#Criado em: (03/06/2008)
#Modificado em: (22/10/2008) - (23/10/2008) - (07/04/2009) - (21/05/2009) - (03/07/2009) - (13/05/2010)
####################################################################################################################

class Image{

	private $pointer = 0, $check;//Gera os ponteiros para trabalhar com várias imagens
	private $image, $width, $height, $mime, $size;//Atributos para informações da imagem de entrada
	private $re_width, $re_height, $re_quality, 
		$re_size, $re_resize, $re_go;//Atributos para o redimensionamento
	private $resource;//Variavel resource da imagem
	
	static $_IMG_RESIZE_PROPORTIONAL = 0, $_IMG_RESIZE_PROPORTIONAL_HEIGHT = 1,
		$_IMG_RESIZE_PROPORTIONAL_WIDTH = 2, $_IMG_RESIZE_FIXED = 3;
	static $_IMG_GO_SMALL = 0, $_IMG_GO_BIG = 1, $_IMG_GO_BOTH = 2;

	public function __construct(){
		ini_set('memory_limit', '128M');
	}
	
	/*
	 * Métodos de limpagem
	 */
	
	//Limpar os valores de um único ponteiro para todos os atributos
	// bool cleanPointer ( int $pointer )
	public function cleanPointer($pointer){
		if($this->check[$pointer] == 'checked'){
			unset($this->check[$pointer], $this->image[$pointer], $this->width[$pointer],
				$this->height[$pointer], $this->mime[$pointer], $this->size[$pointer],
				$this->re_width[$pointer], $this->re_height[$pointer],
				$this->re_quality[$pointer], $this->re_size[$pointer],
				$this->re_resize[$pointer], $this->re_go[$pointer], $this->resource[$pointer]);
			return true;
		} else {
			return false;
		}
	}
	
	//Limpa todos os ponteiros de todos os atributos
	// void cleanAll ( void )
	public function cleanAll(){
		$this->check = array();
		$this->image = array();
		$this->width = array();
		$this->height = array();
		$this->mime = array();
		$this->size = array();
		$this->re_width = array();
		$this->re_height = array();
		$this->re_quality = array();
		$this->re_size = array();
		$this->re_resize = array();
		$this->re_go = array();
		$this->resource = array();
		$this->pointer = 0;
	}
	
	/*
	 * Fim dos métodos de limpagem
	 */
	
	/*
	 * Métodos de controle de uso da classe
	 */
	
	//Cria o ponteiro para o trabalho com várias imagens
	// int pointer ( void )
	protected function pointer(){
		$pointer = ++$this->pointer;
		$this->check[$pointer] = 'checked';
		return $pointer;
	}
	
	/*
	 * Fim dos métodos de controle de uso da classe
	 */
	
	//Recebe a imagem a ser trabalhada e extrai seus atributos
	//int prepareImage ( String $filename )
	public function prepareImage($filename){
		if(file_exists($filename)){
			$info = getimagesize($filename);
			$pointer = $this->pointer();
			$this->image[$pointer] = $filename;
			$this->width[$pointer] = $info[0];
			$this->height[$pointer] = $info[1];
			$this->mime[$pointer] = $info[2];
			$this->size[$pointer] = filesize($filename);
			
			return $pointer;
		} else {
			return false;
		}
	}
	
	//Prepara uma imagem para ser redimensionada
	// bool prepareResize ( int $pointer, int $width, int $height, [ int $quality , [ int $resize , [ int $go ] ] ] )
	public function prepareResize($pointer, $width, $height, $quality = 80, $resize = 0, $go = 2){
		if($this->check[$pointer] == 'checked'){
			$this->re_width[$pointer] = $width;
			$this->re_height[$pointer] = $height;
			$this->re_quality[$pointer] = $quality;
			$this->re_resize[$pointer] = $resize;
			$this->re_go[$pointer] = $go;

			return true;
		} else {
			return false;
		}
	}

	//Faz o redimensionamento da imagem
	// bool createThumbNail ( int $pointer, String $filename )
	public function createThumbNail($pointer, $filename){
		if($this->check[$pointer] == 'checked'){
			
			//Verifica se será feito o redimensionamento
			//Se for permitido tanto expandir como diminuir a imagem
			if($this->re_go[$pointer] == self::$_IMG_GO_BOTH){
				$resize = true;
				
			//Se for permitido somente diminuir a imagem
			} else if($this->re_go[$pointer] == self::$_IMG_GO_SMALL){
				
				//Faz a verificação tanto para altura quanto para largura
				if($this->re_resize[$pointer] == self::$_IMG_RESIZE_PROPORTIONAL){
					$resize = (
						($this->width[$pointer] > $this->re_width[$pointer]) ||
						($this->height[$pointer] > $this->re_height[$pointer])
					) ? true : false;
					
				//Faz a verificação somente para a altura
				} else if($this->re_resize[$pointer] == self::$_IMG_RESIZE_PROPORTIONAL_HEIGHT) {
					$resize = ($this->height[$pointer] > $this->re_height[$pointer]) ? true : false;
				//Faz a verifcação somente para a largura
				} else {
					$resize = ($this->width[$pointer] > $this->re_width[$pointer]) ? true : false;
				}
				
			//Se for permitida somente expandir a imagem
			} else {
				
				//Faz a verificação tanto para altura quanto para largura
				if($this->re_resize[$pointer] == self::$_IMG_RESIZE_PROPORTIONAL){
					$resize = (
						($this->width[$pointer] < $this->re_width[$pointer]) ||
						($this->height[$pointer] < $this->re_height[$pointer])
					) ? true : false;
				
				//Faz a verificação somente para a altura
				} else if($this->re_resize[$pointer] == self::$_IMG_RESIZE_PROPORTIONAL_HEIGHT) {
					$resize = ($this->height[$pointer] < $this->re_height[$pointer]) ? true : false;
				
				//Faz a verifcação somente para a largura
				} else {
					$resize = ($this->width[$pointer] < $this->re_width[$pointer]) ? true : false;
				}
			}
			
			//Caso seja necessário redimensionar
			if($resize){
				
				$array['resource'] = $this->typeCreateImage($pointer);
				$this->resource[$pointer] = $array['resource'];
			
				$properties = $this->properties($pointer);
				$array['resized'] = ImageCreateTrueColor($properties["resized_width"],$properties["resized_height"]);
				$array['copy'] = ImageCopyResampled($array['resized'],$array['resource'], 0, 0, 0, 0, $properties["resized_width"],$properties["resized_height"], $properties["width"],$properties["height"]);
				
				$array['interlace'] = ImageInterlace($array['resized'], 1);
				$array['save'] = $this->typeCloseImage($pointer, $array['resized'], $filename);
				$array['destroy'] = ImageDestroy($array['resource']);
				ImageDestroy($array['resized']);
			
				if(array_search(false, $array, 1) === false){
					$this->re_size[$pointer] = filesize($filename);
					return true;
				} else {
					return false;
				}
				
			//Caso não seja necessário redimensionar, então faz só uma cópia
			} else {
				$this->re_size[$pointer] = $this->size[$pointer];
				return (($this->image[$pointer] == $filename) ? true : copy($this->image[$pointer], $filename));
			}
			
		//Caso a imagem não exista
		} else {
			return false;
		}
	}
	
	//Verifica o tipo de redimensionamento e gera os atributos para o redimensionamento
	// array properties ( int $pointer )
	private function properties($pointer){
		
		//Caso os valores sejam para redimensionamento fixo
		if($this->re_resize[$pointer] == self::$_IMG_RESIZE_FIXED){
			return array('resized_width' => $this->re_width[$pointer],
				'resized_height' => $this->re_height[$pointer],
				'width' => $this->width[$pointer], 'height' => $this->height[$pointer]);
				
		//Faz os calculos para o redimensionamento proporcional
		} else {
			$array = $this->resize($pointer);
			return array('resized_width' => $array[0], 'resized_height' => $array[1],
				'width' => $array[2], 'height' => $array[3]);
		}
	}

	//Faz os calculos para o redimensionamento proporcinal conforme a especificação
	// array resize ( int $pointer )
	protected function resize($pointer){
		$width = $this->width[$pointer];
		$height = $this->height[$pointer];
		$type = $this->re_resize[$pointer];
      	
		//Calcula proporcionalmente as dimensões conforme a dimensão que for maior
		if($type == self::$_IMG_RESIZE_PROPORTIONAL){
			$size = $this->re_width[$pointer];
			if ($width >= $height){
				$x = ($width > $size) ? (int)($width * ($size / $width)) : (int)$size;
				$y = ($width > $size) ? (int)($height * ($size / $width)) : (int)($size * ($height / $width));
			} else {
				$x = ($height > $size) ? (int)($width * ($size / $height)) : (int)($size * ($width / $height));
				$y = ($height > $size) ? (int)($height * ($size / $height)) : (int)$size;
			}
			
		//Calcula proporcionalmente somente para a altura
		} else if($type == self::$_IMG_RESIZE_PROPORTIONAL_HEIGHT){
			$size = $this->re_height[$pointer];
			$x = ($height > $size) ? (int)($width * ($size / $height)) : (int)($size * ($width / $height));
			$y = ($height > $size) ? (int)($height * ($size / $height)) : (int)$size;
			
		//Calcula proporcionamente somente para a largura
		} else {
			$size = $this->re_width[$pointer];
			$x = ($width > $size) ? (int)($width * ($size / $width)) : (int)$size;
			$y = ($width > $size) ? (int)($height * ($size / $width)) : (int)($size * ($height / $width));
		}
		
		return array($x, $y, $width, $height);
	}
	
	//Conforme o mimetype do arquivo, faz a escolha para criação de imagens
	// resource typeCreateImage ( int $pointer )
	protected function typeCreateImage($pointer){
		$filename = $this->image[$pointer];
		$mime = $this->mime[$pointer];
		if(imagetypes() & $mime){
			switch($mime){
				case 2: return imageCreateFromJPEG($filename);
					break;
				case 15: return imageCreateFromWBMP($filename);
					break;
				case 1: return imageCreateFromGIF($filename);
					break;
				case 3: return imageCreateFromPNG($filename);
					break;
				case 16: return imageCreateFromXBM($filename);
					break;
			}
		} else {
			return false;
		}
	}

	//Conforme o mimetype do arquivo, envia para o browser ou arquivo
	// resource typeCloseImage ( Resource $resource, String $filename , int $mime )
	protected function typeCloseImage($pointer, $resource, $filename){
		$mime = $this->mime[$pointer];
		$quality = $this->re_quality[$pointer];
		if(imagetypes() & $mime){
			switch($mime){
				case 2: return imageJPEG($resource, $filename, $quality);
					break;
				case 15: return imageWBMP($resource, $filename, $quality);
					break;
				case 1: return imageGIF($resource, $filename, $quality);
					break;
				case 3: return imagePNG($resource, $filename, $quality);
					break;
			}
		} else {
			return false;
		}
	}

	public function __destruct(){}
}
?>