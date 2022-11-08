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
		$this->load->view('footer');
	}
	public function generarTablaLibrosPorGenero($genero) {
		//Modelos
		$this->load->model('biblio_model','BM',true);
		$this->load->library('session');
		$this->session->set_userdata('genero', $gen);	
		
		//cabecera
		$datos = $this->BM->getCategorias();
		$data['datos']=$datos;
		$this->load->view('cabecera',$data);
		//genero
		$libroAutor = $this->BM->getNomAutorTitulo($genero);
		$data['titulosYLibros'] = $libroAutor;
		$data['genero']=$genero;
		$this->load->view('main', $data);

		//footer
		$this->load->view('footer');
	}

	public function verPrestamos($gen){
	//Modelos
	$this->load->model('biblio_model','BM',true);
	//cabecera
	$datos = $this->BM->getCategorias();
	$data['datos']=$datos;
	$this->load->view('cabecera',$data);
	//genero
	$libroAutor = $this->BM->getNomAutorTitulo($gen);
	$data['titulosYLibros'] = $libroAutor;
	$data['genero']=$gen;
	$this->load->view('main', $data);

	//footer
	$this->load->view('prestados_view');
	//footer
	$this->load->view('footer');

	}

}
