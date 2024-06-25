<?php
// Headere-le necesare
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// Includem obiectele bazei de date și a angajatului
include_once '../config/database.php';
include_once '../objects/angajat.php';
  
// Obținem conexiunea cu baza de date
$database = new Database();
$db = $database->getConnection();
  
// Pregătim obiectul angajatului
$angajat = new Angajat($db);
  
// Obținem ID-ul angajatului de editat
$data = json_decode(file_get_contents("php://input"));
  
// Setăm proprietatea ID a angajatului de editat
$angajat->id = $data->id;
  
// Setăm valorile proprietăților angajatului
$angajat->nume = $data->nume;
$angajat->prenume = $data->prenume;
$angajat->varsta = $data->varsta;
$angajat->nrTel = $data->nrTel;
$angajat->depart = $data->depart;
$angajat->dtAng = $data->dtAng;
$angajat->salariu = $data->salariu;
$angajat->filiala_id = $data->filiala_id;
  
// Edităm angajatul
if($angajat->update()){
  
    // Setăm codul răspunsului - 200 OK
    http_response_code(200);
  
    // Afișăm mesajul corespunzător utilizatorului
    echo json_encode(array("message" => "Angajatul a fost editat."));
}
  
// Dacă nu a reușit editarea angajatului
else{
  
    // Setăm codul răspunsului - 503 Service Unavailable
    http_response_code(503);
  
    // Afișăm mesajul corespunzător utilizatorului
    echo json_encode(array("message" => "Imposibil de editat angajatul."));
}
?>