ALTER TABLE mescaso CHANGE CodArea CodArea VARCHAR(20) NULL COMMENT 'Código da área de conhecimento';

UPDATE mescaso SET CodArea = NULL;

DELETE FROM mesarea where CodAreaPai IS NOT NULL;
DELETE FROM mesarea;

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1', 'Ciências Exatas e da Terra', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('2', 'Ciências Biológicas', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('3', 'Engenharias', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('4', 'Ciências da Saúde', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('5', 'Ciências Agrárias', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('6', 'Ciências Sociais Aplicadas', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('7', 'Ciências Humanas', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('8', 'Linguística, Letras e Artes', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('9', 'Outros', NULL, 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.00.00.00-3', 'Ciências Exatas e da Terra', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.00.00-8', 'Matemática', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.01.00-4', 'Álgebra', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.01.01-2', 'Conjuntos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.01.02-0', 'Lógica Matemática', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.01.03-9', 'Teoria dos Números', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.01.04-7', 'Grupos de Álgebra Não-Comutaviva', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.01.05-5', 'Álgebra Comutativa', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.01.06-3', 'Geometria Algébrica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.02.00-0', 'Análise', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.02.01-9', 'Análise Complexa', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.02.02-7', 'Análise Funcional', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.02.03-5', 'Análise Funcional Não-Linear', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.02.04-3', 'Equações Diferenciais Ordinárias', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.02.05-1', 'Equações Diferenciais Parciais', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.02.06-0', 'Equações Diferenciais Funcionais', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.03.00-7', 'Geometria e Topologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.03.01-5', 'Geometria Diferencial', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.03.02-3', 'Topologia Algébrica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.03.03-1', 'Topologia das Variedades', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.03.04-0', 'Sistemas Dinâmicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.03.05-8', 'Teoria das Singularidades e Teoria das Catástrofes', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.03.06-6', 'Teoria das Folheações', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.04.00-3', 'Matemática Aplicada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.04.01-1', 'Física Matemática', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.04.02-0', 'Análise Numérica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.01.04.03-8', 'Matemática Discreta e Combinatória', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.00.00-2', 'Probabilidade e Estatística', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.01.00-9', 'Probabilidade', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.01.01-7', 'Teoria Geral e Fundamentos da Probabilidade', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.01.02-5', 'Teoria Geral e Processos Estocásticos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.01.03-3', 'Teoremas de Limite', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.01.04-1', 'Processos Markovianos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.01.05-0', 'Análise Estocástica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.01.06-8', 'Processos Estocásticos Especiais', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.00-5', 'Estatística', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.01-3', 'Fundamentos da Estatística', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.02-1', 'Inferência Paramétrica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.03-0', 'Inferência Não-Paramétrica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.04-8', 'Inferência em Processos Estocásticos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.05-6', 'Análise Multivariada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.06-4', 'Regressão e Correlação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.07-2', 'Planejamento de Experimentos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.02.08-0', 'Análise de Dados', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.02.03.00-1', 'Probabilidade e Estatística Aplicadas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.00.00-7', 'Ciência da Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.01.00-3', 'Teoria da Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.01.01-1', 'Computabilidade e Modelos de Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.01.02-0', 'Linguagem Formais e Autômatos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.01.03-8', 'Análise de Algoritmos e Complexidade de Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.01.04-6', 'Lógicas e Semântica de Programas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.02.00-0', 'Matemática da Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.02.01-8', 'Matemática Simbólica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.02.02-6', 'Modelos Analíticos e de Simulação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.03.00-6', 'Metodologia e Técnicas da Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.03.01-4', 'Linguagens de Programação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.03.02-2', 'Engenharia de Software', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.03.03-0', 'Banco de Dados', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.03.04-9', 'Sistemas de Informação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.03.05-7', 'Processamento Gráfico (Graphics)', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.04.00-2', 'Sistemas de Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.04.01-0', 'Hardware', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.04.02-9', 'Arquitetura de Sistemas de Computação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.04.03-7', 'Software Básico', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.03.04.04-5', 'Teleinformática', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.00.00-1', 'Astronomia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.01.00-8', 'Astronomia de Posição e Mecânica Celeste', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.01.01-6', 'Astronomia Fundamental', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.01.02-4', 'Astronomia Dinâmica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.02.00-4', 'Astrofísica Estelar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.03.00-0', 'Astrofísica do Meio Interestelar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.03.01-9', 'Meio Interestelar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.03.02-7', 'Nebulosa', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.04.00-7', 'Astrofísica Extragaláctica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.04.01-5', 'Galáxias', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.04.02-3', 'Aglomerados de Galáxias', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.04.03-1', 'Quasares', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.04.04-0', 'Cosmologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.05.00-3', 'Astrofísica do Sistema Solar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.05.01-1', 'Física Solar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.05.02-0', 'Movimento da Terra', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.05.03-8', 'Sistema Planetário', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.06.00-0', 'Instrumentação Astronômica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.06.01-8', 'Astronomia Ótica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.06.02-6', 'Radioastronomia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.06.03-4', 'Astronomia Espacial', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.04.06.04-2', 'Processamento de Dados Astronômicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.00.00-6', 'Física', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.01.00-2', 'Física Geral', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.01.01-0', 'Métodos Matemáticos da Física', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.01.02-9', 'Física Clássica e Física Quântica; Mecânica e Campos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.01.03-7', 'Relatividade e Gravitação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.01.04-5', 'Física Estatística e Termodinâmica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.01.05-3', 'Metrologia, Técnicas Gerais de Laboratório, Sistema de Instrumentação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.01.06-1', 'Instrumentação Específica de Uso Geral em Física', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.02.00-9', 'Áreas Clássicas de Fenomenologia e suas Aplicações', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.02.01-7', 'Eletricidade e Magnetismo; Campos e Partículas Carregadas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.02.02-5', 'Ótica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.02.03-3', 'Acústica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.02.04-1', 'Transferência de Calor; Processos Térmicos e Termodinâmicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.02.05-0', 'Mecânica, Elasticidade e Reologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.02.06-8', 'Dinâmica dos Fluidos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.03.00-5', 'Física das Partículas Elementares e Campos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.03.01-3', 'Teoria Geral de Partículas e Campos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.03.02-1', 'Teorias Específicas e Modelos de Interação; Sistemática de Partículas; Raios Cósmicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.03.03-0', 'Reações Específicas e Fenomiologia de Partículas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.03.04-8', 'Propriedades de Partículas Específicas e Ressonâncias', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.04.00-1', 'Física Nuclear', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.04.01-0', 'Estrutura Nuclear', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.04.02-8', 'Desintegração Nuclear e Radioatividade', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.04.03-6', 'Reações Nucleares e Espalhamento Geral', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.04.04-4', 'Reações Nucleares e Espalhamento (Reações Específicas)', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.04.05-2', 'Propriedades de Núcleos Específicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.04.06-0', 'Métodos Experimentais e Instrumentação para Partículas Elementares e Física Nuclear', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.05.00-8', 'Física Atômica e Molecular', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.05.01-6', 'Estrutura Eletrônica de Átomos e Moléculas; Teoria', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.05.02-4', 'Espectros Atômicos e Integração de Fótons', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.05.03-2', 'Espectros Moleculares e Interações de Fótons com Moléculas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.05.04-0', 'Processos de Colisão e Interações de Átomos e Moléculas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.05.05-9', 'Inf. sobre Átomos e Moléculas Obtidos Experimentalmente; Instrumentação e Técnicas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.05.06-7', 'Estudos de Átomos e Moléculas Especiais', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.06.00-4', 'Física dos Fluidos, Física de Plasmas e Descargas Elétricas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.06.01-2', 'Cinética e Teoria de Transporte de Fluidos; Propriedades Físicas de Gases', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.06.02-0', 'Física de Plasmas e Descargas Elétricas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.00-0', 'Física da Matéria Condensada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.01-9', 'Estrutura de Líquidos e Sólidos; Cristalografia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.02-7', 'Propriedades Mecânicas e Acústicas da Matéria Condensada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.03-5', 'Dinâmica da Rede e Estatística de Cristais', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.04-3', 'Equação de Estado, Equilíbrio de Fases e Transições de Fase', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.05-1', 'Propriedades Térmicas da Matéria Condensada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.06-0', 'Propriedades de Transportes de Matéria Condensada (Não Eletrônicas)', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.07-8', 'Campos Quânticos e Sólidos, Hélio, Líquido, Sólido', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.08-6', 'Superfícies e Interfaces; Películas e Filamentos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.09-4', 'Estados Eletrônicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.10-8', 'Transp. Eletrônicos e Prop. Elétricas de Superfícies; Interfaces e Películas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.11-6', 'Estruturas Eletrônicas e Propriedades Elétricas de Superfícies, Interfaces e Películas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.12-4', 'Supercondutividade', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.13-2', 'Materiais Magnéticos e Propriedades Magnéticas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.14-0', 'Ressonância Mag.e Relax. na Mat. Condens.; Efeitos Mosbauer; Corr. Ang. Perturbada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.15-9', 'Materiais Dielétricos e Propriedades Dielétricas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.16-7', 'Prop. Óticas e Espectrosc. da Mat. Condens.; Outras Inter. da Mat. Com Rad.e Part.', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.05.07.17-5', 'Emissão Eletrônica e Iônica por Líquidos e Sólidos; Fenômenos de Impacto', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.00.00-0', 'Química', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.00-7', 'Química Orgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.01-5', 'Estrutura, Conformação e Estereoquímica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.02-3', 'Síntese Orgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.03-1', 'Físico-Química Orgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.04-0', 'Fotoquímica Orgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.05-8', 'Química dos Produtos Naturais', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.06-6', 'Evolução, Sistemática e Ecologia Química', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.01.07-4', 'Polímeros e Colóides', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.00-3', 'Química Inorgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.01-1', 'Campos de Coordenação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.02-0', 'Não-Metais e seus Compostos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.03-8', 'Compostos Organo-Metálicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.04-6', 'Determinação de Estrutura de Compostos Inorgânicos', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.05-4', 'Foto-Química Inorgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.06-2', 'Físico-Química Inorgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.02.07-0', 'Química Bio-Inorgânica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.00-0', 'Físico-Química', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.01-8', 'Cinética Química e Catálise', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.02-6', 'Eletroquímica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.03-4', 'Espectroscopia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.04-2', 'Química de Interfaces', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.05-0', 'Química do Estado Condensado', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.06-9', 'Química Nuclear e Radioquímica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.07-7', 'Química Teórica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.03.08-5', 'Termodinâmica Química', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.00-6', 'Química Analítica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.01-4', 'Separação', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.02-2', 'Métodos Óticos de Análise', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.03-0', 'Eletroanalítica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.04-9', 'Gravimetria', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.05-7', 'Titimetria', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.06-5', 'Instrumentação Analítica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.06.04.07-3', 'Análise de Traços e Química Ambiental', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.00.00-5', 'Geociências', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.00-1', 'Geologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.01-0', 'Mineralogia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.02-8', 'Petrologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.03-6', 'Geoquímica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.04-4', 'Geologia Regional', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.05-2', 'Geotectônica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.06-0', 'Geocronologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.07-9', 'Cartografia Geológica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.08-7', 'Metalogenia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.09-5', 'Hidrogeologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.10-9', 'Prospecção Mineral', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.11-7', 'Sedimentologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.12-5', 'Paleontologia Estratigráfica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.13-3', 'Estratigrafia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.01.14-1', 'Geologia Ambiental', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.00-8', 'Geofísica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.01-6', 'Geomagnetismo', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.02-4', 'Sismologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.03-2', 'Geotermia e Fluxo Térmico', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.04-0', 'Propriedades Físicas das Rochas', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.05-9', 'Geofísica Nuclear', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.06-7', 'Sensoriamento Remoto', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.07-5', 'Aeronomia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.08-3', 'Desenvolvimento de Instrumentação Geofísica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.09-1', 'Geofísica Aplicada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.02.10-5', 'Gravimetria', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.00-4', 'Meteorologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.01-2', 'Meteorologia Dinâmica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.02-0', 'Meteorologia Sinótica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.03-9', 'Meteorologia Física', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.04-7', 'Química da Atmosfera', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.05-5', 'Instrumentação Meteorológica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.06-3', 'Climatologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.07-1', 'Micrometeorologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.08-0', 'Sensoriamento Remoto da Atmosfera', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.03.09-8', 'Meteorologia Aplicada', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.04.00-0', 'Geodesia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.04.01-9', 'Geodesia Física', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.04.02-7', 'Geodesia Geométrica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.04.03-5', 'Geodesia Celeste', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.04.04-3', 'Fotogrametria', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.04.05-1', 'Cartografia Básica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.00-7', 'Geografia Física', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.01-5', 'Geomorfologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.02-3', 'Climatologia Geográfica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.03-1', 'Pedologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.04-0', 'Hidrogeografia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.05-8', 'Geoecologia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.06-6', 'Fotogeografia (Físico-Ecológica)', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.07.05.07-4', 'Geocartografia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.00.00-0', 'Oceanografia', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.01.00-6', 'Oceanografia Biológica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.01.01-4', 'Interação entre os Organismos Marinhos e os Parâmetros Ambientais', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.02.00-2', 'Oceanografia Física', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.02.01-0', 'Variáveis Físicas da Água do Mar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.02.02-9', 'Movimento da Água do Mar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.02.03-7', 'Origem das Massas de Água', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.02.04-5', 'Interação do Oceano com o Leito do Mar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.02.05-3', 'Interação do Oceano com a Atmosfera', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.03.00-9', 'Oceanografia Química', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.03.01-7', 'Propriedades Químicas da Água do Mar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.03.02-5', 'Interações Químico-Biológicas/Geológicas das Substâncias Químicas da Água do Mar', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.04.00-5', 'Oceanografia Geológica', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.04.01-3', 'Geomorfologia Submarina', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.04.02-1', 'Sedimentologia Marinha', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.04.03-0', 'Geofísica Marinha', '1', 1);

INSERT INTO mesarea(Codigo, Descricao, CodAreaPai, Ativo) 
VALUES('1.08.04.04-8', 'Geoquímica Marinha', '1', 1);