<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CHome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		//Modelos
		$this->load->model('biblio_model','BM',true);
		$datos = $this->BM->getCategorias();
		$this->load->view('cabecera',array('datos'=>$datos));
		/**
		$titulos = $this->getLibrosDelMismoGenero($gen);
		$arrTitulosAutores = [];
		foreach($titulos as $titulo) {
			$nomAutor = $this->BM->getNomAutorTitulo($titulo);
			foreach($nomAutor as $nombre) {
				array_push($arrTitulosAutores,$titulo."/".$nombre);
			}
			
		}
		$this->load->view('main',array('tituloAutor'=>$arrTitulosAutores));*/
		$this->load->view('footer');
	}
}
