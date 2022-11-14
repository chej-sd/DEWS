<?php       //PARA LAS CONSULTAS DE BBDD
class biblio_model extends CI_Model {

    public function getCategorias() {
        $result = $this->db->query("SELECT DISTINCT GENERO FROM LIBROS");
        $categorias = $result->result_array();
        return $categorias;
    }
    public function getAutores() {
        $result = $this->db->get( 'autores' );
        $autores = $result->result_array();
        return $autores;
    }
    public function getPrestamos() {
        $result = $this->db->get( 'prestamos' );
        $prestamos = $result->result_array();
        return $prestamos;
    }
    public function getNomAutorTitulo($genero) {
        $result = $this->db->query("SELECT autores.nombre, libros.titulo, libros.idlibro
                                    FROM AUTORES,LIBROS 
                                    WHERE LIBROS.genero = '$genero' 
                                    AND LIBROS.IDAUTOR = AUTORES.IDAUTOR");
        $autoresTitulos = $result->result_array();
        return $autoresTitulos;
    }
    public function getCantidadDeLibroEnPrestamos($idLibro) {
        $result = $this->db->query("SELECT * FROM PRESTAMOS WHERE IDLIBRO = '$idLibro'");
        return $result->num_rows();
    }
    public function sacarTituloLibroPorId($id) {
        $result = $this->db->query("SELECT TITULO FROM LIBROS WHERE IDLIBRO = $id"); 
        $inf = $result->result_array(); 

        //Se selecciona el elemento 0 pk siempre devuelve un registro :)
        return $inf[0];
    }
    public function getLibrosNoPresados() {
        $result = $this->db->query("SELECT TITULO 
                                    FROM LIBROS, PRESTAMOS 
                                    WHERE LIBROS.IDLIBRO != PRESTAMOS.IDLIBRO");
        $librosNoPrestados = $result->result_array();
        return $librosNoPrestados;
    }
    public function insertarPrestamo($idLibro) { 
        $this->db->query("INSERT INTO PRESTAMOS (fecha,idlibro) VALUES ('".date('Y-m-d')."', '$idLibro')"); 
    }
    public function sacarPrestamosAlDiaConsulta($dia) {
        $fecha = date('Y-m-'.$dia);
        $result = $this->db->query("SELECT TITULO FROM PRESTAMOS,LIBROS WHERE PRESTAMOS.idlibro = LIBROS.IDLIBRO AND PRESTAMOS.fecha = '".$fecha."'");
        return $result->result_array();
    }
    
    public function devuelveLibros() {
        $result = $this->db->query("SELECT TITULO FROM LIBROS");
        $libros = $result->result_array();
        return $libros;

    }
    public function sacarPrestamosNomLibro($nomLibro) {
        $result = $this->db->query("SELECT PRESTAMOS.IDPRESTAMO, PRESTAMOS.FECHA, LIBROS.TITULO FROM PRESTAMOS, LIBROS WHERE LIBROS.TITULO = '$nomLibro' AND LIBROS.IDLIBRO = PRESTAMOS.IDLIBRO");
        $libros = $result->result_array();
        return $libros;

    }
    
    public function eliminarPrestamo($idPrestamo) { 
        $this->db->query("DELETE FROM PRESTAMOS WHERE IDPRESTAMO = $idPrestamo"); 
    }
}
?>