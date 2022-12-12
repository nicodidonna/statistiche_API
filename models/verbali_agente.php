<?php


class VerbaliAgente
{

    private $conn;
    private $table_name_1 = "db2_bollettario";
    private $table_name_2 = "db1_agente";
    // campi di verbali_by_articolo
    public $nome_agente;
    public $cognome_agente;
    public $grado_agente;
    public $matricola_agente;
    public $num_verbali;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);

    }

    // READ verbali_by_agente
    function read($tipoRead, $dataInizio = null, $dataFine = null)
    {

        if($tipoRead == 'verbali'){
            
            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario) as num_verbali
                FROM $this->table_name_1 as b
                INNER JOIN $this->table_name_2 as a on b.id_agente_assegn_bollettario = a.id_agente
                WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY a.matricola_agente
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario) as num_verbali
                FROM $this->table_name_1 as b
                INNER JOIN $this->table_name_2 as a on b.id_agente_assegn_bollettario = a.id_agente
                WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY a.matricola_agente
                ORDER BY num_verbali DESC";
                
            }
        
        }

        if($tipoRead == 'preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario_pr) as num_verbali
                FROM db6_bollettario_pr as b
                INNER JOIN db1_agente as a on b.id_agente_assegn_bollettario_pr = a.id_agente
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY a.matricola_agente
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario_pr) as num_verbali
                FROM db6_bollettario_pr as b
                INNER JOIN db1_agente as a on b.id_agente_assegn_bollettario_pr = a.id_agente
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY a.matricola_agente
                ORDER BY num_verbali DESC";
                
            }

        }

        if($tipoRead == 'verbali_preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT nome_agente, cognome_agente, grado_agente, matricola_agente, SUM(num_verbali) AS num_verbali
                FROM(
                SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario) as num_verbali
                FROM db2_bollettario as b
                INNER JOIN db1_agente as a on b.id_agente_assegn_bollettario = a.id_agente
                WHERE CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY a.matricola_agente
                
                UNION ALL
                SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario_pr) as num_verbali
                FROM db6_bollettario_pr as b
                INNER JOIN db1_agente as a on b.id_agente_assegn_bollettario_pr = a.id_agente
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) between '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY a.matricola_agente) unione
                GROUP BY matricola_agente
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT nome_agente, cognome_agente, grado_agente, matricola_agente, SUM(num_verbali) AS num_verbali
                FROM(
                SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario) as num_verbali
                FROM db2_bollettario as b
                INNER JOIN db1_agente as a on b.id_agente_assegn_bollettario = a.id_agente
                WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY a.matricola_agente
                
                UNION ALL
                SELECT a.nome_agente, a.cognome_agente, a.grado_agente, a.matricola_agente, count(b.id_bollettario_pr) as num_verbali
                FROM db6_bollettario_pr as b
                INNER JOIN db1_agente as a on b.id_agente_assegn_bollettario_pr = a.id_agente
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <= CURDATE() AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY a.matricola_agente) unione
                GROUP BY matricola_agente
                ORDER BY num_verbali DESC";
                
            }

        }
        
        
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    
    }

}


?>