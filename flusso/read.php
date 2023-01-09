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

        //CHIAMATA READAGENTI
        $stmt2 = $flusso->readAgenti($row['id_verbale']);
        $num2 = $stmt2->rowCount();
        $temp = [];
        if($num2 > 0){

            $count = 1;
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                
                $table_item2 = array(
                    "nome_agente".$count => $row2['nome_agente'],
                    "cognome_agente".$count => $row2['cognome_agente'],
                    "matricola_agente".$count => $row2['matricola_agente']
                );
                $count = $count + 1;

                $temp = $temp + $table_item2;

            }

        }
        //FINE CHIAMATA READAGENTI

        //CHIAMATA READPERSONE
        $stmt3 = $flusso->readPersone($row['id_verbale']);
        $num3 = $stmt3->rowCount();
        $temp2 = [];
        if($num3 > 0){

            $count2 = 1;
            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {

                if($row3['tipo_proprietario'] == 0){ //SE TRASGRESSORE
                        
                    $table_item3 = array(
                        "nome_trasgressore" => $row3['nome_persona'],
                        "cognome_trasgressore" => $row3['cognome_persona'],
                        "sesso_trasgressore" => $row3['sesso_persona'],
                        "cf_trasgressore" => $row3['cf_persona'],
                        "comune_nascita_trasgressore" => $row3['comune_nascita_persona'],
                        "data_nascita_trasgressore" => $row3['data_nascita_persona'],
                        "indirizzo_trasgressore" => $row3['indirizzo_persona'],
                        "tipodoc_trasgressore" => $row3['tipodoc_persona'],
                        "num_doc_trasgressore" => $row3['num_doc_persona'],
                        "data_rilasciodoc_trasgressore" => $row3['data_rilasciodoc_persona'],
                        "validitadoc_trasgressore" => $row3['validitadoc_persona'],
                        "ente_rilasciodoc_trasgressore" => $row3['ente_rilasciodoc_persona']
                    );

                }

                if($row3['tipo_proprietario'] == 1){ //SE PROPRIETARIO O SOLIDALE
                        
                    $table_item3 = array(
                        "nome_proprietario" => $row3['nome_persona'],
                        "cognome_proprietario" => $row3['cognome_persona'],
                        "sesso_proprietario" => $row3['sesso_persona'],
                        "cf_proprietario" => $row3['cf_persona'],
                        "comune_nascita_proprietario" => $row3['comune_nascita_persona'],
                        "data_nascita_proprietario" => $row3['data_nascita_persona'],
                        "indirizzo_proprietario" => $row3['indirizzo_persona']
                    );

                }

                if($row3['tipo_proprietario'] == 2){ //SE LOCATARIO
                        
                    $table_item3 = array(
                        "nome_locatario" => $row3['nome_persona'],
                        "cognome_locatario" => $row3['cognome_persona'],
                        "sesso_locatario" => $row3['sesso_persona'],
                        "cf_locatario" => $row3['cf_persona'],
                        "comune_nascita_locatario" => $row3['comune_nascita_persona'],
                        "data_nascita_locatario" => $row3['data_nascita_persona'],
                        "indirizzo_locatario" => $row3['indirizzo_persona']
                    );

                }

                if($row3['tipo_proprietario'] == 3){ //SE COMPROPRIETARIO
                        
                    $table_item3 = array(
                        "nome_comproprietario".$count2 => $row3['nome_persona'],
                        "cognome_comproprietario".$count2 => $row3['cognome_persona'],
                        "sesso_comproprietario".$count2 => $row3['sesso_persona'],
                        "cf_comproprietario".$count2 => $row3['cf_persona'],
                        "comune_nascita_comproprietario".$count2 => $row3['comune_nascita_persona'],
                        "data_nascita_comproprietario".$count2 => $row3['data_nascita_persona'],
                        "indirizzo_comproprietario".$count2 => $row3['indirizzo_persona']
                    );
                    $count2 = $count2 + 1;

                }

                if($row3['tipo_proprietario'] == 4){ //SE EREDE
                        
                    $table_item3 = array(
                        "nome_erede" => $row3['nome_persona'],
                        "cognome_erede" => $row3['cognome_persona'],
                        "sesso_erede" => $row3['sesso_persona'],
                        "cf_erede" => $row3['cf_persona'],
                        "comune_nascita_erede" => $row3['comune_nascita_persona'],
                        "data_nascita_erede" => $row3['data_nascita_persona'],
                        "indirizzo_erede" => $row3['indirizzo_persona']
                    );

                }

                $temp2 = $temp2 + $table_item3;

            }

        }
        //FINE CHIAMATA READPERSONE
        
        //riempio un l'array temporaneo $table_item con i valori del risultato della query
        $row['numero_verbale'] = $row['numero_verbale']."/".$row['anno_verbale'];
        
        //switch per assegnare l'id dello stato bollettario al suo valore
        switch ($row['stato_verbale']) {
            
            case '0':
                $row['stato_verbale'] = 'Non Compilato';
                break;
                
            case '1':
                $row['stato_verbale'] = 'Scaricato';
                break;

            case '2':
                $row['stato_verbale'] = 'Notificato';
                break;

            case '3':
                $row['stato_verbale'] = 'Pagato';
                break;
                
            case '4':
                $row['stato_verbale'] = 'In ricorso - Nessun Pagamento';
                break;
                
            case '5':
                $row['stato_verbale'] = 'In ricorso - Pagamento effettuato';
                break;
                
            case '6':
                $row['stato_verbale'] = 'Coattivo';
                break;
                
            case '7':
                $row['stato_verbale'] = 'Pagato parzialmente';
                break;
                
            case '8':
                $row['stato_verbale'] = 'Rateizzato';
                break;
                
            case '9':
                $row['stato_verbale'] = 'Sospeso';
                break;
                
            case '10':
                $row['stato_verbale'] = 'Rinotificato';
                break;
                
            case '11':
                $row['stato_verbale'] = 'Reso';
                break;    

            default:
                $row['stato_verbale'] = 'Stato verbale non riconosciuto';
                break;

        };
        //fine switch stato_verbale

        //switch tipo_verbale
        if($row['tipo_verbale']==1){
            $row['tipo_verbale'] = 'Immediato';
        }

        if($row['tipo_verbale']==2){
            $row['tipo_verbale'] = 'Differito';
        }
        //fine tipo_verbale

        //stato_archivio_verbale
        if($row['stato_archivio_verbale']==0){
            $row['stato_archivio_verbale'] = 'Attivo';
        }

        if($row['stato_archivio_verbale']==1){
            $row['stato_archivio_verbale'] = 'Archiviato';
        }

        if($row['stato_archivio_verbale']==2){
            $row['stato_archivio_verbale'] = 'Annullato';
        }
        //fine stato_archivio_verbale

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
            "id_stradario" => $row["id_stradario"],
            "strada_violazione" => $row['strada_violazione'],
            "kmstrada_verbale" => $row['kmstrada_verbale'],
            "id_articolo" => $row["id_articolo"],
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
            "ragionesociale_azienda" => $row['ragionesociale_azienda'],
            "pi_azienda" => $row['pi_azienda'],
            "comune_azienda" => $row['comune_azienda'],
            "indirizzo_azienda" => $row['indirizzo_azienda'],
            "pec_azienda" => $row['pec_azienda']
        );
        
        $temp = $temp + $temp2 + $table_item;
        array_push($verbali_arr, $temp);
        
    }
    
    http_response_code(200);
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK);  //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

} else {

    http_response_code(404);
    echo json_encode(array("message" => "La ricerca di Verbali per il flusso non ha prodotto nessun risultato."));

}


?>