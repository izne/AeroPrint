<?php

$stationLines = [];
$stations = ['LBWN', 'LBBG', 'LBSF'];
$source = "https://metar.vatsim.net/metar.php?id=all";
$allMetar = file_get_contents($source);
$escposTemplate = file_get_contents("esc.pos");
$localTime = date("H:i").'L';
$contentData = null;
$lines = explode("\n", $allMetar);

foreach ($lines as $line)
    foreach ($stations as $station)
        if (strpos($line, $station) === 0)
            array_push($stationLines, $line);

foreach ($stationLines as $entry)
    $contentData .= '"'.$entry.'" LF'.PHP_EOL;


$template = str_replace('%titleLine%', "METAR / TAF  ", $escposTemplate);
$template = str_replace('%localTime%', $localTime, $template);
$template = str_replace('%contentData%', $contentData, $template);

echo $template;

?>