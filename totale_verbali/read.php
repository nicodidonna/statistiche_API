<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e totale_verbali.php per poterli usare
include_once '../config/db.php';
include_once '../models/totale_verbali.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();

// Creiamo un nuovo oggetto TotaleVerbali e passiamoli la connessione
$totale_verbali = new TotaleVerbali($db);

//prendo i parametri dall'url
$param = $_GET['data_inizio'];
$param2 = $_GET['data_fine'];

// query products
$stmt = $totale_verbali->read($param, $param2);
$num = $stmt->rowCount();

// se ci sono righe di risultato nel database
if($num>0){

    // array di risultati
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table_item = array(
            "num_verbali" => $row['num_verbali'],
            "data_verbali" => $row['data_verbali'],
        );
        array_push($verbali_arr, $table_item);
    }

    http_response_code(200); 
    echo json_encode($verbali_arr, JSON_NUMERIC_CHECK); //ENCODIAMO verbali_arr IN UN JSON, JSON_NUMERIC_CHECK SERVE A NON FAR TRASFORMARE I NUMERI IN STRINGHE NELLA CONVERSIONE

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "Non ci sono verbali nel mese/anno selezionato") ); 

}


?>