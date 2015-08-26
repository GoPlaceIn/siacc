/*
Criar a permissão de publicar o caso e concede-la ao grupo de especialistas e administradores
*/

alter table mescasoexames
add column AgrupaComABateria smallint null comment 'Indica se o resultado do exame será exibido agrupado com toda a bateria ou sozinho';

update mescasoexames set AgrupaComABateria = 1;

update mescasoexames set AgrupaComABateria = 0 where CodCaso = 5 and CodExame = 35;

update mescasoexames set AgrupaComABateria = 0 where CodCaso = 5 and CodExame = 24;

alter table mescaso
add column ExamesProcessados tinyint not null default 0 comment 'Indica se os exames foram processados - se as chaves foram geradas';

CREATE TABLE mescasoexameschaves
(
	CodCaso int(11) NOT NULL COMMENT 'Código do caso clínico',
	NumBateria int(11) NOT NULL COMMENT 'Numero da bateria do exame',
	Agrupado int(11) NOT NULL COMMENT 'Se deve agrupar os exames',
	CodExame int(11) NOT NULL COMMENT 'Código do exame que não será exibido agrupado ou -1',
	TipoRegistro int(11) NOT NULL COMMENT 'Tipo de registro: 1 - Teste de exames / 2 - Resultado de exames',
	Chave varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave única',
	PRIMARY KEY (CodCaso,NumBateria,Agrupado,CodExame,TipoRegistro),
	CONSTRAINT FK_mescasoexameschaves FOREIGN KEY (CodCaso) REFERENCES mescaso (Codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Tabela com as chaves dos resultados dos exames'

alter table mescasoconteudo
add column NaoExibeNaMontagem tinyint not null default 0 comment 'Indica se o conteudo deve ou não aparecer na montagem do caso. Se ele for chamado de outra forma não precisa';

alter table mescasohipotdiagn
add column Sequencia int not null comment 'Podem ser perguntadas mais de uma vez hipóteses diagnósticas';

CREATE TABLE mescasohipotdiagnperguntaguia
(
	CodCaso int(11) NOT NULL COMMENT 'Código do caso clínico',
	GrupoHipotese int(11) NOT NULL COMMENT 'Código do grupo de hipoteses do caso',
	Texto varchar(5000) COLLATE latin1_general_ci NOT NULL COMMENT 'Texto da perguntas',
	Chave varchar(200) COLLATE latin1_general_ci NOT NULL COMMENT 'Chave de identificação',
	PRIMARY KEY (CodCaso, GrupoHipotese),
	CONSTRAINT FK_mescasohipotdiagnperguntaguia FOREIGN KEY (CodCaso, GrupoHipotese) REFERENCES mescasohipotdiagn (CodCaso, Sequencia)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Perguntas norteadoras das hipóteses diagnósticas'

update mestipopergunta set Descricao = 'Texto multipla escolha (várias alternativa)'
where Codigo = 2;

insert into mestipopergunta(Descricao, ArquivoAjax)
values('Texto multipla escolha (somente uma alternativa)', 'alternativastextuais.php');

update mespergunta set CodTipo = 3 where codigo = 12;

alter table
add column PaginaInicial varchar(300) null comment 'Página para o qual o usuário deste grupo será redirecionado';

alter table mestipoexame
add column PermiteImagem tinyint not null default 1 comment 'Indica se podem ser anexadas imagens no exame';

alter table mestipoexame
add column PermiteDocs tinyint not null default 1 comment 'Indica se podem ser anexadas documentos (doc, pdf txt etc) no exame';

alter table mestipoexame
add column PermiteValores tinyint not null default 1 comment 'Indica se podem ser lançados valores manuais (resultados laboratoriais por exemplo)';

update meschavesitens set fixo = 0 where prefixo not in('OBJ','BAS');