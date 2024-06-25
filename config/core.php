<?php
// Afișăm raportarea erorilor
ini_set('display_errors', 1);
error_reporting(E_ALL);
  
// Adresa URL a paginii de pornire
$home_url="http://localhost/api/";
  
// Pagină dată în parametrul URL, pagina implicită este unu
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// Setăm numărul de înregistrări per pagină
$records_per_page = 5;
  
// Calculăm pentru clauza LIMIT de interogare
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>