<?php
// Header necesar ce indică că fișierul poate fi citit de oricine (asterisk *)
header("Access-Control-Allow-Origin: *");
// Header necesar ce indică ce tip de conținut va fi returnat (date în format JSON)
header("Content-Type: application/json; charset=UTF-8");
// Observăm că am setat charset-ul Unicode pentru diacritice
  
// Includem script-urile PHP necesare create anterior
include_once '../config/database.php';
include_once '../objects/filiala.php';
  
// Instanțiăm obiectele bazei de date și angajatului
$database = new Database();
$db = $database->getConnection();
  
// Inițializăm obiectul
$filiala = new Filiala($db);
  
// Interogare (query) filiale
$stmt = $filiala->read();
$num = $stmt->rowCount();
  
// Dacă a fost găsită măcar o înregistrare
if($num>0){
  
    // Declarăm array-ul pentru stocarea angajaților
    $filiale_arr=array();
    $filiale_arr["records"]=array();
  
    /* Parcurgem tabelul folosind ciclul while în vederea obținerii conținutului
    tabelului. fetch() este mai rapid decât fetchAll() în cadrul unui ciclu */
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	// Extragem rândul, acest lucru va face $row['nume'] pur și simplu în $nume
        extract($row);
  
        $filiala_item=array(
            "id" => $id,
            "denumire" => $denumire,
            "adresa" => $adresa
        );
  
        array_push($filiale_arr["records"], $filiala_item);
    }
  
    // Setăm codul de răspuns - 200 OK
    http_response_code(200);

    // Afișăm utilizatorului datele filialelor în format JSON
    echo json_encode($filiale_arr);
}

/* Dacă variabila $num are valoarea zero sau negativă
înseamnă că nu sunt înregistrări returnate din BD */
else{

    // Setăm codul de răspuns - 404 Not Found
    http_response_code(404);
  
    // Afișăm mesajul corespunzător pentru utilizator
    echo json_encode(
        array("message" => "Nu s-au găsit filiale.")
    );
}
?>