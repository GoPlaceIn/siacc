<?php

//--utf8_encode --

include_once 'inc/nusoup/lib/nusoap.php';
//include_once 'inc/nusoup/lib/class.nusoap_base.php';
//include_once 'inc/nusoup/lib/class.soapclient.php';

class WebServiceClient
{
	private $msg_erro;
	private $client;
	
	public function getErro()
	{
		return $this->msg_erro;
	}
	
	public function __construct($url)
	{
		//'http://siap.ufcspa.edu.br/siap_ws.php?wsdl'
		$this->client = new nusoap_client($url, true);
		$err = $this->client->getError();
		if ($err)
		{
			$this->msg_erro = $err;
			return false;
		}
		$this->client->timeout = 90;
		$this->client->response_timeout = 90;
		$this->msg_erro = null;
	}
	
	public function call_soap_method($method, $parameters)
	{
		$param_final = array('search_request' => $parameters);
		$result = $this->client->call($method, $parameters);
		//$result = $this->client->call($method, $param_final);
		
		if ($this->client->fault)
		{
			return $result;
		}
		else
		{
			$err = $this->client->getError();
			if ($err)
			{
				$this->msg_erro = $err;
				$result = null;
			}
			return $result;
		}
	}
}

?>