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
	public function generarCalendario() {
		//Modelos
		$this->load->model('biblio_model','BM',true);
		$datos = $this->BM->getCategorias();
		$this->load->view('cabecera',array('datos'=>$datos));
		$this->load->library('calendar');
		$arrLinksDias = [];
		for ($i=0; $i <= 31; $i++) { 
			array_push($arrLinksDias,base_url()."index.php/CHome/sacarPrestamosAlDia/".$i);
		}
		$date['arrLinksDias'] = $arrLinksDias;
		$this->load->view('calendario', $date);
		$this->load->view('footer');
	}
	public function sacarPrestamosAlDia($dia) { 
		//Modelos
        $this->load->model('biblio_model','BM',true);
		$datos = $this->BM->getCategorias();
		$this->load->view('cabecera',array('datos'=>$datos));
        $data['arrTitulosDia'] = $this->BM->sacarPrestamosAlDiaConsulta($dia);
		$data['elDia'] = $dia;
		$this->load->view('prestamos_dia',$data);
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
	//FORMULARIO
	if (isset($_POST['cbox'])){
		$arrLibrosNoPrestados = [];
		$arrLibrosPrestados = [];
		$arrIdLibrosSelecionados = $_POST['cbox'];
		foreach ($arrIdLibrosSelecionados as $idLibroSeleccionado) {
			$cantidadLibrosPrestados = $this->BM->getCantidadDeLibroEnPrestamos($idLibroSeleccionado);
			if ($cantidadLibrosPrestados > 3) {
				$titulo = $this->BM->sacarTituloLibroPorId($idLibroSeleccionado);
				array_push($arrLibrosNoPrestados, $titulo);
			}else {
				$titulo = $this->BM->sacarTituloLibroPorId($idLibroSeleccionado);
				array_push($arrLibrosPrestados, $titulo);
				$this->BM->insertarPrestamo($idLibroSeleccionado);
			}
		}
		$data['librosNoPrestados'] = $arrLibrosNoPrestados;
		$data['librosPrestados'] = $arrLibrosPrestados; 
		$this->load->view('librosPrestados', $data); 
	}  
	//footer
	$this->load->view('footer'); 
	}
	public function generarPrestamos(){
	//Modelos
	$this->load->model('biblio_model','BM',true);
	//cabecera
	$datos = $this->BM->getCategorias();
	$data['datos']=$datos;
	$this->load->view('cabecera',$data);
	//Lista + btn
	$data['librosTitulo'] = $this->BM->devuelveLibros(); 
	$this->load->view('v_librosprestados', $data); 
	//footer
	$this->load->view('footer');
	}  
	public function loadPrestamosLibro(){
	//Modelos
	$this->load->model('biblio_model','BM',true);
	//cabecera
	$datos = $this->BM->getCategorias();
	$data['datos']=$datos;
	$this->load->view('cabecera',$data);  
	//VALIDACION FORMULARIO
	$form = $this->input->post();
	$prestamos = [];
	if ($form) { 
		$nomLib = $form['libros'];	//Pillamos lo seleccionado en el select.
		$this->session->set_userdata("nombreLibro", $nomLib);
		
		$prestamo = $this->BM->sacarPrestamosNomLibro($nomLib);
		$data['prestamo'] = $prestamo;  
		// 
		//Lista + btn
		$data['librosTitulo'] = $this->BM->devuelveLibros();
		$data['seleccionado'] = $nomLib;
		$this->load->view('v_librosprestados', $data); 

		$this->load->view('v_linksprestamos', $data); 
	}
	//footer
	$this->load->view('footer');
	}

	public function guardarLibrosADevolver($idprestamo){ 
		$this->load->library("session"); 
		if (!$this->session->has_userdata("elimLib")) {
			$arrLibrosAEliminar = [];
			array_push($arrLibrosAEliminar, $idprestamo);
			$this->session->set_userdata("elimLib", $arrLibrosAEliminar);
		}else {
			$arrLibrosAEliminar =$this->session->elimLib;
			array_push($arrLibrosAEliminar, $idprestamo);
			//PROCEDO A ELIMINAR TODOS LOS REPETIDOS DEL ARRAY.
			$filtro = array_unique($arrLibrosAEliminar);
			//Despues de eliminar todos los valores repetidos lo a??ado al array session
			$this->session->set_userdata("elimLib", $filtro);
		}
		//Modelos
		$this->load->model('biblio_model','BM',true);
		//cabecera
		$datos = $this->BM->getCategorias();
		$data['datos']=$datos;
		$this->load->view('cabecera',$data);  
		//Sacamos el nombre de sesion.
		$nombreLibro = $this->session->userdata('nombreLibro');
		//Lista + btn submit
		$data['librosTitulo'] = $this->BM->devuelveLibros();
		$data['seleccionado'] = $nombreLibro;
		$this->load->view('v_librosprestados', $data);
		//Lista + btn devolver
		$prestamo = $this->BM->sacarPrestamosNomLibro($nombreLibro);
		$data['prestamo'] = $prestamo;  
		$this->load->view('v_linksprestamos',$data);
		//footer
		$this->load->view('footer');
	} 

	public function borrarLibrosSesion(){
		//Modelos
		$this->load->model('biblio_model','BM',true);
		//cabecera
		$datos = $this->BM->getCategorias();
		$data['datos']=$datos;
		$this->load->view('cabecera',$data);  
		$arrLibrosAEliminar =$this->session->elimLib;
		$cont = 0;
		//Voy eliminandolos de la bbdd.
		if ($arrLibrosAEliminar != null) {
			foreach($arrLibrosAEliminar as $idprestamo) {
				$this->BM->eliminarPrestamo($idprestamo);
				$cont++;
			}
		}
		//Borro el array session
		$this->session->unset_userdata('elimLib');    
		//Lista + btn submit + el numero de eliminacion
		$data['librosTitulo'] = $this->BM->devuelveLibros();
		$data['seleccionado'] = $nombreLibro;
		$data['cont'] = $cont;
		$this->load->view('v_librosprestados', $data);
		//footer
		$this->load->view('footer');  
	}

}
