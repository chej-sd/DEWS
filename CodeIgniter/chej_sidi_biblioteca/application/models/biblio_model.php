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
    
}
?>