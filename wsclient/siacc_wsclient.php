<?php
// Pull in the NuSOAP code
require_once '../inc/nusoup/lib/nusoap.php';
//require_once('../inc/nusoap/lib/nusoap.php');
// Create the client instance

function create_soap_client() {
	$client = new soapclient(
		'http://siap.ufcspa.edu.br/siap_ws.php?wsdl', true);
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		// At this point, you know the call that follows will fail
	}
	return $client;
} 

function call_soap_method($client, $method, $parameters) {
	$result = $client->call($method, $parameters);
	// Check for a fault
	if ($client->fault) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
		$result = NULL;
	} else {
		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			echo '<h2>Error</h2><pre>' . $err . '</pre>';
			$result = NULL;
		}		
	}
	return $result;
}

header('Content-type: text/html; charset=ISO-8859-1');

$client = create_soap_client();

$search_types = call_soap_method($client, 'get_search_types', array());
if ($search_types) {
	echo '<h2>Tipos de busca para Imagem</h2><pre>';
	print_r($search_types);
	echo '</pre>';
}

$search_type_keys = array_keys($search_types);
foreach ($search_type_keys as &$search_type_key) {
	$result = call_soap_method($client, 'get_search_type_keywords', array("search_type" => $search_type_key));
	if ($result) {
		echo '<h2>Palavras-chave para '.$search_types[$search_type_key].':</h2><pre>';
		print_r($result);
		echo '</pre>';
	}	
}


$search_results = call_soap_method($client, 'search', array(
    "palavra"=>"abscesso", "sistema"=>"nervoso", "procedencia"=>"macroscopia", "patologia"=>""));

if ($search_results) {
	echo '<h2>Resultados da busca para "abscesso" no sistema nervoso:</h2><pre>';
	foreach($search_results as &$result){
           echo 'Nome: '.$result['nome'].'<br>';
           echo 'Sistema: '.$result['sistema'].'<br>';
           echo 'Procedencia: '.$result['procedencia'].'<br>';
           echo 'Patologia: '.$result['patologia'].'<br>';
           echo 'URL: '.$result['url'].'<br>';
           echo '<br>';
        
        }
	echo '</pre>';
}


// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

?>
