<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e libro.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_agente.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();

// Creiamo un nuovo oggetto VerbaliAgente e passiamoli la connessione
$verbali_agente = new VerbaliAgente($db);

//prendo i parametri dall'url
$param = $_GET['data_inizio'];
$param2 = $_GET['data_fine'];

// query products
$stmt = $verbali_agente->read($param, $param2);
$num = $stmt->rowCount();

// se vengono trovati libri nel database
if($num>0){

    // array di libri
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table_item = array(
            "nome_agente" => $row['nome_agente'],
            "cognome_agente" => $row['cognome_agente'],
            "grado_agente" => $row['grado_agente'],
            "matricola_agente" => $row['matricola_agente'],
            "num_verbali" => $row['num_verbali']
        );
        array_push($verbali_arr, $table_item);
    }

    http_response_code(200); 
    echo json_encode($verbali_arr);

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali per Agente non ha prodotto nessun risultato.") ); 

}


?>