CREATE TABLE mescasomontagemanexos (
	CodCaso int(11) NOT NULL COMMENT 'Código do caso',
	CodMontagem int(11) NOT NULL COMMENT 'Código da montagem',
	CodChave varchar(100) COLLATE latin1_general_ci NOT NULL COMMENT 'Código da chave do item',
	CodConteudo int(11) NOT NULL COMMENT 'Código da mídia ou conteúdo',
	TipoConteudo varchar(2) COLLATE latin1_general_ci NOT NULL COMMENT 'M = Midia e C = Conteúdo',
	DtCadastro datetime DEFAULT NULL COMMENT 'Data em que o conteúdo foi anexado',
	CodUsuario int(11) DEFAULT NULL COMMENT 'Usuário que anexou o conteúdo',
	PRIMARY KEY (CodCaso,CodMontagem,CodChave,CodConteudo,TipoConteudo),
	KEY FK_mescasomontagemanexos_mescasomontegem (CodMontagem,CodChave,CodCaso),
	KEY FK_mescasomontagemanexos_mesusuario (CodUsuario),
	CONSTRAINT FK_mescasomontagemanexos_mesusuario FOREIGN KEY (CodUsuario) REFERENCES mesusuario (Codigo),
	CONSTRAINT FK_mescasomontagemanexos_mescasomontegem FOREIGN KEY (CodMontagem, CodChave, CodCaso) REFERENCES mescasomontagem (CodMontagem, Chave, CodCaso)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='Relação dos itens da montagem com conteúdos extras'





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