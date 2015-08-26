/*
## N�O PUBLICADO ##
alter table mesusuario
add NomeInstit varchar(2000) null comment 'Nome da institui��o de ensino',
add SiglaInstit varchar(20) null comment 'Sigla da institui��o de ensino',
add UFInstit varchar(2) null comment 'Estado da institui��o de ensino',
add CidadeInstit varchar(300) null comment 'Nome da cidade da institui��o de ensino',
add OrigemCadastro smallint null not null default 1 comment 'Local de origem do cadastro (1 = Admin / 2 = Aluno)';
*/

/* DAQUI EM DIANTE PUBLICADO EM 12/10/12 */

create table mesestados
(
	Sigla varchar(2) not null primary key comment 'Sigla do estado',
	Descricao varchar(500) not null comment 'Nome do estado'
)

INSERT INTO mesestados(Descricao, Sigla) VALUES('Acre', 'AC');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Alagoas', 'AL');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Amap�', 'AP');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Amazonas', 'AM');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Bahia', 'BA');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Cear�', 'CE');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Distrito Federal', 'DF');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Esp�rito Santo', 'ES');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Goi�s', 'GO');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Maranh�o', 'MA');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Mato Grosso', 'MT');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Mato Grosso do Sul', 'MS');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Minas Gerais', 'MG');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Par�', 'PA');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Para�ba', 'PB');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Paran�', 'PR');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Pernambuco', 'PE');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Piau�', 'PI');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rio de Janeiro', 'RJ');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rio Grande do Norte', 'RN');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rio Grande do Sul', 'RS');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Rond�nia', 'RO');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Roraima', 'RR');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Santa Catarina', 'SC');
INSERT INTO mesestados(Descricao, Sigla) VALUES('S�o Paulo', 'SP');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Sergipe', 'SE');
INSERT INTO mesestados(Descricao, Sigla) VALUES('Tocantins', 'TO');