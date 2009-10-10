<?php
$id = $_GET['id'];
$page = file('http://www.ncbi.nlm.nih.gov/entrez/' .
    'dispomim.cgi?cmd=entry&id=' . $id);
foreach($page as $line)
    $texto .= $line;
$er = '(\b[A-Z]{1}[A-Z0-9]{1,5}\b)';
preg_match_all($er, $texto, $matches, PREG_SET_ORDER);
$listaRetirar = 'HTML HEAD TITLE OMIM HUMAN VIRUS TYPE';
foreach($matches as $proteina){
    foreach(split(' ', $proteinasEncontradas) as $val){
        if($val == $proteina[0])
            $existe = true;
    }
    foreach(split(' ', $listaRetirar) as $val){
        if($val == $proteina[0])
            $existe = true;
    }
    if(!$existe)
        $proteinasEncontradas .= $proteina[0] . ' ';
    $existe = false;
}
echo $proteinasEncontradas;
echo $texto;
?>