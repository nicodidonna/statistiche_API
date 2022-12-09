<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e verbali_calendario.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_calendario.php';

if( isset($_GET['id']) ){
    $db_id = $_GET['id'];
}

// Creiamo un nuovo oggetto VerbaliArticolo e passiamoli la connessione
$verbali_calendario = new VerbaliCalendario($db_id);

if ( isset($_GET['articolo']) ){

    //prendo i parametri dall'url
    $param = $_GET['articolo'];
    $stmt = $verbali_calendario->read($param);

} else {

    $stmt = $verbali_calendario->read();

}


// query products
$num = $stmt->rowCount();

// se ci sono righe di risultato nel database
if($num>0){

    // array di risultati
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $row['cronologico'] = $row['cronologico']."/".$row['anno_verbale'];
        $row['numero_verbale'] = $row['numero_verbale']."/".$row['anno_verbale'];

        $table_item = array(
            "cronologico" => $row['cronologico'],
            "numero_verbale" => $row['numero_verbale'],
            "nome_agente" => $row['nome_agente'],
            "cognome_agente" => $row['cognome_agente'],
            "articolo" => $row['articolo'],
            "data_verbale" => $row['data_verbale'],
        );
        array_push($verbali_arr, $table_item);
    }

    http_response_code(200); 
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK); //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali non ha prodotto nessun risultato.") ); 

}


?>