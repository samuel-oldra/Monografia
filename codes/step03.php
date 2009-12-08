<?php
$id = $_GET['id']; // Id da doença
$rel = '<b>Disease id</b><br />' . $id;
// Busca o relatório
$page = file('http://www.ncbi.nlm.nih.gov/entrez/dispomim.cgi?cmd=entry&id=' . $id);
foreach($page as $line)
    $texto .= $line;
// Encontra proteínas
$er = '(\b[A-Z]{1}[A-Z0-9]{1,5}\b)'; // Expressão regular
preg_match_all($er, $texto, $matches, PREG_SET_ORDER);
// Lista de palavras a serem retiradas
$listaRetirar = 'HTML HEAD TITLE OMIM HUMAN VIRUS TYPE TO BODY FFFFFF YAC 
CC3300 NAME NOBR HIV AIDS TEXT DATE EDIT ANIMAL MODEL NOD SEE ALSO TARGET 
CC3300 ONSET JOD IDDM CC3300 NIDDM OTHER II DQ0602 EIG W15 DR2 PCR NIDDM2 
NIDDM3 NIDDM4 SNP K121Q PNDM PDMI WITH AND DEND NDM PNDI C166F R201H PNMD 
I167L EEG F132L TNDM DCSIGN BDCA1 RNA DNA MOP020 GENE NSI BAT6 BAT7 BRCA3 
B44 B53 LSA PBD LOH D17S74 OCCR SSCP PCR VNTR SNP I1307K BRCATA I167L PCR 
YAC BRCA NIDDM3 ALPHA CAPAN1 QMPSF MIDD MTTL1 MTTE MTTK OXPHOS MELAS CELL 
A3243G FACTOR ECG GROWTH LYNCH TFGBR2 MVCD1 FROM MH PDR VEGR NSN ESN RFLP 
V67A C67X NSN A215 EMBO V67A A3243G CRC LIKE BALB RBS11 U937 HL60 THE FED 
DPED DPED LIKE IRAN MASON MODY6 CYSTS IDDM2 ILPR IDDM4 IGT IMDIAB HPC1 OR 
HPCX1 HPCX2 HPC4 HPC5 HPC1 ALSPAC HPCX1 HPC7 HPC9 HPC10 HPC11 HPC12 HPC13 
HPC14 HPC15 HPC14 V50 SOLUTE FAMILY ANION MEMBER BAND OF RED ASIAN SEVERE 
FORM FEVER TRAIT ONE TIRAP DUFFY SYSTEM BETA LOCUS VIVAX PFBI PFFE1 LOCUS 
FATTY GLOBIN DOMAIN PEPC IVS2 Q39X ACID MALP2 COS EL4 EC WHO FORM NO HPFH 
COS SAO MSP1';
// Remove proteínas e termos repetidos
foreach($matches as $proteina){
    foreach(split(' ', $proteinasEncontradas) as $val){
        if($val == $proteina[0])
            $existe = true;
    }
    foreach(split(' ', $listaRetirar) as $val){
        if($val == $proteina[0])
            $existe = true;
    }
    if(!$existe){
        if(count(split(' ', $proteinasEncontradas)) <= 15)
            $proteinasEncontradas .= $proteina[0] . ' ';
    }
    $existe = false;
}
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
            <img src="imgs/FluxoSoftware03.png" width="500" height="220" /><br /><br />
        </center>
        <table bgcolor="#FFD42A" width="100%">
        <tr><td>                            
            <table bgcolor="#FFFFAA" width="100%">
            <tr><td>                            
                Check the proteins found.<br />
                You can also add or remove proteins at the list.
            </td></tr>
            </table>                        
        </td></tr>
        </table><br />
        <form name="procuraProteinas" action="step04.php" method="post"
            enctype="multipart/form-data">
            <table border="0" align="center">
            <tr>
                <td align="center">
                    <font color="gray" size="2"><b><i>Proteins found</i></b></font><br />
                    <textarea name="proteinas" cols="80" rows="4">
                        <?=$proteinasEncontradas?>
                    </textarea><br /><br />
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="submit" name="next" value="Next" />
                    <input type="reset" name="revert" value="Revert" />
                    <input type="button" name="back" value="Back" onClick="history.go(-2)" />
                </td>
            </tr>
            </table>
        </form>
        <br />
        <?=$texto?>
        <input type="button" name="back" value="Back" onClick="history.go(-2)" />
        </font>
    </body>
</html>