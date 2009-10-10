<?php
// Inicializar a sessão
session_start();
// Registrar variáveis
if (!session_is_registered('fluxo'))
    session_register('fluxo');
else
    $fluxo = $_SESSION['fluxo'];
// Nome do arquivo
$filename = 'flow.xml';
// Criando o arquivo XML
$xmlDoc = new domDocument('1.0', 'utf-8');
$xmlDoc->formatOutput = true;
$flow = $xmlDoc->createElement('flow');
$flow = $xmlDoc->appendChild($flow);
for($i = 0; $i < count($fluxo); $i++){
    $step = $xmlDoc->createElement('step', $fluxo[$i]);
    $step = $flow->appendChild($step);
}
$xmlDoc->save($filename);
// Download arquivo XML
header('Content-Type: application/save');
header('Content-Length:' . filesize($filename));
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Pragma: no-cache');
// Abrir e enviar o arquivo
$fp = fopen($filename, 'r');
fpassthru($fp);
fclose($fp);
exit;
?>