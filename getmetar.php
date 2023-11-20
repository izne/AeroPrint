<?php

$stationLines = [];
$stations = ['LBWN', 'LBBG', 'LBSF'];
$source = "https://metar.vatsim.net/metar.php?id=all";
$allMetar = file_get_contents($source);
$escposTemplate = file_get_contents("metar.esc");
$localTime = date("H:i").'L';
$metarData = null;
$lines = explode("\n", $allMetar);

foreach ($lines as $line)
    foreach ($stations as $station)
        if (strpos($line, $station) === 0)
            array_push($stationLines, $line);

foreach ($stationLines as $entry)
    $metarData .= '"'.$entry.'" LF'.PHP_EOL;

$localTime = " \"$localTime\" LF LF";

$template = str_replace('%localTime%', $localTime, $escposTemplate);
$template = str_replace('%metarData%', $metarData, $template);

echo $template;

?>