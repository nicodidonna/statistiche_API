<?php


class ListaArticoli
{
	
	private $conn;
	private $table_name = "articoli_new";
	// campi di verbali_by_articolo
	public $stato_verbali;
	public $num_verbali;
	
	// costruttore
	public function __construct($id)
	{
		$this->conn = Database::getInstance($id);
	}
	
	// READ verbali_by_articolo
	function read()
	{
		
		try{
			
			// select all
			$query = "SELECT DISTINCT a.descrizione AS articolo
			FROM $this->table_name AS a";
			
			$stmt = $this->conn->prepare($query);
			// execute query
			$stmt->execute();
			return $stmt;
		
		}  catch (PDOException $exception) {
				
			http_response_code(500);
			echo json_encode(array("message" => "Errore nella query, contattare un tecnico."));
			exit();
			
		}
		
	}
	
}


?>