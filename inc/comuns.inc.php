<?php
class Comuns
{
	const IMG_ACAO_ATUALIZAR = '<img src="img/alterar.png" title="@lng[Substituir]" alt="@lng[Substituir]" />';
	const IMG_ACAO_COMPONENTES = '<img src="img/componentes.png" title="@lng[Componentes]" alt="@lng[Componentes]" />';
	const IMG_ACAO_DELETAR = '<img src="img/delete.png" ##id## title="@lng[Excluir]" alt="@lng[Excluir]" />';
	const IMG_ACAO_DETALHES = '<img src="img/detalhes.png" title="@lng[Detalhes]" alt="@lng[Detalhes]" />';
	const IMG_ACAO_EDITAR = '<img src="img/edit.png" ##id## title="@lng[Editar]" alt="@lng[Editar]" />';
	const IMG_ACAO_OPCOES = '<img src="img/list.png" title="@lng[Alternativas]" alt="@lng[Alternativas]" />';
	const IMG_ACAO_RELACOES = '<img src="img/relacoes.png" title="@lng[Relações do item]" alt="@lng[Relações do item]" />';
	const IMG_ACAO_VALORES_REF = '<img src="img/valores_ref.png" title="@lng[Valores de referência]" alt="@lng[Valores de referência]" />';
	const IMG_ACAO_VISUALIZAR = '<img src="img/visualizar.png" title="@lng[Visualizar]" alt="@lng[Visualizar]" />';
	const IMG_ACAO_AUMENTAR = '<img src="img/up.png" title="@lng[Aumentar]" alt="@lng[Aumentar]" />';
	const IMG_ACAO_DIMINUIR = '<img src="img/down.png" title="@lng[Diminuir]" alt="@lng[Diminuir]" />';
	const IMG_ACAO_MOVER = '<img src="img/move.png" class="areaDrag" title="@lng[Reordenar]" alt="@lng[Reordenar]" />';

	const IMG_STATUS_ATIVO = '<img src="img/active.png" ##id## title="@lng[Registro ATIVO. Clique aqui para desativá-lo]" alt="@lng[Registro ATIVO. Clique aqui para desativá-lo]" />';
	const IMG_STATUS_INATIVO = '<img src="img/inative.png" ##id## title="@lng[Registro INATIVO. Clique aqui para ativá-lo]" alt="@lng[Registro INATIVO. Clique aqui para ativá-lo]" />';
	const IMG_STATUS_CERTO = '<img src="img/correto.png" title="@lng[Correto" alt="@lng[Correto]" />';
	const IMG_STATUS_ERRADO = '<img src="img/incorreto.png" title="@lng[Errado" alt="@lng[Errado]" />';

	const IMG_MIDIA_IMAGEM = '<img src="img/imagem.png" title="@lng[Imagem]" alt="@lng[Imagem]">';
	const IMG_MIDIA_VIDEO = '<img src="img/video.png" title="@lng[Video]" alt="@lng[Video]">';
	const IMG_MIDIA_AUDIO = '<img src="img/audio.png" title="@lng[Áudio]" alt="@lng[Áudio]">';
	const IMG_MIDIA_MULTIMIDIA = '<img src="img/multimidia.png" title="@lng[Clique para visualizar o conteúdo multimídia]" alt="@lng[Clique para visualizar o conteúdo multimídia]">';
	const IMG_MIDIA_DOCUMENTO = '<img src="img/documento.png" title="@lng[Documento]" alt="@lng[Documento]">';
	
	const IMG_ITEM_PINO = '<img src="img/pino.png" title="@lng[Você marcou esta alternativa]" alt="@lng[Você marcou esta alternativa]" />';
	
	const AAAA = 'mespergunta';
	const AAAB = 'mesusuario';
	const AAAC = 'mesgrupopermissao';
	const AAAD = 'mesarea';
	const AAAE = 'mescaso';
	const AAAF = 'mestipoexame';
	const AAAG = 'mesinstituicao';
	
	const QUERY_OK = '00000';

	const DEFAULT_PATH = 'C:\\xamp\\projeto\\';
	
	const TIPO_MIDIA_IMAGEM = 1;
	const TIPO_MIDIA_VIDEO = 2;
	const TIPO_MIDIA_HIPERTEXTO = 3;
	const TIPO_MIDIA_AUDIO = 4;
	const TIPO_MIDIA_DOCUMENTO = 5;
	
	const GOOGLE_ANALYTICS = '<script type="text/javascript">var _gaq = _gaq || [];_gaq.push([\'_setAccount\', \'UA-2684848-1\']);_gaq.push([\'_setDomainName\', \'regisls.net\']);_gaq.push([\'_trackPageview\']);(function() {var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);})();</script>';
	
	/**
	 * Gera a paginação automática das listagens padrões do sistema; Se o link não for informado, usa como padrão a url listagem.php?t=
	 * @param $registros int : O número de registros da tabela
	 * @param $pagina int : a página que deve ser exibida
	 * @param $limite int : o número máximo de registros a serem exibidos
	 * @param $form int : código do formulário para montar os links de navegação
	 * @param $link string : Opcional. Recebe a url ou o nome da função que deve ser chamada nos botões da paginação. Default = null
	 * @param $ehfuncao bool : Opcional. Indica se o link informado no paremetro $link é uma função JavaScript. Default = false
	 * @return string : links de paginação
	 * */
	static function GeraPaginacao($registros, $pagina, $limite, $form = 0, $link = null, $ehfuncao = false)
	{
		$pag = "";

		if ($pagina > 1)
		{
			if (is_null($link))
				$pag .= '<a class="link-paginacao" href="listagem.php?t=' . $form . '&p=' . ($pagina - 1) . '">@lng[Anterior]</a>';
			else
				if (!$ehfuncao)
					$pag .= '<a class="link-paginacao" href="' . $link . 'p=' . ($pagina - 1) . '">@lng[Anterior]</a>';
				else
					$pag .= '<a class="link-paginacao" href="javascript:void(0);" onclick="javascript:' . $link . '(' . ($pagina - 1) . ')">@lng[Anterior]</a>';
		}

		$npaginas = ceil($registros / $limite);
		if ($npaginas > 1 && $npaginas <= 20)
		{
			for ($cont = 1; $cont <= $npaginas; $cont++)
			{
				if (is_null($link))
					$pag .= ' <a class="' . ($cont != $pagina ? 'link-paginacao' : 'link-paginacao-sel') . '" href="listagem.php?t=' . $form . '&p=' . $cont . '">' . $cont . '</a>';
				else
					if (!$ehfuncao)
						$pag .= ' <a class="' . ($cont != $pagina ? 'link-paginacao' : 'link-paginacao-sel') . '" href="' . $link . 'p=' . $cont . '">' . $cont . '</a>';
					else
						$pag .= ' <a class="' . ($cont != $pagina ? 'link-paginacao' : 'link-paginacao-sel') . '" href="javascript:void(0);" onclick="javascript:' . $link . '(' . $cont . ');">' . $cont . '</a>';
			}
		}
		else if($npaginas > 20)
		{
			$primeiro = $pagina - 10;
			$ultima = $pagina + 9;
			
			if ($primeiro < 1)
			{
				$ultima = $ultima - ($primeiro);
				$primeiro = 1;
			}
			if ($ultima > $npaginas)
			{
				$primeiro = $primeiro - ($ultima - $npaginas);
				$ultima = $npaginas;
			}
			
			for ($cont = $primeiro; $cont <= $ultima; $cont++)
			{
				if (is_null($link))
					$pag .= ' <a class="' . ($cont != $pagina ? 'link-paginacao' : 'link-paginacao-sel') . '" href="listagem.php?t=' . $form . '&p=' . $cont . '">' . $cont . '</a>';
				else
					if (!$ehfuncao)
						$pag .= ' <a class="' . ($cont != $pagina ? 'link-paginacao' : 'link-paginacao-sel') . '" href="' . $link . 'p=' . $cont . '">' . $cont . '</a>';
					else
						$pag .= ' <a class="' . ($cont != $pagina ? 'link-paginacao' : 'link-paginacao-sel') . '" href="javascript:void(0);" onclick="javascript:' . $link . '(' . $cont . ');">' . $cont . '</a>';
			}
		}

		if ($registros > ($limite * $pagina))
		{
			if (is_null($link))
				$pag .= ' <a class="link-paginacao" href="listagem.php?t=' . $form . '&p=' . ($pagina + 1) . '">@lng[Próximo]</a>';
			else
				if (!$ehfuncao)
					$pag .= ' <a class="link-paginacao" href="' . $link . 'p=' . ($pagina + 1) . '">@lng[Próximo]</a>';
				else
					$pag .= ' <a class="link-paginacao" href="javascript:void(0);" onclick="javascript:' . $link . '(' . ($pagina + 1) . ');">@lng[Próximo]</a>';
		}

		return '<div id="area-paginacao">' . $pag . '</div>';
	}

	/**
	 * Conta o número de registros de uma tabela
	 * @param $tabela string : nome da tabela a ser consultada
	 * @param $query string : query personalizada para consultar o número de registros
	 * @return int : o número de registros
	 * */
	static function NRegistros($tabela, $query = null)
	{
		if ($query === null)
			$sql = "SELECT COUNT(*) AS Registros FROM " . $tabela . ";";
		else
			$sql = $query;
		
		$cnn = new Conexao();
		$ret = $cnn->Consulta($sql);
		$cont = mysql_result($ret, 0);
		$cnn->Desconecta();
		return $cont;
	}

	/**
	 * Carrega o arquivo de template da tela
	 * @param $form int : Código do formulário a ser carregado
	 * @return string : o formulário HTML
	 * */
	static function BuscaForm($form)
	{
		$sql = "SELECT Arquivo FROM mestemplates WHERE Codigo = " . $form . ";";
		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);
		if ($rs != 0)
		{
			$tpl = file_get_contents(mysql_result($rs, 0));
			$cnn->Desconecta();
		}
		else
		{
			$cnn->Desconecta();
			$tpl = false;
		}
		header('Content-Type: text/html; charset=iso-8859-1');
		return $tpl;
	}

	/**
	 * Verifica se o usuário está logado no sistema
	 * @return boolean : retorna true em caso positivo e false em caso negativo
	 * */
	static function EstaLogado()
	{
		if (isset($_SESSION["usu"]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	static function MontaMenu($menu, $usuario)
	{
		$sql  = "select Codigo, Texto, Link, CodPermissao, ";
		$sql .= "	CASE WHEN CodItemPai IS NULL THEN 0 ELSE CodItemPai END CodItemPai ";
		$sql .= "from mesitensmenu ";
		$sql .= "where CodMenu = " . $menu . " ";
		$sql .= "order by CodItemPai, Ordem";

		$cnn = new Conexao();
		$rs = $cnn->Consulta($sql);

		if ($rs != 0)
		{
			if (mysql_num_rows($rs) > 0)
			{
				while($linha = mysql_fetch_object($rs) )
				{
					if ($usuario->TemPermissao($linha->CodPermissao))
					{
						$menuItens[$linha->CodItemPai][$linha->Codigo] = array('Link' => $linha->Link, 'Nome' => $linha->Texto);
					}
				}
				$ret = "";
				self::imprimeMenuInfinito($menuItens, $ret);
			}
			else
			{
				$strmenu = "";
			}
		}
		else
		{
			$strmenu = "";
		}

		//header('Content-Type: text/html; charset=iso-8859-1');
		return $ret;
	}

	private static function imprimeMenuInfinito( array $menuTotal , &$ret, $idPai = 0, $nivel = 0, $inicial = true )
	{
		// abrimos a ul do menu principal
		//echo str_repeat( "\t" , $nivel ),'<ul>',PHP_EOL;
		if ($inicial == true)
		{
			$ret .= '<ul id="multi-ddm">';
		}
		else
		{
			$ret .= '<ul>';
		}
		// itera o array de acordo com o idPai passado como parâmetro na função
		foreach( $menuTotal[$idPai] as $idMenu => $menuItem)
		{
			// imprime o item do menu
			$ret .= '<li class="item-menu-inf' . ($nivel == 0 ? ' n0' : '') . '"><a href="' . $menuItem['Link'] . '">@lng[' . $menuItem['Nome'] . ((isset( $menuTotal[$idMenu] ) && $nivel > 0) ? ']<span>&nbsp;&nbsp;&gt;</span>' : ']') . '</a>';
			
			// se o menu desta iteração tiver submenus, chama novamente a função
			if( isset( $menuTotal[$idMenu] ) )
				self::imprimeMenuInfinito( $menuTotal , $ret, $idMenu , $nivel + 2, false);
			
				// fecha o li do item do menu
			//echo str_repeat( "\t" , $nivel + 1 ),'</li>',PHP_EOL;
			$ret .= '</li>';
		}
		// fecha o ul do menu principal
		//echo str_repeat( "\t" , $nivel ),'</ul>',PHP_EOL;
		$ret .= '</ul>';
	}

	/**
	 * Retorna o cabeçalho de uma tabela HTML usando os parametros informados
	 * @param $descricao string : InformaÃ§Ã£o que vai no topo da pÃ¡gina
	 * @param $idtab string : Id que serÃ¡ atribuido a tabela
	 * @param $colunas array : Array com as colunas da tabela
	 * @return string : O topo da tabela
	 * */
	static function TopoTabelaListagem($descricao, $idtab, array $colunas)
	{
		if ($descricao != "")
		{
			$ret .= '<h3>@lng[' . $descricao . ']</h3>';
		}
		$ret .= '<table id="' . $idtab . '" class="listadados">';
		$ret .= '  <thead>';
		$ret .= '    <tr class="head">';

		foreach ($colunas as $coluna)
		{
			$ret .= '      <th>@lng[' . $coluna . ']</th>';
		}

		$ret .= '    </tr>';
		$ret .= '  </thead>';
		$ret .= '  <tbody>';

		return $ret;
	}

	/**
	 * Retorna um Código identificador único
	 * @return string : O código gerado
	 * */
	static function CodigoUnico()
	{
		return strtoupper(md5(uniqid(time())));
	}

	static function GeraTopoPagina($usu)
	{
		//header('Content-Type: text/html; charset=iso-8859-1');
		$tpl = file_get_contents("tpl/tela-topo.html");
		$tpl = str_replace("<!--Usuario-->", $usu->getNome(), $tpl);
		$tpl = str_replace("<!--UltimoAcesso-->", $usu->getUltimoAcesso(), $tpl);
		$tpl = str_replace("<!--Menu-->", self::MontaMenu(1, $usu), $tpl);

		return $tpl;
	}
	
	/**
	 * Espera uma data no formato dd/mm/yyyy e retorna uma data yyyy-mm-dd
	 * @return string : Data no formato yyyy-mm-dd
	 * */
	static function DataBanco($data)
	{
		$array = explode("/", $data);
		return $array[2] . '-' . $array[1] . '-' . $array[0];
	}
	
	static function UrlAtualCompleta() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
		
		$pageURL .= "://";
		
		if ($_SERVER["SERVER_PORT"] != "80")
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	static function getXMLValue($fakexml, $tag)
	{
    	$inicio = strpos($fakexml, ("<" . $tag . ">")) + strlen($tag) + 2;
    	$fim = strpos($fakexml, ("</" . $tag . ">"));
    	
    	return substr($fakexml, $inicio, ($fim - $inicio));
	}
	
	public static function BuscaConfiguracao($chave)
	{
			$file = file_get_contents("conf/conf.xml");
			$config = simplexml_load_file($file);
			return $config->$chave;
	}
	
	static function ModoDebug()
	{
		//$file = file_get_contents("conf/conf.xml");
		//$config = SimpleXMLElement($file);
		//if ($config->debug == "S")
		//	return true;
		//else
		//	return false;
		if (self::BuscaConfiguracao("debug") == "S")
			return true;
		else
			return false;
	}
	
	public static function GeraLog($log)
	{
		$registro = "\r\r" . date("Y-m-d H:i:s") . " - " . $log;
		$arquivo = "C:\\temp\\log_siacc.txt";
		file_put_contents($arquivo, $registro, FILE_APPEND);
	}
	
	public static function Limpa($palavra)
	{
		$palavra = str_replace("Á", "A", $palavra);
		$palavra = str_replace("À", "A", $palavra);
		$palavra = str_replace("Ã", "A", $palavra);
		$palavra = str_replace("É", "E", $palavra);
		$palavra = str_replace("È", "E", $palavra);
		$palavra = str_replace("Í", "I", $palavra);
		$palavra = str_replace("Ó", "O", $palavra);
		$palavra = str_replace("Õ", "O", $palavra);
		$palavra = str_replace("Ú", "U", $palavra);
		$palavra = str_replace("Ç", "C", $palavra);
		
		$palavra = str_replace("á", "a", $palavra);
		$palavra = str_replace("à", "a", $palavra);
		$palavra = str_replace("ã", "a", $palavra);
		$palavra = str_replace("é", "e", $palavra);
		$palavra = str_replace("è", "e", $palavra);
		$palavra = str_replace("í", "i", $palavra);
		$palavra = str_replace("ó", "o", $palavra);
		$palavra = str_replace("õ", "o", $palavra);
		$palavra = str_replace("ú", "u", $palavra);
		$palavra = str_replace("ç", "c", $palavra);
		
		return $palavra;
	}
	
	public static function Criptografa($texto)
	{
		$key = 'main katz hot an oi kalet';
		$iv = '12345678';
		
		$cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
		
		mcrypt_generic_init($cipher, $key, $iv);
		$encrypted = mcrypt_generic($cipher,$texto);
		mcrypt_generic_deinit($cipher);
		
		return $encrypted;
	}
	
	public static function Descriptografa($texto)
	{
		$key = 'main katz hot an oi kalet';
		$iv = '12345678';
		
		$cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
		
		mcrypt_generic_init($cipher, $key, $iv);
		$decrypted = mdecrypt_generic($cipher,$encrypted);
		mcrypt_generic_deinit($cipher);
		
		return $decrypted;
	}
	
	public static function DescreveTipoMidia($intTipo)
	{
		switch ($intTipo)
		{
			case 1: $strTipoMidia = "Imagem"; break;
			case 2: $strTipoMidia = "Vídeo"; break;
			case 3: $strTipoMidia = "Hipertexto"; break;
			case 4: $strTipoMidia = "Áudio"; break;
			case 5: $strTipoMidia = "Documento"; break;
		}
		return $strTipoMidia;
	}
	
	public static function Default_url_conteudo()
	{
		return 'http' . ($_SERVER["HTTPS"] ? 's' : '') . '://' . $_SERVER["SERVER_NAME"] . '/vwcont.php?k=';
	}
	
	public static function Idioma($conteudo, $grupo = null)
	{
		$sql  = "select e.Expressao, IFNULL(t.Expressao, e.Expressao) as Traduzido ";
		$sql .= "from sisexpressoes e left outer join sistraducoes t on t.CodExpressao = e.Codigo and t.CodIdioma = :pIdioma";
		
		if ($grupo !== null)
		{
			$sql .= " where e.Grupo = '" . $grupo . "'";
		}
		
		$cnn = Conexao2::getInstance();
		
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pIdioma", $_COOKIE['siacc_lang'], PDO::PARAM_INT);
		$cmd->execute();
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			if ($cmd->rowCount() > 0)
			{
				$expressoes = $cmd->fetchAll(PDO::FETCH_KEY_PAIR);
				
				$t = new Traducao();
				$t->setExpressoes($expressoes);
				
				$conteudo = preg_replace_callback('/@lng\[.*?\]/', array($t, 'Traduz'), $conteudo);
			}
		}
		else
		{
			$t = new Traducao();
			$conteudo = preg_replace_callback('/@lng\[.*?\]/', array($t, 'Padrao'), $conteudo);
		}
		
		return $conteudo;
	}

	/**
	 * Retorna true e um Array de Objetos sendo as propriedades os campos do sql passado em caso de sucesso e false e a mensagem de erro caso contrário 
	 * @param $sql string : Query SQL que deve retornar um Array de Objetos
	 * @param $rs object : Variável de referência que receberá o Array de Objetos ou a mensagem de erro
	 * @return bool : true ou false
	 * */
	public static function ArrayObj($sql, &$rs)
	{
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->execute();
		
		if ($cmd->errorCode() != Comuns::QUERY_OK)
		{
			$msg = $cmd->errorInfo();
			$ret = $msg[2];
			return false;
		}
		else
		{
			$rs = $cmd->fetchAll(PDO::FETCH_OBJ);
			return true;
		}
	}
}

class Traducao
{
	private $expressoes;
	
	public function setExpressoes($exp)
	{
		$this->expressoes = $exp;
	}
	
	public function Traduz($matches)
	{
		$find = $matches[0];
		$find = preg_replace(array("/@lng\[/", "/\]/"), "", $matches[0]);
		return (array_key_exists($find, $this->expressoes)) ? $this->expressoes[$find] : $find;
	}
	
	public function Padrao($matches)
	{
		return preg_replace(array("/@lng\[/", "/\]/"), "", $matches[0]);
	}
}
?>