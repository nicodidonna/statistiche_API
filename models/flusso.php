<?php


class Flusso
{
    
    private $conn;
    
    // costruttore
    public function __construct($id)
    {
        $this->conn = Database::getInstance($id);
    }
    
    // READ flusso
    function read($dataInizio = null, $dataFine = null)
    {
        
        try{
            
            // select all
            if ($dataInizio != null and $dataFine != null) {
                
                $query = "SELECT DISTINCT 
                b.id_bollettario AS id_verbale,
                b.numero_bollettario AS numero_verbale,
                b.anno_bollettario AS anno_verbale, 
                b.stato_bollettario AS stato_verbale,
                b.tipo_bollettario AS tipo_verbale,
                b.stato_archivio_verbale_bollettario as stato_archivio_verbale,
                c.Comune AS comune_violazione,
                b.data_verbale_bollettario AS data_verbale,
                ag.nome_agente,
                ag.cognome_agente,
                ag.matricola_agente,
                b.dichiarazione_verbale_bollettario AS dichiarazione_verbale,
                s.COD_VIA AS id_stradario, 
                s.TIP_STR AS tipo_strada,
                s.DESCRIZ AS nome_strada,
                b.kmstrada_verbale_bollettario AS kmstrada_verbale,
                a.id_articolo AS id_articolo,
                a.Descrizione AS articolo_verbale,
                i.violazione_infrazione AS ipotesi_violazione,
                c2.Comune AS giudice_di_pace,
                istat.Imp_30_euro AS istat2021_30,
                istat2.Imp_30_euro AS istat2019_30,
                istat3.Imp_30_euro AS istat2018_30, 
                istat.Imp_Ridotto_60gg_euro AS istat2021_60gg,
                istat2.Imp_Ridotto_60gg_euro AS istat2019_60gg,
                istat3.Imp_Ridotto_60gg_euro AS istat2018_60gg,
                b.data_archivio_verbale_bollettario AS data_archivio_verbale,
                b.note_archivio_verbale_bollettario AS note_verbale,
                v.tipo_veicolo,
                v.targa_veicolo,
                v.modello_veicolo,
                Mino.nome_proprietario,
                Mino.cognome_proprietario,
                Mino.sesso_proprietario,
                Mino.cf_proprietario,
                c3.Comune AS comune_nascita_proprietario,
                Mino.data_nascita_proprietario,
                Mino.indirizzo_proprietario,
                Mino.nome_trasgressore,
                Mino.cognome_trasgressore,
                Mino.sesso_trasgressore,
                Mino.cf_trasgressore,
                c4.Comune AS comune_nascita_trasgressore, 
                Mino.data_nascita_trasgressore,
                Mino.indirizzo_trasgressore,
                Mino.tipodoc_trasgressore,
                Mino.num_doc_trasgressore,
                Mino.data_rilasciodoc_trasgressore,
                Mino.validitadoc_trasgressore, 
                Mino.ente_rilasciodoc_trasgressore,
                aziende.ragionesociale_azienda,
                aziende.pi_azienda,
                c5.Comune AS comune_azienda,
                aziende.indirizzo_azienda,
                aziende.pec_azienda
                FROM db2_bollettario AS b LEFT JOIN
                (SELECT proprietario.id_bollettario, proprietario.id_proprietario AS id_proprietario, trasgressore.id_proprietario AS id_trasgressore, 'Proprietario' AS tipo_proprietario, proprietario.cognome_persona AS cognome_proprietario, proprietario.nome_persona AS nome_proprietario, proprietario.cf_persona AS cf_proprietario, trasgressore.id_proprietario AS id_t, 'Trasgressore' AS tipo_proprietario2, trasgressore.cognome_persona AS cognome_trasgressore, trasgressore.nome_persona AS nome_trasgressore, trasgressore.cf_persona AS cf_trasgressore, proprietario.sesso_persona AS sesso_proprietario, proprietario.id_comune_nascita_persona AS id_comune_nascita_proprietario, proprietario.data_nascita_persona AS data_nascita_proprietario, proprietario.indirizzo_persona AS indirizzo_proprietario, trasgressore.sesso_persona AS sesso_trasgressore, trasgressore.id_comune_nascita_persona AS id_comune_nascita_trasgressore, trasgressore.data_nascita_persona AS data_nascita_trasgressore, trasgressore.indirizzo_persona AS indirizzo_trasgressore, trasgressore.tipodoc_presentato_persona AS tipodoc_trasgressore, trasgressore.num_doc_persona AS num_doc_trasgressore, trasgressore.data_rilasciodoc_persona AS data_rilasciodoc_trasgressore, trasgressore.validitadoc_persona AS validitadoc_trasgressore, trasgressore.ente_rilasciodoc_persona AS ente_rilasciodoc_trasgressore
                FROM (
                (SELECT db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona, db1_persona.sesso_persona, db1_persona.id_comune_nascita_persona, db1_persona.data_nascita_persona, db1_persona.indirizzo_persona
                FROM (db2_bollettario LEFT JOIN db2_proprietario ON db2_bollettario.id_bollettario = db2_proprietario.id_bollettario_proprietario) 
                LEFT JOIN db1_persona ON db2_proprietario.id_persona_proprietario = db1_persona.id_persona
                LEFT JOIN db2_verbaleazienda ON db2_bollettario.id_bollettario = db2_verbaleazienda.id_bollettario_verbaleazienda
                LEFT JOIN db1_azienda ON db1_azienda.id_azienda = db2_verbaleazienda.id_azienda_verbaleazienda
                GROUP BY db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona
                HAVING db2_proprietario.tipo_proprietario=1 ) proprietario 
                LEFT JOIN 
                (SELECT db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona, db1_persona.sesso_persona, db1_persona.id_comune_nascita_persona, db1_persona.data_nascita_persona, db1_persona.indirizzo_persona, db1_persona.tipodoc_presentato_persona, db1_persona.num_doc_persona, db1_persona.data_rilasciodoc_persona, db1_persona.validitadoc_persona, db1_persona.ente_rilasciodoc_persona
                FROM (db2_bollettario LEFT JOIN db2_proprietario ON db2_bollettario.id_bollettario = db2_proprietario.id_bollettario_proprietario) 
                LEFT JOIN db1_persona ON db2_proprietario.id_persona_proprietario = db1_persona.id_persona
                GROUP BY db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona
                HAVING (((db2_proprietario.tipo_proprietario)=0))
                ) trasgressore ON proprietario.id_bollettario = trasgressore.id_bollettario )
                ) Mino on Mino.id_bollettario = b.id_bollettario
                LEFT JOIN
                (SELECT db2_bollettario.id_bollettario, db1_azienda.ragionesociale_azienda, db1_azienda.pi_azienda, db1_azienda.id_comune_azienda, db1_azienda.indirizzo_azienda, db1_azienda.pec_azienda
                FROM db2_bollettario 
                LEFT JOIN db2_verbaleazienda ON db2_bollettario.id_bollettario = db2_verbaleazienda.id_bollettario_verbaleazienda
                LEFT JOIN db1_azienda ON db1_azienda.id_azienda = db2_verbaleazienda.id_azienda_verbaleazienda
                GROUP BY db2_bollettario.id_bollettario
                HAVING db1_azienda.ragionesociale_azienda IS NOT NULL) aziende on aziende.id_bollettario = b.id_bollettario
                LEFT JOIN db0_comuni AS c ON c.id_comune = b.id_comune_verbale_bollettario
                LEFT JOIN db1_stradario AS s ON s.COD_VIA = b.id_stradario_verbale_bollettario
                LEFT JOIN db0_comuni AS c2 ON c2.id_comune = b.id_comune_ricorso_verbale_bollettario
                LEFT JOIN db2_infrazione AS i on i.id_bollettario_infrazione = b.id_bollettario
                LEFT JOIN articoli_new AS a on a.id_articolo = i.Cod_Articolo_infrazione
                LEFT JOIN istat2021 AS istat on istat.id_articolo = a.id_articolo
                LEFT JOIN istat2019 AS istat2 on istat2.id_articolo = a.id_articolo
                LEFT JOIN istat2018 AS istat3 on istat3.id_articolo = a.id_articolo
                LEFT JOIN db2_verbaleveicolo AS vv on vv.id_bollettario_verbaleveicolo = b.id_bollettario
                LEFT JOIN db1_veicolo AS v on v.id_veicolo = vv.id_veicolo_verbaleveicolo
                LEFT JOIN db0_comuni AS c3 ON c3.id_comune = Mino.id_comune_nascita_proprietario
                LEFT JOIN db0_comuni AS c4 ON c4.id_comune = Mino.id_comune_nascita_trasgressore 
                LEFT JOIN db2_verbaleazienda AS va ON va.id_bollettario_verbaleazienda = b.id_bollettario
                LEFT JOIN db0_comuni AS c5 ON c5.id_comune = aziende.id_comune_azienda 
                LEFT JOIN db1_agente AS ag ON b.id_agente_assegn_bollettario = ag.id_agente 
                WHERE CAST(b.data_verbale_bollettario AS DATE) BETWEEN '$dataInizio' AND '$dataFine'";
                
            } else {
                
                $query = "SELECT DISTINCT 
                b.id_bollettario AS id_verbale,
                b.numero_bollettario AS numero_verbale,
                b.anno_bollettario AS anno_verbale, 
                b.stato_bollettario AS stato_verbale,
                b.tipo_bollettario AS tipo_verbale,
                b.stato_archivio_verbale_bollettario as stato_archivio_verbale,
                c.Comune AS comune_violazione,
                b.data_verbale_bollettario AS data_verbale,
                ag.nome_agente,
                ag.cognome_agente,
                ag.matricola_agente,
                b.dichiarazione_verbale_bollettario AS dichiarazione_verbale,
                s.COD_VIA AS id_stradario, 
                s.TIP_STR AS tipo_strada,
                s.DESCRIZ AS nome_strada,
                b.kmstrada_verbale_bollettario AS kmstrada_verbale,
                a.id_articolo AS id_articolo,
                a.Descrizione AS articolo_verbale,
                i.violazione_infrazione AS ipotesi_violazione,
                c2.Comune AS giudice_di_pace,
                istat.Imp_30_euro AS istat2021_30,
                istat2.Imp_30_euro AS istat2019_30,
                istat3.Imp_30_euro AS istat2018_30, 
                istat.Imp_Ridotto_60gg_euro AS istat2021_60gg,
                istat2.Imp_Ridotto_60gg_euro AS istat2019_60gg,
                istat3.Imp_Ridotto_60gg_euro AS istat2018_60gg,
                b.data_archivio_verbale_bollettario AS data_archivio_verbale,
                b.note_archivio_verbale_bollettario AS note_verbale,
                v.tipo_veicolo,
                v.targa_veicolo,
                v.modello_veicolo,
                Mino.nome_proprietario,
                Mino.cognome_proprietario,
                Mino.sesso_proprietario,
                Mino.cf_proprietario,
                c3.Comune AS comune_nascita_proprietario,
                Mino.data_nascita_proprietario,
                Mino.indirizzo_proprietario,
                Mino.nome_trasgressore,
                Mino.cognome_trasgressore,
                Mino.sesso_trasgressore,
                Mino.cf_trasgressore,
                c4.Comune AS comune_nascita_trasgressore, 
                Mino.data_nascita_trasgressore,
                Mino.indirizzo_trasgressore,
                Mino.tipodoc_trasgressore,
                Mino.num_doc_trasgressore,
                Mino.data_rilasciodoc_trasgressore,
                Mino.validitadoc_trasgressore, 
                Mino.ente_rilasciodoc_trasgressore,
                aziende.ragionesociale_azienda,
                aziende.pi_azienda,
                c5.Comune AS comune_azienda,
                aziende.indirizzo_azienda,
                aziende.pec_azienda
                FROM db2_bollettario AS b LEFT JOIN
                (SELECT proprietario.id_bollettario, proprietario.id_proprietario AS id_proprietario, trasgressore.id_proprietario AS id_trasgressore, 'Proprietario' AS tipo_proprietario, proprietario.cognome_persona AS cognome_proprietario, proprietario.nome_persona AS nome_proprietario, proprietario.cf_persona AS cf_proprietario, trasgressore.id_proprietario AS id_t, 'Trasgressore' AS tipo_proprietario2, trasgressore.cognome_persona AS cognome_trasgressore, trasgressore.nome_persona AS nome_trasgressore, trasgressore.cf_persona AS cf_trasgressore, proprietario.sesso_persona AS sesso_proprietario, proprietario.id_comune_nascita_persona AS id_comune_nascita_proprietario, proprietario.data_nascita_persona AS data_nascita_proprietario, proprietario.indirizzo_persona AS indirizzo_proprietario, trasgressore.sesso_persona AS sesso_trasgressore, trasgressore.id_comune_nascita_persona AS id_comune_nascita_trasgressore, trasgressore.data_nascita_persona AS data_nascita_trasgressore, trasgressore.indirizzo_persona AS indirizzo_trasgressore, trasgressore.tipodoc_presentato_persona AS tipodoc_trasgressore, trasgressore.num_doc_persona AS num_doc_trasgressore, trasgressore.data_rilasciodoc_persona AS data_rilasciodoc_trasgressore, trasgressore.validitadoc_persona AS validitadoc_trasgressore, trasgressore.ente_rilasciodoc_persona AS ente_rilasciodoc_trasgressore
                FROM (
                (SELECT db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona, db1_persona.sesso_persona, db1_persona.id_comune_nascita_persona, db1_persona.data_nascita_persona, db1_persona.indirizzo_persona
                FROM (db2_bollettario LEFT JOIN db2_proprietario ON db2_bollettario.id_bollettario = db2_proprietario.id_bollettario_proprietario) 
                LEFT JOIN db1_persona ON db2_proprietario.id_persona_proprietario = db1_persona.id_persona
                LEFT JOIN db2_verbaleazienda ON db2_bollettario.id_bollettario = db2_verbaleazienda.id_bollettario_verbaleazienda
                LEFT JOIN db1_azienda ON db1_azienda.id_azienda = db2_verbaleazienda.id_azienda_verbaleazienda
                GROUP BY db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona
                HAVING db2_proprietario.tipo_proprietario=1 ) proprietario 
                LEFT JOIN 
                (SELECT db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona, db1_persona.sesso_persona, db1_persona.id_comune_nascita_persona, db1_persona.data_nascita_persona, db1_persona.indirizzo_persona, db1_persona.tipodoc_presentato_persona, db1_persona.num_doc_persona, db1_persona.data_rilasciodoc_persona, db1_persona.validitadoc_persona, db1_persona.ente_rilasciodoc_persona
                FROM (db2_bollettario LEFT JOIN db2_proprietario ON db2_bollettario.id_bollettario = db2_proprietario.id_bollettario_proprietario) 
                LEFT JOIN db1_persona ON db2_proprietario.id_persona_proprietario = db1_persona.id_persona
                GROUP BY db2_bollettario.id_bollettario, db2_proprietario.id_proprietario, db2_proprietario.tipo_proprietario, db1_persona.cognome_persona, db1_persona.nome_persona, db1_persona.cf_persona
                HAVING (((db2_proprietario.tipo_proprietario)=0))
                ) trasgressore ON proprietario.id_bollettario = trasgressore.id_bollettario )
                ) Mino on Mino.id_bollettario = b.id_bollettario
                LEFT JOIN
                (SELECT db2_bollettario.id_bollettario, db1_azienda.ragionesociale_azienda, db1_azienda.pi_azienda, db1_azienda.id_comune_azienda, db1_azienda.indirizzo_azienda, db1_azienda.pec_azienda
                FROM db2_bollettario 
                LEFT JOIN db2_verbaleazienda ON db2_bollettario.id_bollettario = db2_verbaleazienda.id_bollettario_verbaleazienda
                LEFT JOIN db1_azienda ON db1_azienda.id_azienda = db2_verbaleazienda.id_azienda_verbaleazienda
                GROUP BY db2_bollettario.id_bollettario
                HAVING db1_azienda.ragionesociale_azienda IS NOT NULL) aziende on aziende.id_bollettario = b.id_bollettario
                LEFT JOIN db0_comuni AS c ON c.id_comune = b.id_comune_verbale_bollettario
                LEFT JOIN db1_stradario AS s ON s.COD_VIA = b.id_stradario_verbale_bollettario
                LEFT JOIN db0_comuni AS c2 ON c2.id_comune = b.id_comune_ricorso_verbale_bollettario
                LEFT JOIN db2_infrazione AS i on i.id_bollettario_infrazione = b.id_bollettario
                LEFT JOIN articoli_new AS a on a.id_articolo = i.Cod_Articolo_infrazione
                LEFT JOIN istat2021 AS istat on istat.id_articolo = a.id_articolo
                LEFT JOIN istat2019 AS istat2 on istat2.id_articolo = a.id_articolo
                LEFT JOIN istat2018 AS istat3 on istat3.id_articolo = a.id_articolo
                LEFT JOIN db2_verbaleveicolo AS vv on vv.id_bollettario_verbaleveicolo = b.id_bollettario
                LEFT JOIN db1_veicolo AS v on v.id_veicolo = vv.id_veicolo_verbaleveicolo
                LEFT JOIN db0_comuni AS c3 ON c3.id_comune = Mino.id_comune_nascita_proprietario
                LEFT JOIN db0_comuni AS c4 ON c4.id_comune = Mino.id_comune_nascita_trasgressore 
                LEFT JOIN db2_verbaleazienda AS va ON va.id_bollettario_verbaleazienda = b.id_bollettario
                LEFT JOIN db0_comuni AS c5 ON c5.id_comune = aziende.id_comune_azienda 
                LEFT JOIN db1_agente AS ag ON b.id_agente_assegn_bollettario = ag.id_agente
                WHERE CAST(b.data_verbale_bollettario AS DATE) <= CURDATE()";
                
            }
        
        
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();
            return $stmt;
    
        } catch (PDOException $exception) {
        
            http_response_code(500);
            echo json_encode(array("message" => "Errore nella query, contattare un tecnico."));
            exit();
        
        }
    
    }

}


?>