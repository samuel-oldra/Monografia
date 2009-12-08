<?php
// Inicializar a sessão
session_start();
// Registrar variáveis
if (!session_is_registered('fluxo'))
    session_register('fluxo');
else
    $fluxo = $_SESSION['fluxo'];
// Texto adicionado pelo usuário
$textoUser = $_GET['textoUser'];
if($textoUser)
    $fluxo[count($fluxo)] = '<b>User comment</b><br />' . $textoUser;
// Texto adicionado pelo sistema
$textoSoft = $_GET['textoSoft'];
if($textoSoft)
    $fluxo[count($fluxo)] = $textoSoft;
// Fluxo adicionado pelo arquivo XML
$flowXML = $_FILES['flowXML'];
if($flowXML){
    $nome = $flowXML['name'];
    $tipo = $flowXML['type'];
    $tamanho = $flowXML['size'];
    $tmpNome = $flowXML['tmp_name'];
    // Verifica se existe um arquivo XML enviado
    if($tamanho > 0 and strlen($nome) > 1 and $tipo == 'text/xml'){
        // Caminho completo de destino do arquivo XML
        $caminho = realpath('.') . '/' . $nome;
        move_uploaded_file($tmpNome, $caminho);
        if(file_exists($caminho)){
            // Abre arquivo XML e carrega fluxo
            $xmlstr = file_get_contents($caminho);
            $xmlDoc = new domDocument();
            $xmlDoc->loadXML($xmlstr);
            $xml = simplexml_import_dom($xmlDoc);
            foreach($xml->step as $val)
                $fluxo[count($fluxo)] = (string) $val;
        }
    }
}
// Remove item
$removeItem = $_GET['$removeItem'];
if($removeItem > -1){
    if(count($fluxo) != 1){
        unset($fluxo[$removeItem]);
        array_unshift ($fluxo, array_shift($fluxo));
    }
    else
        unset($fluxo);
}
// Limpa fluxo
$limpaFluxo = $_GET['$limpaFluxo'];
if($limpaFluxo == 'yes')
    unset($fluxo);
// Salva a sessão
$_SESSION['fluxo'] = $fluxo;
?>

<html>
    <head>
        <title>.:: BioNet ::.</title>
    </head>
    <body bgcolor="#F4F4F4">
        <font face="verdana">
        <center>
            <table bgcolor="#FFD42A" width="100%">
            <tr><td>                            
                <table bgcolor="#FFFFAA" width="100%">
                <tr><td>
                    <font size="1">
                    To <b>erase</b> the current data mining click on <b>Clean flow</b>.
                    To <b>save</b> the current data mining click on <b>Download flow</b>.
                    To <b>load</b> a previously saved data mining, click the button
                    <b>Choose...</b>, locate the corresponding XML file and click the
                    button <b>Load</b>.
                    To <b>add</b> comments about the current data mining, use the text
                    box <b>User comments</b> and click the button <b>Add</b>.
                    </font>
                </td></tr>
                </table>                        
            </td></tr>
            </table><br />
            <table border="0" height="100%">
            <tr height="100"><td>
                <center>
                    <a href="flow.php?$limpaFluxo=yes" target="fluxo" title="Clean flow">
                        Clean flow
                    </a>
                    ::
                    <a href="createXMLFlow.php" target="_blank" title="Download flow">
                        Download flow
                    </a>
                    <br /><br />
                    
                    <font color="gray" size="2">
                    <b><i>Load flow</i></b><br />
                    <form name="loadFlowXML" action="flow.php" method="post"
                        enctype="multipart/form-data">
                        <input type="file" size="20" name="flowXML" /><br /><br />
                        <input type="submit" name="load" value="Load" />
                    </form>
                    
                    <b><i>User comments</i></b><br />
                    <form name="mostraRede" action="flow.php" method="get"
                        enctype="multipart/form-data">
                        <textarea name="textoUser" cols="30" rows="4"></textarea><br /><br />
                        <input type="submit" name="add" value="Add" />
                        <input type="reset" name="clear" value="Clear" />
                    </form>
                    </font>
                </center>
            </td></tr>
            <tr height="*" valign="top"><td>
                <font size="2">

<?php
// Apresenta o fluxo
for($i = 0; $i < count($fluxo); $i++)
    echo '<a href="flow.php?$removeItem=' . $i . '" target="fluxo" title="' . $i . '">
        [remove]</a> ' . $fluxo[$i] . '<br />';
?>

                </font>
            </td></tr>
            </table>
        </center>
        </font>
    </body>
</html>