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
    public function insertarPrestamo() {
        $result = $this->db->query("SELECT MAX('IDPRESTAMO') FROM PRESTAMOS");
        $idMax = $result->result_array() + 1;
        $result = $this->db->query("INSERT INTO PRESTAMOS VALUES ('$idMax', to_char(sysdate, 'yyyy-mm-dd'), '$idLibro')");
        $autoresTitulos = $result->result_array();
        return $autoresTitulos;
    }
    

    
}
?>