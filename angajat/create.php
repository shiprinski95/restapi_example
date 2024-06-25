<?php
// Headere-le necesare
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Obținem conexiunea la BD
include_once '../config/database.php';
  
// Instanțiăm obiectul angajatului
include_once '../objects/angajat.php';

$database = new Database();
$db = $database->getConnection();

$angajat = new Angajat($db);

// Obținem datele postate
$data = json_decode(file_get_contents("php://input"));

// Ne asigurăm că datele nu sunt goale (vide)
if(
    !empty($data->nume) &&
    !empty($data->prenume) &&
    !empty($data->varsta) &&
    !empty($data->nrTel) &&
    !empty($data->depart) &&
    !empty($data->dtAng) &&
    !empty($data->salariu) &&
    !empty($data->filiala_id)
){

    // Setăm valorile proprietăților angajatului
    $angajat->nume = $data->nume;
    $angajat->prenume = $data->prenume;
    $angajat->varsta = $data->varsta;
    $angajat->nrTel = $data->nrTel;
    $angajat->depart = $data->depart;
    $angajat->dtAng = $data->dtAng;
    $angajat->salariu = $data->salariu;
    $angajat->filiala_id = $data->filiala_id;
    $angajat->created = date('Y-m-d H:i:s');

    // Creăm angajatul
    if($angajat->create()){

        // Setăm codul răspunsului - 201 Created
        http_response_code(201);

        // Afișăm mesajul corespunzător utilizatorului
        echo json_encode(array("message" => "Angajatul a fost creat."));
    }

    // Dacă nu a reușit crearea angajatului
    else{

        // Setăm codul răspunsului - 503 Service Unavailable
        http_response_code(503);

        // Afișăm mesajul corespunzător utilizatorului
        echo json_encode(array("message" => "Nu se poate crea angajatul."));
    }
}

// În caz că datele sunt incomplete
else{
  
    // Setăm codul răspunsului - 400 Bad Request
    http_response_code(400);
  
    // Afișăm mesajul corespunzător utilizatorului
    echo json_encode(array("message" => "Imposibil de creat angajatul. Datele introduse sunt incomplete."));
}
?>