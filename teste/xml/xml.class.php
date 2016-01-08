<?php

//--utf8_encode --

function Main()
{
	$xml = new XMLReader();
	
	$xml = new XMLWriter();
	$xml->openMemory();
	
	$xml->startDocument();
	
	$xml->startElement("manifest");
	
	$xml->startElement("metadata");
	$xml->endElement();
	
	$xml->startElement("organization");
	
	$xml->startElement("item");
	
	$xml->writeAttribute("identifier", "item1");
	$xml->writeAttribute("identifierref", "resource3");
	$xml->writeAttribute("isvisible", "true");
	
	$xml->writeElement("title", "Content 1");
	$xml->writeElement("adlcp:timeLimitAction", "exit, no message");
	
	
	//$xml->endElement();
	//$xml->endElement();
	
	$xml->endDocument();
	
	$string = $xml->outputMemory();
	
	echo($string);
}

Main();
?>