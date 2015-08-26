/*
PUBLICADO EM 12/10/2012
*/

CREATE TABLE meslogalteracaosenha (                                                                                                                           
	Codigo int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código sequencial',                                                                                        
	CodUsuario int(11) NOT NULL COMMENT 'Código do usuário',                                                                                                  
	EmailDestino varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Email para o qual foi enviado a nova senha',                                          
	NomeInf varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Nome informado na alteração da senha',                                                   
	Resultado int(11) NOT NULL COMMENT 'Resultado da operação matemática',                                                                                   
	DataHora datetime NOT NULL COMMENT 'Data e hora da alteração',                                                                                            
	Host varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Host de onde partio a requisição',                                                          
	PRIMARY KEY (Codigo)                                                                                                                                        
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Alterações de senha dos usuários'