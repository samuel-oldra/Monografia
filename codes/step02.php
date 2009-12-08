<?php
date_default_timezone_set('America/Sao_Paulo');
require_once('nusoap/lib/nusoap.php');
$term = $_POST['doenca']; // Doença
$rel = '<b>Search term</b><br />' . $term;
// Conecta ao WebService
$wsdl = 'http://eutils.ncbi.nlm.nih.gov/entrez/eutils/soap/v2.0/eutils.wsdl';
$webService = new nusoap_client($wsdl, 'wsdl');
$proxy = $webService->getProxy();
// Testa a ocorrência de erros
$error = $webService->getError();
echo $error ? $error : '';
// Realiza a busca pelo termo
$params01 = array('db' => 'omim', 'term' => $term);
$resp01 = $proxy->run_eSearch($params01);
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
            <img src="imgs/FluxoSoftware02.png" width="500" height="220" /><br /><br />
        </center>

<?php if(count($resp01[IdList][Id]) > 1){ ?>

        <table bgcolor="#FFD42A" width="100%">
        <tr><td>                            
            <table bgcolor="#FFFFAA" width="100%">
            <tr><td>
                Select the occurrence of the disease that is looking.
            </td></tr>
            </table>                        
        </td></tr>
        </table><br />
        <input type="button" name="back" value="Back" onClick="history.go(-2)" /><br /><br />

<?php
    foreach ($resp01[IdList][Id] as $idItem){
        // Realiza a busca pelo id encontrado
        $params02 = array('db' => 'omim', 'id' => $idItem);
        $resp02 = $proxy->run_eSummary($params02);
        // Apresenta a doença
        echo '<font size="2">';
        echo '<a href="step03.php?id=' . $resp02[DocSum][Id] . '" target="steps">' .
            $resp02[DocSum][Item][0][ItemContent] . '</a><br />';    
        echo $resp02[DocSum][Item][1][ItemContent] . '<br />';
        if ($resp02[DocSum][Item][2][ItemContent])
            echo $resp02[DocSum][Item][2][ItemContent] . '<br />';
        if ($resp02[DocSum][Item][3][ItemContent])
            echo 'Gene map locus <a href="http://www.ncbi.nlm.nih.gov/Omim/getmap.cgi?l' .
                $resp02[DocSum][Id] . '" target="_blank">' .
                $resp02[DocSum][Item][3][ItemContent] . '</a><br />';
        echo '</font><br />';
    }
    echo '<input type="button" name="back" value="Back" onClick="history.go(-2)" />';
} else {
?>

        <table bgcolor="#FF0000" width="100%">
        <tr><td>                            
            <table bgcolor="#FF7F55" width="100%">
            <tr><td>
                No items found!
            </td></tr>
            </table>                        
        </td></tr>
        </table><br />
        <input type="button" name="back" value="Back" onClick="history.go(-2)" />

<?php } ?>

        </font>
    </body>
</html>