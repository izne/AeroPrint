<?php

$cmd = "/c/Users/izne/Downloads/senddat.exe -t -b9600 data.txt 192.168.178.212:9100";
$stations = ['LBWN', 'LBBG', 'LBSF', 'EDHI', 'EHAM'];
$source = "https://metar.vatsim.net/metar.php?id=all";

$allMetar = file_get_contents($source);
$escposTemplate = file_get_contents("metar.esc");

$localTime = date("H:i");
$localTime .= 'L';

$lines = explode("\n", $allMetar);

$stationLines = [];
$metarData = null;

foreach ($lines as $line)
{
    foreach ($stations as $station)
    {
        if (strpos($line, $station) === 0)
        {
            array_push($stationLines, $line);
        }
    }
}

foreach ($stationLines as $entry)
    $metarData .= '"'.$entry.'" LF'.PHP_EOL;

$localTime = " \"$localTime\" LF LF";

$template = str_replace('%localTime%', $localTime, $escposTemplate);
$template = str_replace('%metarData%', $metarData, $template);

echo $template;

?>