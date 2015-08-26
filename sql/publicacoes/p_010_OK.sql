CREATE TABLE mescasomontagemanexos (
	CodCaso int(11) NOT NULL COMMENT 'C�digo do caso',
	CodMontagem int(11) NOT NULL COMMENT 'C�digo da montagem',
	CodChave varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'C�digo da chave do item',
	CodConteudo int(11) NOT NULL COMMENT 'C�digo da m�dia ou conte�do',
	TipoConteudo varchar(2) COLLATE latin1_general_ci NOT NULL COMMENT 'M = Midia e C = Conte�do',
	DtCadastro datetime DEFAULT NULL COMMENT 'Data em que o conte�do foi anexado',
	CodUsuario int(11) DEFAULT NULL COMMENT 'Usu�rio que anexou o conte�do',
	PRIMARY KEY (CodCaso,CodMontagem,CodChave,CodConteudo,TipoConteudo),
	KEY FK_mescasomontagemanexos_mescasomontegem (CodMontagem,CodChave,CodCaso),
	KEY FK_mescasomontagemanexos_mesusuario (CodUsuario),
	CONSTRAINT FK_mescasomontagemanexos_mesusuario FOREIGN KEY (CodUsuario) REFERENCES mesusuario (Codigo),
	CONSTRAINT FK_mescasomontagemanexos_mescasomontegem FOREIGN KEY (CodMontagem, CodChave, CodCaso) REFERENCES mescasomontagem (CodMontagem, Chave, CodCaso)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Rela��o dos itens da montagem com conte�dos extras'





/*
upload

tpl/frm-montagem.html
tpl/aluno/resumo.html
js/siacc.montagem.js
js/fn-aluno.js
js/fn-forms.js
css/aluno/estilo.css
img/img_mini.png
cls/montagem.class.php
cls/menus.class.php
inc/comuns.inc.php
vwresumo.php
ajaxtreesalto.php
*/