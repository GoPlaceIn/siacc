/*
PUBLICADO EM 12/10/2012
*/

CREATE TABLE meslogalteracaosenha (                                                                                                                           
	Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'C�digo sequencial',                                                                                        
	CodUsuario int(11) NOT NULL COMMENT 'C�digo do usu�rio',                                                                                                  
	EmailDestino varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Email para o qual foi enviado a nova senha',                                          
	NomeInf varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Nome informado na altera��o da senha',                                                   
	Resultado int(11) NOT NULL COMMENT 'Resultado da opera��o matem�tica',                                                                                   
	DataHora datetime NOT NULL COMMENT 'Data e hora da altera��o',                                                                                            
	Host varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Host de onde partio a requisi��o',                                                          
	PRIMARY KEY (Codigo)                                                                                                                                        
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Altera��es de senha dos usu�rios'