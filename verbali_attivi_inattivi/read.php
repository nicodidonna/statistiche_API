<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// includiamo database.php e libro.php per poterli usare
include_once '../config/db.php';
include_once '../models/verbali_attivi_inattivi.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();

// Creiamo un nuovo oggetto Libro
$verbali_attivi_inattivi = new VerbaliAttiviInattivi($db);

// query products
$stmt = $verbali_attivi_inattivi->read();
$num = $stmt->rowCount();

// se vengono trovati libri nel database
if($num>0){

    // array di libri
    $verbali_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table_item = array(
            "tipo_verbali" => $row['tipo_verbali'],
            "num_verbali" => $row['num_verbali'],
        );
        array_push($verbali_arr, $table_item);
    }

    http_response_code(200); 
    echo json_encode($verbali_arr);

}else{ 

    http_response_code(404); 
    echo json_encode( array("message" => "Nessun verbale by articolo trovato sul Database.") ); 

}


?>