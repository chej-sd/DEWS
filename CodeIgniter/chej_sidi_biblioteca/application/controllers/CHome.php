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
	// ERRORES: HAY QUE DARLE AL BOTON DE "VER PRESTAMOS" CUANDO ESTAS EN LOADPRESMOSLIBRO PARA VER LOS PRESTAMOS Y QUE EN EL SELECT NO APARECE EL LIBRO ELEGIDO SIEMPRE APARECE EL MISMO LIBRO Y CUANDO GRABAS LAS DEVULUCIONES SIEMPRE SE QUEDAN POR LO DEMAS TODO OKEY.
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
	//Lista + btn
	$data['librosTitulo'] = $this->BM->devuelveLibros();
	$this->load->view('v_librosprestados', $data); 
	//VALIDACION FORMULARIO
	$p = $this->input->post();
	$prestamos = [];
	if ($p) {
		$nomLib = $p['libros'];	//Pillamos lo seleccionado en el select.
		$prestamo = $this->BM->sacarPrestamosNomLibro($nomLib);
		$data['prestamo'] = $prestamo; 
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
			//Despues de eliminar todos los valores repetidos lo añado al array session
			$this->session->set_userdata("elimLib", $filtro);
		}
		$url = base_url()."index.php/CHome/loadPrestamosLibro";
		header('Location: '.$url);
	}
	
	public function borrarLibrosSesion(){
		//Modelos
		$this->load->model('biblio_model','BM',true);

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
		$this->session->set_userdata("contLibBorrados", $cont); 
		$url = base_url()."index.php/CHome/loadPrestamosLibro";  
		header('Location: '.$url);
	}

}
