// fn-aluno.js - OK
// fn-casos.js - Linha 1104

var traducoes = {
	sOkText:			'OK',
	sLimparText:		'Limpar',
	sCancelarText:		'Cancelar',
	sSalvarText:		'Salvar',
	sFinalizarText:		'Finalizar',
	sGravarText:		'Gravar',
	sOculDetalText:		'Ocultar detalhes',
	sExibDetalText:		'Exibir detalhes',
	sNenhumMarcText:	'Voc� n�o marcou nenhuma alternativa. Marque as alternativas e ent�o verifique novamente.',
	sRespEtapaText:		'Por favor, responda esta etapa antes de continuar com a resolu��o do caso.',
	sOcorreuErroText:	'Aconteceu um erro',
	sSelItemMidiaText:	'Selecione um item para visualiz�-lo aqui',
	sValidaSenha1Text:	'Preencha todos os campos do formul�rio.',
	sValidaSenha2Text:	'As senhas informadas s�o diferentes. Informe a mesma senha para continuar.',
	sAddRegText:		'Adicionar novo registro',
	sSalvoOKText:		'Salvo com sucesso.',
	sAddEditRegText:	'Adicionar/editar registro',
	sProcuraDocText:	'Procurar documento',
	sEnviarText:		'Enviar',
	sNenhumItemText:	'Nenhum item selecionado',
	sCOnfDelRegText:	'Tem certeza que deseja excluir o registro?',
	sConfDelObjText:	'Tem certeza que deseja excluir o objetivo?',
	sConfDelImgText:	'Tem certeza que deseja excluir a imagem?',
	sConfDelDocText:	'Tem certeza que deseja excluir o documento?',
	sConfDelTraText:	'Tem certeza que deseja excluir este tratamento?',
	sConfDelDiaText:	'Tem certeza que deseja excluir este diagn�stico?',
	sConfDelDesText:	'Tem certeza que deseja excluir este desfecho?',
	sConfDelHtmText:	'Tem certeza que deseja excluir este hipertexto?',
	sConfDelHipText:	'Tem certeza que deseja excluir esta hip�tese?',
	sConfDelExaText:	'Tem certeza que deseja excluir este exame?',
	sConfDelMidText:	'Tem certeza que deseja excluir a m�dia?',
	sConfDelAgPText:	'Tem certeza que deseja excluir este agrupador de pergunta?',
	sConfDelClPText:	'Tem certeza que deseja excluir esta classifica��o de pergunta?',
	sConfDelTExText:	'Tem certeza que deseja excluir este tipo de exame?',
	sConfDelUsuText:	'Tem certeza que deseja excluir este usu�rio?',
	sConfDelGUsText:	'Tem certeza que deseja excluir o grupo de usu�rio?',
	sConfDelPerText:	'Tem certeza que deseja excluir esta permiss�o de sistema?',
	sConfDelNivDifText:	'Tem certeza que deseja excluir este n�vel de dificuldade?',
	sDelSucessoText:	'Exclu�do com sucesso.',
	sTitEFEstGerText:	'Estado geral',
	sTitEFCabecaText:	'Cabe�a',
	sTitEFPescText:		'Pesco�o',
	sTitEFAusPulText:	'Ausculta pulmonar',
	sTitEFAusCarText:	'Ausculta card�aca',
	sTitEFAbdText:		'Abdomen',
	sTitEFExtText:		'Extremidades',
	sTitEFPeleText:		'Pele',
	sTitEFSinVitText:	'Sinais vitais',
	sConfPubCasoText:	'Voc� est� prestes a publlicar este caso cl�nico. Ap�s sua publica��o os alunos ter�o acesso ao mesmo. Tem certeza que deseja publica-lo?',
	sPubOKText:			'Caso publicado com suceso',
	sConfDePubCasoText:	'Tem certeza que deseja despublicar este caso cl�nico?',
	sCasoPutText:		'Caso despublicado',
	sConfGeraVerText:	'Voc� esta prestes a gerar uma nova vers�o deste caso de estudos. Tem certeza que deseja prosseguir?',
	sGeraVerOKText:		'Nova vers�o do caso gerada com sucesso.',
	sAnexosText:		'Anexos',
	sArqInvalidoText:	'Arquivo inv�lido',
	sTitleImgText:		'Imagem: visualiza��o',
	sDescricaoText:		'Descri��o',
	sComplementoText:	'Complemento',
	sAlteradoOKText:	'Alterado com sucesso.',
	sErrCarregaText:	'Erro ao carregar. Tente novamente',
	sFaltaPalChaText:	'Palavra chave para a pesquisa n�o informada',
	sFaltaTipPesText:	'Tipo de pesquisa n�o selecionada',
	sFaltaEspPesText:	'Especifica��o de pesquisa n�o selecionada',
	sModoVisText:		'Modo de visualiza��o',
	sValidaCamposText:	'Verifique o preenchimento dos campos obrigat�rios (com *)',
	sSenhasDifText:		'As senhas informadas s�o diferentes. Cadastro n�o realizado.',
	sCamposObrigText:	'Todos os campos com * s�o obrigat�rios.',
	sImgNaoSelText:		'Imagem n�o selecionada',
	sImgSoUmaText:		'Selecione apenas uma imagem',
	sCertoOuErrText:	'Informe se est� Correta ou Incorreta',
	sCampoJustText:		'Preencha o campo Justificativa',
	sInfAlternaText:	'Informe a alternativa',
	sVerInfosText:		'Aten��o! Verifique as segintes informa��es:',
	sUsuComDepText:		'Este usu�rio n�o pode ser excluido pois possui dependencias. Deseja inativ�-lo?',
	sSelGrupoUsuText:	'Selecione um Grupo de usu�rios.',
	sConfPerGrUsu1Text:	'Voc� n�o selecionou nenhuma permiss�o para o grupo',
	sConfContText:		'Tem certeza que deseja continuar?',
	sErrInesText:		'Um erro inesperado aconteceu.',
	sTitRegInaText:		'Registro INATIVO. Clique aqui para ativ�-lo',
	sTitRegAtiText:		'Registro ATIVO. Clique aqui para desativ�-lo',
	sTitCompExaText:	'Componentes do exame',
	sValRefText:		'Valores de refer�ncia',
	sTitFiltrosText:	'Filtros',
	sECAnIdentText:		'Anamnese (identifica��o)',
	sECAnInvesText:		'Anamnese (investiga��o)',
	sECExaFisText:		'Exame f�sico',
	sECHipDiagText:		'Hip�teses diagn�sticas',
	sECOptExameText:	'Op��es de exames',
	sECResExameText:	'Resultados de exames',
	sECOptDiagText:		'Op��es de diagn�stico',
	sECOptTratText:		'Op��es de tratamento',
	sECDesfText:		'Desfecho',
	sECContHTMLText:	'Conteudo HTML',
	sECContIMGText:		'Imagem',
	sECContVIDText:		'V�deo',
	sECContAUDText:		'�udio',
	sECContDOCText:		'Documento',
	sECContEXEText:		'Exerc�cio',
	sECContGrExeText:	'Grupo de exerc�cios',
	sConfigDeText:		'Configura��es de',
	sSelItemOptExaText:	'Selecione um item "Op��es de exame"',
	sSelItemText:		'Selecione um item para adicionar um novo item',
	sMsgDelNodRaizText:	'Voc� n�o pode excluir o nodo raiz do caso de estudo',
	sConfRemItemText:	'Tem certeza que deseja remover o item @title e seus @countChildren itens vinculados?',
	sConfRemItemZrText:	'Tem certeza que deseja remover o item @title?',
	sSelItmAddCntText:	'Selecione um item para adicionar conte�do',
	sItmJaTinhaText:	'Os seguintes itens n�o foram adicionados pois j� estavam na listagem:',
	sSelItmConfText:	'Selecione um item para configurar',
	sItmRaizConfText:	'N�o � poss�vel alterar configura��es do item raiz',
	sConfItemText:		'Configura��es de',
	sConfSalvoOKText:	'Configura��es salvas com sucesso',
	sSelPriItmDestText:	'Selecione primeiro o item destino',
	sSelAgruText:		'Voc� est� tentando selecionar uma alternativa. Selecione o agrupador deste conte�do',
	sSelItmDestText:	'Selecione um item destino',
	sSelContText:		'Selecione um conte�do com op��es de escolha',
	sSelItmOptExText:	'Selecione um item do tipo "Op��es de exames"',
	sSelOptRespText:	'Selecione as op��es de resposta da condi��o',
	sSelPergText:		'Selecione uma pergunta',
	sCondSelItmDText:	'Para adicionar um desvio condicional, voc� deve selecionar o item de destino',
	sConfDelDesCText:	'Tem certeza que deseja excluir o desvio condicional selcionado?',
	sSelItmContComText:	'Selecione um item da arvore para adicionar conte�dos complementares',
	sSelPrimContText:	'Selecione primeiro um dos conte�dos',
	sConfDelMatCmpText:	'Tem certeza que deseja excluir o material complementar do item?',
	sRespExerContText:	'Voc� deve responder o exerc�cio para continuar.',
	sFimCaso2Text:		'Fim do caso 2',
	sFimCasoText:		'Fim do caso',
	sCondVerRespText:	'Para verificar as respostas, voc� deve selecionar pelo menos uma alternativa em cada etapa.',
	sSelIdiomaText:		'Selecione um idioma',
	sDetalhesText:		'Detalhes',
	sEsconderText:		'Esconder',
	sProcImgText:		'Procurar imagem',
	sProcDocText:		'Procurar documento',
	sMidiasText:		'M�dias',
	sPesquisandoText:	'Pesquisando',
	sErrSalvPergText:	'Erro ao salvar respostas',
	sTrocaSenhaText:	'Alterar senha',
	sSenhaTrocaOK:		'Senha alterada com sucesso'
}