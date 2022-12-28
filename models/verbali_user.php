<?php


class VerbaliUser
{

    private $conn;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);
    }

    // READ verbali_by_user
    function read($tipoRead, $dataInizio = null, $dataFine = null)
    {

        if($tipoRead == 'verbali'){
            
            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT u.nome, u.cognome, count(b.id_bollettario) AS num_verbali
                FROM db0_user AS u
                INNER JOIN db2_bollettario AS b on b.id_user_ins_bollettario = u.id
                WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine'
                GROUP BY u.id
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT u.nome, u.cognome, count(b.id_bollettario) AS num_verbali
                FROM db0_user AS u
                INNER JOIN db2_bollettario AS b on b.id_user_ins_bollettario = u.id
                WHERE CAST(b.data_verbale_bollettario AS DATE) <=CURDATE()
                GROUP BY u.id
                ORDER BY num_verbali DESC";
                
            }
        
        }

        if($tipoRead == 'preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT u.nome, u.cognome, count(b.id_bollettario_pr) AS num_verbali
                FROM db0_user AS u
                INNER JOIN db6_bollettario_pr AS b on b.id_user_ins_bollettario_pr = u.id
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine'
                GROUP BY u.id
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT u.nome, u.cognome, count(b.id_bollettario_pr) AS num_verbali
                FROM db0_user AS u
                INNER JOIN db6_bollettario_pr AS b on b.id_user_ins_bollettario_pr = u.id
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <=CURDATE()
                GROUP BY u.id
                ORDER BY num_verbali DESC";
                
            }

        }

        if($tipoRead == 'verbali_preavvisi'){

            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT nome, cognome, SUM(num_verbali) AS num_verbali
                FROM
                (SELECT u.nome AS nome, u.cognome AS cognome, count(b.id_bollettario) AS num_verbali, u.id AS id_utente
                FROM db0_user AS u
                INNER JOIN db2_bollettario AS b on b.id_user_ins_bollettario = u.id
                WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine'
                GROUP BY u.id
                UNION ALL
                SELECT u.nome AS nome, u.cognome AS cognome, count(b.id_bollettario_pr) AS num_verbali, u.id AS id_utente
                FROM db0_user AS u
                INNER JOIN db6_bollettario_pr AS b on b.id_user_ins_bollettario_pr = u.id
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) BETWEEN '$dataInizio' AND '$dataFine'
                GROUP BY u.id) unione
                GROUP BY id_utente
                ORDER BY num_verbali DESC";
                
            } else {
                
                $query = "SELECT nome, cognome, SUM(num_verbali) AS num_verbali
                FROM
                (SELECT u.nome AS nome, u.cognome AS cognome, count(b.id_bollettario) AS num_verbali, u.id AS id_utente
                FROM db0_user AS u
                INNER JOIN db2_bollettario AS b on b.id_user_ins_bollettario = u.id
                WHERE CAST(b.data_verbale_bollettario AS DATE) <=CURDATE()
                GROUP BY u.id
                UNION ALL
                SELECT u.nome AS nome, u.cognome AS cognome, count(b.id_bollettario_pr) AS num_verbali, u.id AS id_utente
                FROM db0_user AS u
                INNER JOIN db6_bollettario_pr AS b on b.id_user_ins_bollettario_pr = u.id
                WHERE CAST(b.data_verbale_bollettario_pr AS DATE) <=CURDATE()
                GROUP BY u.id) unione
                GROUP BY id_utente
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