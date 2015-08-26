<?php
include_once './m/modelUsuario.php';
include_once './v/viewUsuario.php';

class controlerUsuario
{
	private $model;
	private $view;

	public function __construct()
	{
		$this->model = new modelUsuario();
		$this->view = new viewUsuario();
	}

	public function Faz($act, $cod = null)
	{
		if ($act == "l")
		{
			$lista = $this->model->ConsultaUsuario();
			$tela = $this->view->MostraTelaLista($lista);
		}
		else if ($act == "n")
		{
			$tela = $this->view->MostraTelaNovo();
		}
		else if ($act == "e")
		{
			$lista = $this->model->ConsultaUsuario($cod);
			$tela = $this->view->MostraTelaEdita($lista);
		}
		else if ($act == "a")
		{
			$ok = $this->model->AtualizaUsuario($_REQUEST['txtcodigo'], $_REQUEST['txtnome']);
			$this->Faz("l");
		}

		echo($tela);
	}
}

?>