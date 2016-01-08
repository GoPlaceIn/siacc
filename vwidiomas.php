<?php
//--utf8_encode --
session_start();
include_once 'cls/conexao.class.php';
include_once 'cls/log.class.php';
include_once 'cls/components/combobox.php';
include_once 'cls/components/botao.class.php';
include_once 'inc/comuns.inc.php';

function Main()
{
	$html = "";
	if ($_GET['id'])
	{
		$idioma = $_GET['id'];
		
		$sql  = "select e.Codigo, e.Expressao, t.Expressao as Traducao ";
		$sql .= "from sisexpressoes e left outer join sistraducoes t on t.CodExpressao = e.Codigo and t.CodIdioma = :pCodIdioma ";
		$sql .= "order by e.Expressao";
		
		$cnn = Conexao2::getInstance();
		$cmd = $cnn->prepare($sql);
		$cmd->bindParam(":pCodIdioma", $idioma, PDO::PARAM_INT);
		$cmd->execute();
		
		$total = 0;
		$feito = 0;
		
		if ($cmd->errorCode() == Comuns::QUERY_OK)
		{
			$html = '<table class="listadados">';
			$html .= '<tr class="head"><th>@lng[Expressão]</th><th>@lng[Tradução]</th></tr>';
			while ($expressao = $cmd->fetch(PDO::FETCH_OBJ))
			{
				$html .= '<tr>';
				$html .= '  <td><label>' . $expressao->Expressao . '</label></td>';
				$html .= '  <td>';
				$html .= '    <input type="text" name="exp_' . $expressao->Codigo . '" id="exp_' . $expressao->Codigo . '" value="' . ($expressao->Traducao == null ? '' : $expressao->Traducao) . '" class="campo campomedio" onblur="javascript:fntGravaTraducao(' . $expressao->Codigo . ');" /></td>';
				$html .= '    <input type="hidden" name="h_exp_' . $expressao->Codigo . '" id="h_exp_' . $expressao->Codigo . '" value="' . ($expressao->Traducao == null ? '' : $expressao->Traducao) . '" />';
				$html .= '  </td>';
				$html .= '</tr>';
				$total++;
				$feito += ($expressao->Traducao == null ? 0 : 1);
			}
			$html .= '</table>';
			
			$html = '<div class="info-percentual">@lng[Percentual traduzido:] ' . (($feito / $total) * 100) . '%</div>' . $html;
		}
		else
		{
			$msg = $cmd->errorInfo();
			$html = $msg[2];
		}
	}
	
	$usu = unserialize($_SESSION['usu']);
	$tpl = file_get_contents("tpl/frm-idiomas.html");
	
	$idiomas = null;
	Comuns::ArrayObj("select Codigo, Nome from sisidiomas order by Nome", $idiomas);
	$cmbIdiomas = new ComboBox("selIdioma", $idiomas, "Codigo", "Nome", "0", "@lng[Selecione]");
	$cmbIdiomas->cssClass("campo");
	$cmbIdiomas->setSelectedValue(($_GET['id'] ? $_GET['id'] : "0")); 
	$cmbIdiomas->Eventos(array("onchange" => "fntBuscaTraducoes()"));
	
	$botoes = Botao::BotaoNovo("fntAddExpressao();", "@lng[Adicionar expressão]");
	$botoes .= Botao::BotaoPesquisar("fntBuscaTraducoes();", "@lng[Buscar traduções]");
	
	$tpl = str_replace("<!--telatopo-->", Comuns::GeraTopoPagina($usu), $tpl);
	$tpl = str_replace("<!--itens-toolbar-->", $botoes, $tpl);
	$tpl = str_replace("<!--selIdioma-->", $cmbIdiomas->RenderHTML(), $tpl);
	$tpl = str_replace("<!--expressoes-->", $html, $tpl);
	
	header('Content-Type: text/html; charset=iso-8859-1');
	echo( Comuns::Idioma($tpl) );
}

if (Comuns::EstaLogado())	
{

	Main();
}
else
{
	$msg = base64_encode("@lng[Você deve estar logado para acessar esta tela]");
	header("Location:index.php?m=" . $msg);
}

?>