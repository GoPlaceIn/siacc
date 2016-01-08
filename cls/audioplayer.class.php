<?php
//--utf8_encode --
class AudioPlayer
{
	private $audio;
	private $controls;
	private $autoplay;
	private $player;
	
	public function __construct($audio, $autoplay = 'false', $controls = 'true')
	{
		$this->audio = $audio;
		$this->autoplay = $autoplay;
		$this->controls = $controls;
		$this->player = null;
		
		return true;
	}
	
	public function player()
	{
		if (!$this->returnPlayer()) { return false; }
		return $this->player;
	}
	
	private function returnPlayer()
	{
		try
		{
			$extensao = end(explode('.', $this->audio));
			$tipo = "";
			
			if ($extensao == 'wma')
			{
				$tipo = "audio/x-ms-wma";
			}
			else if ($extensao == 'mp3')
			{
				$tipo = "audio/mp3";
			}
			else if ($extensao == 'wav')
			{
				$tipo = "audio/wav";
			}
			
			$html = '<object type="' . $tipo . '" data="' . $this->audio . '">
	        <param name="src" value="' . $this->audio . '" />
	        <param name="autostart" value="' . $this->autoplay . '" />
	        <param name="controller" value="' . $this->controls . '" />
	        </object>';
			
			$this->player = $html;
			
			return true;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}

?>