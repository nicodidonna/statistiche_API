<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e verbali_sanzioneacc.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_sanzioneacc.php';

if( isset($_GET['id']) ){
    $db_id = $_GET['id'];
}

// Creiamo un nuovo oggetto VerbaliSanzioneAcc e passiamoli la connessione
$verbali_sanzioneacc = new VerbaliSanzioneAcc($db_id);

//prendo dai parametri GET la richiesta di verbali o preavvisi e faccio la read in base a quello
if( isset($_GET['tipoRead']) ){
    
    $GLOBALS['tipoRead'] = $_GET['tipoRead'];
    
    if ( isset($_GET['data_verbale_inizio']) and isset($_GET['data_verbale_fine']) ) {

        //prendo i parametri dall'url
        $data_verbale_inizio = $_GET['data_verbale_inizio'];
        $data_verbale_fine = $_GET['data_verbale_fine'];
        
        $stmt = $verbali_sanzioneacc->read($GLOBALS['tipoRead'], $data_verbale_inizio, $data_verbale_fine);
    
    } else if (isset($_GET['data_creazione_inizio']) and isset($_GET['data_creazione_fine'])){
        
        $data_creazione_inizio = $_GET['data_creazione_inizio'];
        $data_creazione_fine = $_GET['data_creazione_fine'];

        $stmt = $verbali_sanzioneacc->read($GLOBALS['tipoRead'], null, null, $data_creazione_inizio, $data_creazione_fine);

    } else {
        
        $stmt = $verbali_sanzioneacc->read($GLOBALS['tipoRead']);
    
    }

}


// query products
$num = $stmt->rowCount();

// se ci sono righe di risultato nel database
if($num>0){
    
    // array di risultati
    $verbali_arr = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        //se chiedo verbali riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'verbali'){
            
            $table_item = array(
                "tipo_sanzione_accessoria" => $row['tipo_sanzione_accessoria'],
                "num_verbali" => $row['num_verbali'],
            );
        
        }
        
        //se chiedo preavvisi riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'preavvisi'){
            
            $table_item = array(
                "tipo_sanzione_accessoria" => $row['tipo_sanzione_accessoria'],
                "num_verbali" => $row['num_verbali'],
            );
        
        }

        //se chiedo verbali e preavvisi riempio un l'array temporaneo $table_item con i valori del risultato della query
        if($GLOBALS['tipoRead'] == 'verbali_preavvisi'){
            
            $table_item = array(
                "tipo_sanzione_accessoria" => $row['tipo_sanzione_accessoria'],
                "num_verbali" => $row['num_verbali'],
            );
        
        }
        
        array_push($verbali_arr, $table_item);
        
    }
    
    http_response_code(200);
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK); //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

} else {
    
    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali per Sanzione Accessoria non ha prodotto nessun risultato.") ); 

}

?>