<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e flusso.php per poterli usare
include_once '../config/db.php';
include_once '../models/flusso.php';

if( isset($_GET['id']) ){
    $db_id = $_GET['id'];
}

// Creiamo un nuovo oggetto Flusso e passiamoli la connessione
$flusso = new Flusso($db_id);

//prendo dai parametri GET la richiesta di verbali o preavvisi e faccio la read in base a quello
if ( isset($_GET['data_inizio']) and isset($_GET['data_fine']) ) {
    
    //prendo i parametri dall'url
    $param = $_GET['data_inizio'];
    $param2 = $_GET['data_fine'];
    
    $stmt = $flusso->read($param,$param2);
    
} else {
    
    $stmt = $flusso->read();

}

// query products
$num = $stmt->rowCount();

// se ci sono righe di risultato nel database
if ($num > 0) {
    
    // array di risultati
    $verbali_arr = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        //riempio un l'array temporaneo $table_item con i valori del risultato della query
        $row['numero_verbale'] = $row['numero_verbale']."/".$row['anno_verbale'];
        
        if($row['stato_verbale']==0){
            $row['stato_verbale'] = 'Non Compilato';
        }

        if($row['stato_verbale']==1){
            $row['stato_verbale'] = 'Scaricato';
        }

        if($row['stato_verbale']==2){
            $row['stato_verbale'] = 'Notificato';
        }

        if($row['stato_verbale']==3){
            $row['stato_verbale'] = 'Pagato';
        }

        if($row['stato_verbale']==4){
            $row['stato_verbale'] = 'In ricorso - Nessun pagamento';
        }

        if($row['stato_verbale']==5){
            $row['stato_verbale'] = 'In ricorso - Pagamento effettuato';
        }

        if($row['stato_verbale']==6){
            $row['stato_verbale'] = 'Coattivo';
        }

        if($row['stato_verbale']==7){
            $row['stato_verbale'] = 'Pagato parzialmente';
        }

        if($row['stato_verbale']==8){
            $row['stato_verbale'] = 'Rateizzato';
        }

        if($row['stato_verbale']==9){
            $row['stato_verbale'] = 'Sospeso';
        }

        if($row['tipo_verbale']==1){
            $row['tipo_verbale'] = 'Immediato';
        }

        if($row['tipo_verbale']==2){
            $row['tipo_verbale'] = 'Differito';
        }

        if($row['stato_archivio_verbale']==0){
            $row['stato_archivio_verbale'] = 'Attivo';
        }

        if($row['stato_archivio_verbale']==1){
            $row['stato_archivio_verbale'] = 'Archiviato';
        }

        if($row['stato_archivio_verbale']==2){
            $row['stato_archivio_verbale'] = 'Annullato';
        }

        $row['strada_violazione'] = $row['tipo_strada']." ".$row['nome_strada'];
        
        //riempio un l'array temporaneo $table_item con i valori del risultato della query
        $table_item = array(
            "id_verbale" => $row['id_verbale'],
            "numero_verbale" => $row['numero_verbale'],
            "stato_verbale" => $row['stato_verbale'],
            "tipo_verbale" => $row['tipo_verbale'],
            "stato_archivio_verbale" => $row['stato_archivio_verbale'],
            "comune_violazione" => $row['comune_violazione'],
            "data_verbale" => $row['data_verbale'],
            "dichiarazione_verbale" => $row['dichiarazione_verbale'],
            "strada_violazione" => $row['strada_violazione'],
            "kmstrada_verbale" => $row['kmstrada_verbale'],
            "articolo_verbale" => $row['articolo_verbale'],
            "ipotesi_violazione" => $row['ipotesi_violazione'],
            "giudice_di_pace" => $row['giudice_di_pace'],
            "istat2021_30" => $row['istat2021_30'],
            "istat2019_30" => $row['istat2019_30'],
            "istat2018_30" => $row['istat2018_30'],
            "istat2021_60gg" => $row['istat2021_60gg'],
            "istat2019_60gg" => $row['istat2019_60gg'],
            "istat2018_60gg" => $row['istat2018_60gg'],
            "data_archivio_verbale" => $row['data_archivio_verbale'],
            "note_verbale" => $row['note_verbale'],
            "tipo_veicolo" => $row['tipo_veicolo'],
            "targa_veicolo" => $row['targa_veicolo'],
            "modello_veicolo" => $row['modello_veicolo'],
            "nome_proprietario" => $row['nome_proprietario'],
            "cognome_proprietario" => $row['cognome_proprietario'],
            "sesso_proprietario" => $row['sesso_proprietario'],
            "cf_proprietario" => $row['cf_proprietario'],
            "comune_nascita_proprietario" => $row['comune_nascita_proprietario'],
            "data_nascita_proprietario" => $row['data_nascita_proprietario'],
            "indirizzo_proprietario" => $row['indirizzo_proprietario'],
            "nome_trasgressore" => $row['nome_trasgressore'],
            "cognome_trasgressore" => $row['cognome_trasgressore'],
            "sesso_trasgressore" => $row['sesso_trasgressore'],
            "cf_trasgressore" => $row['cf_trasgressore'],
            "comune_nascita_trasgressore" => $row['comune_nascita_trasgressore'],
            "data_nascita_trasgressore" => $row['data_nascita_trasgressore'],
            "indirizzo_trasgressore" => $row['indirizzo_trasgressore'],
            "tipodoc_trasgressore" => $row['tipodoc_trasgressore'],
            "num_doc_trasgressore" => $row['num_doc_trasgressore'],
            "data_rilasciodoc_trasgressore" => $row['data_rilasciodoc_trasgressore'],
            "validitadoc_trasgressore" => $row['validitadoc_trasgressore'],
            "ente_rilasciodoc_trasgressore" => $row['ente_rilasciodoc_trasgressore'],
            "ragionesociale_azienda" => $row['ragionesociale_azienda'],
            "pi_azienda" => $row['pi_azienda'],
            "comune_azienda" => $row['comune_azienda'],
            "indirizzo_azienda" => $row['indirizzo_azienda'],
            "pec_azienda" => $row['pec_azienda']
        );
        
        array_push($verbali_arr, $table_item);
        
    }
    
    http_response_code(200);
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK);  //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

} else {

    http_response_code(404);
    echo json_encode(array("message" => "La ricerca di Verbali per il flusso non ha prodotto nessun risultato."));

}


?>