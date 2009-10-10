<?php
$proteinas = $_POST['proteinas'];
$listaProteinas = split(' ', $proteinas);
foreach($listaProteinas as $proteina){
    $proteinaFile = file('http://string-db.org/api/' .
        'tsv-no-header/resolve?identifier=' . $proteina .
        '&species=9606');
    if(is_array($proteinaFile)){
        foreach($proteinaFile as $vals){
            $er = '(([A-Z0-9.]+)\s(.*?ens)\s(.*))';
            preg_match_all($er, $vals, $matches,
                PREG_SET_ORDER);
            foreach($matches as $match){
                echo $match[1];
                echo $match[3];
            }
        }
    }
}
?>