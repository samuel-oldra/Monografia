<?php
$proteinasSelecionadas = $_POST['proteinasSelecionadas']; // Proteínas selecionadas
if(count($proteinasSelecionadas) > 0){
    foreach($proteinasSelecionadas as $val)
        $relTexto .= $val . ' ';
    $rel = '<b>Selected proteins (Id)</b><br />' . $relTexto;
    // Busca imagem da rede da(s) proteína(s)
    if(count($proteinasSelecionadas) == 1)
        $linkFile = 'http://string-db.org/api/url/network?identifier=' .
            $proteinasSelecionadas[0];
    elseif(count($proteinasSelecionadas) > 1){
        for($i = 0; $i < count($proteinasSelecionadas); $i++){
            if($i != (count($proteinasSelecionadas) - 1))
                $listaProteinas .= $proteinasSelecionadas[$i] . '%0A';
            else
                $listaProteinas .= $proteinasSelecionadas[$i];
        }
        $linkFile = 'http://string-db.org/api/url/networkList?identifiers=' .
            $listaProteinas . '&limit=0';
    }
} else
    $linkFile = NULL;
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
            <img src="imgs/FluxoSoftware05.png" width="500" height="220" /><br /><br />
        </center>
        
<?php
if($linkFile != NULL){
    // Pega o endereço da imagem
    $urlFile = file($linkFile);
    // Separa o id do endereço
    $er = '(e\_([A-Za-z0-9]{2}[A-Za-z0-9\_]+)\.)'; // Expressão regular
    preg_match_all($er, $urlFile[0], $matches, PREG_SET_ORDER);
?>
        
        <table bgcolor="#FFD42A" width="100%">
        <tr><td>                            
            <table bgcolor="#FFFFAA" width="100%">
            <tr><td>
                To <b>save</b> the XML file of the network, click with right-click on the link
                <b>Download XML</b>, select <b>Save As</b> and choose a destination for the
                file.<br />
                Clicking on the link <b>Other files</b> will appear files available for this
                network.<br />
                Clicking on the link <b>Evaluate</b> you can evaluate the system.<br />                
                Clicking on the image of the network you will visualize it at STRING.
            </td></tr>
            </table>                        
        </td></tr>
        </table><br />
        <center>
            <a href="http://string-db.org/newstring_userdata/xml_summary.<?=$matches[0][1]?>.
                xml" target="_blank" title="Download XML">
                Download XML
            </a>
            ::
            <a href="http://string-db.org/newstring_cgi/show_network_save_page.pl?taskId=
                <?=$matches[0][1]?>" target="_blank" title="Other files">
                Other files
            </a>
            ::
            <a href="http://spreadsheets.google.com/viewform?formkey=
                dE1HSEdvd0xJdXJzdzRFLW5aTVdBc1E6MA" target="_blank" title="Evaluate">
                Evaluate
            </a>
            ::
            <a href="#" onClick="history.go(-2)">Back</a><br /><br />
            <a href="http://string-db.org/newstring_cgi/show_network_section.pl?taskId=
                <?=$matches[0][1]?>" target="_blank" title="View at STRING database">
                <img src="<?=$urlFile[0]?>" />
            </a>
        </center>
        <iframe name="aux" src="http://string-db.org/newstring_cgi/show_network_save_page.pl?
            taskId=<?=$matches[0][1]?>" frameBorder="0" width="1" height="1" scrolling="no">
        </iframe>

<?php } else { ?>

        <table bgcolor="#FF0000" width="100%">
        <tr><td>                            
            <table bgcolor="#FF7F55" width="100%">
            <tr><td>
                No protein selected!
            </td></tr>
            </table>                        
        </td></tr>
        </table><br />
        <input type="button" name="back" value="Back" onClick="history.go(-2)" />

<?php } ?>

    </font>
    </body>
</html>