<?php


class MieiVerbali
{

    private $conn;
    private $table_name_1 = "db2_bollettario";
    private $table_name_2 = "db2_infrazione";
	private $table_name_3 = "articoli_new";
	private $table_name_4 = "db2_docallegato";
    // campi di miei verbali
    public $tipo_bollettario;
    public $stato_bollettario;
    public $cronologico;
    public $numero_verbale;
    public $anno_verbale;
	public $articolo;
	public $nome_docallegato;
	public $url_docallegato;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);

    }

    // READ miei_verbali
    function read()
    {
		$query = "SELECT b.id_bollettario ,b.tipo_bollettario, b.stato_bollettario, b.num_ordine_bollettario as cronologico, b.numero_bollettario as numero_verbale, b.anno_bollettario as anno_verbale , a.descrizione as articolo, d.nome_docallegato, d.url_docallegato
        FROM $this->table_name_1 as b
        INNER JOIN $this->table_name_2 as i
        ON b.id_bollettario = i.id_bollettario_infrazione
        INNER JOIN $this->table_name_3 as a
        ON i.Cod_Articolo_infrazione = a.id_articolo
        LEFT JOIN $this->table_name_4 as d
        ON b.id_bollettario = d.id_docallegato
        /*L'ULTIMA RIGA DELLA QUERY SONO TEMPORANEE, PER IL TEST */
        WHERE d.id_docallegato BETWEEN 165 AND 168";
        
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

}


?>