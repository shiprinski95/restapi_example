<?php
// Headere-le necesare
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Includem obiectele bazei de date și a angajatului
include_once '../config/database.php';
include_once '../objects/angajat.php';

// Obținem conexiunea cu baza de date
$database = new Database();
$db = $database->getConnection();

// Pregătim obiectul angajatului
$angajat = new Angajat($db);

// Setăm proprietatea ID a înregistrării spre citire
$angajat->id = isset($_GET['id']) ? $_GET['id'] : die();

// Citim detaliile angajatului care urmează să fie editat
$angajat->readOne();

if($angajat->nume!=null){
    // Creăm array-ul
    $angajat_arr = array(
        "id" =>  $angajat->id,
        "nume" => $angajat->nume,
        "prenume" => $angajat->prenume,
        "varsta" => $angajat->varsta,
        "nrTel" => $angajat->nrTel,
        "depart" => $angajat->depart,
        "dtAng" => $angajat->dtAng,
        "salariu" => $angajat->salariu,
        "filiala_id" => $angajat->filiala_id,
        "filiala_denumire" => $angajat->filiala_denumire

    );

    // Setăm codul răspunsului - 200 OK
    http_response_code(200);

    // Îl transformăm în format JSON
    echo json_encode($angajat_arr);
}

// Dacă angajatul dat nu există
else{
    // Setăm codul răspunsului - 404 Not Found
    http_response_code(404);

    // Afișăm mesajul corespunzător pentru utilizator
    echo json_encode(array("message" => "Angajatul nu există."));
}
?>