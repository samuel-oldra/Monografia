<?php
date_default_timezone_set('America/Sao_Paulo');
require_once('nusoap/lib/nusoap.php');
$term = $_POST['doenca'];
$wsdl = 'http://eutils.ncbi.nlm.nih.gov/entrez/eutils/' .
    'soap/v2.0/eutils.wsdl';
$webService = new nusoap_client($wsdl, 'wsdl');
$proxy = $webService->getProxy();
$error = $webService->getError();
echo $error ? $error : '';
$params01 = array('db' => 'omim', 'term' => $term);
$resp01 = $proxy->run_eSearch($params01);
foreach ($resp01[IdList][Id] as $idItem){
    $params02 = array('db' => 'omim', 'id' => $idItem);
    $resp02 = $proxy->run_eSummary($params02);
    echo $resp02[DocSum][Id];
    echo $resp02[DocSum][Item][0][ItemContent];
    echo $resp02[DocSum][Item][1][ItemContent];
    echo $resp02[DocSum][Item][2][ItemContent];
    echo $resp02[DocSum][Item][3][ItemContent];
}
?>