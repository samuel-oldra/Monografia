<?php
$proteinas = $_POST['proteinas']; // Proteínas
$rel = '<b>Proteins studied</b><br />' . $proteinas;
$listaProteinas = split(' ', $proteinas);
?>

<html>
    <head>
        <title>.:: BioNet ::.</title>
    </head>
    <body>
        <font face="verdana">
        <center>
            <img src="imgs/BioNet.png" width="262" height="66"
                onLoad="window.parent.frames[1].location='flow.php?textoSoft=<?=$rel?>'" />
                <br />
            <img src="imgs/FluxoSoftware04.png" width="500" height="220" /><br /><br />
        </center>
        <table bgcolor="#FFD42A" width="100%">
        <tr><td>                            
            <table bgcolor="#FFFFAA" width="100%">
            <tr><td>                            
                Select the occurrences of proteins that you want to use.
            </td></tr>
            </table>                        
        </td></tr>
        </table><br />
        <form name="mostraRede" action="step05.php" method="post"
            enctype="multipart/form-data">
            <input type="submit" name="next" value="Next" />
            <input type="button" name="back" value="Back" onClick="history.go(-2)" />
            <br /><br />
            <font size="2">

<?php
// Mostra lista de proteínas
foreach($listaProteinas as $proteina){
    $proteina = trim($proteina);
    if($proteina){
        echo '<b>' . $proteina . '</b><br /><br />';
        $proteinaFile = file('http://string-db.org/api/tsv-no-header/resolve?identifier=' .
            $proteina . '&species=9606');
        if(is_array($proteinaFile)){
            // Mostra lista de ocorrências da proteína
            foreach($proteinaFile as $vals){
                // Separa id e texto        
                $er = '(([A-Z0-9.]+)\s(.*?ens)\s(.*))'; // Expressão regular
                preg_match_all($er, $vals, $matches, PREG_SET_ORDER);
                foreach($matches as $match){
                    echo '<input name="proteinasSelecionadas[]" title="' . $match[1] .
                        '" type="checkbox" value="' . $match[1] . '" /> ';
                    echo $match[3] . '<br />';
                }
                echo '<br />';
            }
        }
    }
}
?>

            </font>
            <input type="submit" name="next" value="Next" />
            <input type="button" name="back" value="Back" onClick="history.go(-2)" />
        </form>
        </font>
    </body>
</html>