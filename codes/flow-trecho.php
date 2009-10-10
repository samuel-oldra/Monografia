<?php
session_start();
if (!session_is_registered('fluxo'))
    session_register('fluxo');
else
    $fluxo = $_SESSION['fluxo'];
$textoUser = $_GET['textoUser'];
if($textoUser)
    $fluxo[count($fluxo)] = $textoUser;
$textoSoft = $_GET['textoSoft'];
if($textoSoft)
    $fluxo[count($fluxo)] = $textoSoft;
$flowXML = $_FILES['flowXML'];
if($flowXML){
    $nome = $flowXML['name'];
    $tipo = $flowXML['type'];
    $tamanho = $flowXML['size'];
    $tmpNome = $flowXML['tmp_name'];
    if($tamanho > 0 and strlen($nome) > 1
        and $tipo == 'text/xml'){
        $caminho = realpath('.') . '/' . $nome;
        move_uploaded_file($tmpNome, $caminho);
        if(file_exists($caminho)){
            $xmlstr = file_get_contents($caminho);
            $xmlDoc = new domDocument();
            $xmlDoc->loadXML($xmlstr);
            $xml = simplexml_import_dom($xmlDoc);
            foreach($xml->step as $val)
                $fluxo[count($fluxo)] = (string) $val;
        }
    }
}
$removeItem = $_GET['$removeItem'];
if($removeItem > -1){
    if(count($fluxo) != 1){
        unset($fluxo[$removeItem]);
        array_unshift($fluxo, array_shift($fluxo));
    }
    else
        unset($fluxo);
}
$limpaFluxo = $_GET['$limpaFluxo'];
if($limpaFluxo == 'yes')
    unset($fluxo);
$_SESSION['fluxo'] = $fluxo;
?>