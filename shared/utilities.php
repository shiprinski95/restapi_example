<?php
class Utilities{
  
    public function getPaging($page, $total_rows, $records_per_page, $page_url){
  
	// Array-ul de paginare
        $paging_arr=array();
  
	// Butonul pentru prima pagină
        $paging_arr["first"] = $page>1 ? "{$page_url}page=1" : "";
  
	// Numărăm toți angajații din BD pentru a calcula numărul total de pagini
        $total_pages = ceil($total_rows / $records_per_page);
  
	// Intervalul de link-uri de afișat
        $range = 2;
  
	// Afișare link-uri către 'intervalul de pagini' în jurul 'paginii curente'
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range)  + 1;
  
        $paging_arr['pages']=array();
        $page_count=0;
          
        for($x=$initial_num; $x<$condition_limit_num; $x++){
	    // Ne asigurăm că '$x este mai mare decât 0' și 'mai mic sau egal cu $total_pages'
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"]=$x;
                $paging_arr['pages'][$page_count]["url"]="{$page_url}page={$x}";
                $paging_arr['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
  
                $page_count++;
            }
        }
  
	// Butonul pentru ultima pagină
        $paging_arr["last"] = $page<$total_pages ? "{$page_url}page={$total_pages}" : "";
  
        // Formatul JSON
        return $paging_arr;
    }
  
}
?>