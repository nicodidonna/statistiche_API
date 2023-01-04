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
                
                $query = "SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario) AS num_verbali
                FROM db2_sottoscritti AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti
                INNER JOIN db2_bollettario AS b ON b.id_bollettario = so.id_bollettario_sottoscritti
                WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY ag.matricola_agente
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario) AS num_verbali
                FROM db2_sottoscritti AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti
                INNER JOIN db2_bollettario AS b ON b.id_bollettario = so.id_bollettario_sottoscritti
                WHERE CAST(b.data_verbale_bollettario AS DATE) <=CURDATE() AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY ag.matricola_agente
                ORDER BY num_verbali DESC";
                
            }
        
        }

        if($tipoRead == 'preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario_pr) AS num_verbali
                FROM db6_sottoscritti_pr AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti_pr
                INNER JOIN db6_bollettario_pr AS b ON b.id_bollettario_pr = so.id_bollettario_sottoscritti_pr
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY ag.matricola_agente
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario_pr) AS num_verbali
                FROM db6_sottoscritti_pr AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti_pr
                INNER JOIN db6_bollettario_pr AS b ON b.id_bollettario_pr = so.id_bollettario_sottoscritti_pr
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <=CURDATE() AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY ag.matricola_agente
                ORDER BY num_verbali DESC";
                
            }

        }

        if($tipoRead == 'verbali_preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {

                $query = "SELECT nome_agente, cognome_agente, grado_agente, matricola_agente, SUM(num_verbali) AS num_verbali
                FROM(
                SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario) AS num_verbali
                FROM db2_sottoscritti AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti
                INNER JOIN db2_bollettario AS b ON b.id_bollettario = so.id_bollettario_sottoscritti
                WHERE CAST(b.data_verbale_bollettario AS DATE) between '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY ag.matricola_agente
                
                UNION ALL
                
                SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario_pr) AS num_verbali
                FROM db6_sottoscritti_pr AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti_pr
                INNER JOIN db6_bollettario_pr AS b ON b.id_bollettario_pr = so.id_bollettario_sottoscritti_pr
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) between '$dataInizio' AND '$dataFine' AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY ag.matricola_agente
                ORDER BY num_verbali DESC) unione
                
                GROUP BY matricola_agente
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT nome_agente, cognome_agente, grado_agente, matricola_agente, SUM(num_verbali) AS num_verbali
                FROM(
                SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario) AS num_verbali
                FROM db2_sottoscritti AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti
                INNER JOIN db2_bollettario AS b ON b.id_bollettario = so.id_bollettario_sottoscritti
                WHERE CAST(b.data_verbale_bollettario AS DATE) <=CURDATE() AND b.stato_archivio_verbale_bollettario = 0
                GROUP BY ag.matricola_agente
                
                UNION ALL
                
                SELECT ag.nome_agente, ag.cognome_agente, ag.grado_agente, ag.matricola_agente, count(b.id_bollettario_pr) AS num_verbali
                FROM db6_sottoscritti_pr AS so
                INNER JOIN db1_agente AS ag ON ag.id_agente = so.id_agente_sottoscritti_pr
                INNER JOIN db6_bollettario_pr AS b ON b.id_bollettario_pr = so.id_bollettario_sottoscritti_pr
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <=CURDATE() AND b.stato_archivio_verbale_bollettario_pr = 0
                GROUP BY ag.matricola_agente
                ORDER BY num_verbali DESC) unione
                
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