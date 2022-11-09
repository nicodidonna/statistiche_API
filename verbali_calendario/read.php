<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e libro.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_calendario.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();

// Creiamo un nuovo oggetto VerbaliArticolo e passiamoli la connessione
$verbali_calendario = new VerbaliCalendario($db);

//prendo i parametri dall'url
$param = $_GET['articolo'];

// query products
$stmt = $verbali_calendario->read($param);
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
    echo json_encode($verbali_arr);

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "La ricerca di Verbali non ha prodotto nessun risultato.") ); 

}


?>