<?php
$proteinasSelecionadas = $_POST['proteinasSelecionadas'];
if(count($proteinasSelecionadas) > 0){
    if(count($proteinasSelecionadas) == 1)
        $linkFile = 'http://string-db.org/api/url/' .
            'network?identifier=' .
            $proteinasSelecionadas[0];
    elseif(count($proteinasSelecionadas) > 1){
        for($i=0;$i<count($proteinasSelecionadas);$i++){
            if($i != (count($proteinasSelecionadas)-1))
                $listaProteinas .=
                    $proteinasSelecionadas[$i] . '%0A';
            else
                $listaProteinas .= 
                    $proteinasSelecionadas[$i];
        }
        $linkFile = 'http://string-db.org/api/url/' .
            'networkList?identifiers=' . $listaProteinas .
            '&limit=0';
    }
} else
    $linkFile = NULL;
if($linkFile != NULL){
    $urlFile = file($linkFile);
    $er = '(e\_([A-Za-z0-9]{2}[A-Za-z0-9\_]+)\.)';
    preg_match_all($er, $urlFile[0], $matches,
        PREG_SET_ORDER);
    echo $urlFile[0];
    echo $matches[0][1];
}
?>