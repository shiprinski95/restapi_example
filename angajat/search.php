<?php
// Headere-le necesare
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// Includem obiectele bazei de date și a angajatului
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/angajat.php';
  
// Obținem conexiunea cu baza de date
$database = new Database();
$db = $database->getConnection();
  
// Pregătim obiectul angajatului
$angajat = new Angajat($db);
  
// Obținem cuvintele cheie (keywords)
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
// Interogăm angajații
$stmt = $angajat->search($keywords);
$num = $stmt->rowCount();
  
// Verificăm dacă măcar o înregistrare a fost găsită
if($num>0){
  
    // Declarăm array-ul pentru stocarea angajaților
    $angajati_arr=array();
    $angajati_arr["records"]=array();
  
    /* Parcurgem tabelul folosind ciclul while în vederea obținerii conținutului
    tabelului. fetch() este mai rapid decât fetchAll() în cadrul unui ciclu */
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	// Extragem rândul, acest lucru va face $row['nume'] pur și simplu în $nume
        extract($row);

        // Adăugăm fiecare înregistrare în array-ul $angajati_arr
        $angajat_item=array(
            "id" => $id,
            "nume" => $nume,
	    "prenume" => $prenume,
            "varsta" => $varsta,
            "nrTel" => $nrTel,
            "depart" => $depart,
            "varsta" => $varsta,
            "dtAng" => $dtAng,
            "salariu" => $salariu,
            "filiala_id" => $filiala_id,
            "filiala_denumire" => $filiala_denumire
        );
  
        array_push($angajati_arr["records"], $angajat_item);
    }
  
    // Setăm codul de răspuns - 200 OK
    http_response_code(200);

    // Afișăm utilizatorului datele angajaților în format JSON
    echo json_encode($angajati_arr);
}
  
/* Dacă variabila $num are valoarea zero sau negativă
înseamnă că nu sunt înregistrări returnate din BD */
else {

    // Setăm codul de răspuns - 404 Not Found
    http_response_code(404);
  
    // Afișăm mesajul corespunzător pentru utilizator
    echo json_encode(
        array("message" => "Nu s-au găsit angajatul dat.")
    );
}
?>