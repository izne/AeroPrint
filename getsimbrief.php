<?php

$simBriefUrl = "https://www.simbrief.com/api/xml.fetcher.php?username=DAngelov&json=1";

$dataLoad = file_get_contents($simBriefUrl);
$dataArray = json_decode($dataLoad, true);

$output = null;


$pAirac = $dataArray['params']['airac'];
$pCallsign = $dataArray['atc']['callsign'];
$pOrig = $dataArray['origin']['icao_code'] .'/'. $dataArray['origin']['plan_rwy'];
$pRoute = $dataArray['general']['route_ifps']; 
$pDest = $dataArray['destination']['icao_code'] .'/'. $dataArray['destination']['plan_rwy'];
$pRouteDist = $dataArray['general']['route_distance'];
$pTotalBurn = $dataArray['general']['total_burn']; //.' '. $dataArray['params']['units'];
$pAlternate = $dataArray['alternate']['icao_code'];
$pDistToAlt = $dataArray['alternate']['distance'];
$pPax = $dataArray['general']['passengers'];
$pCargo = $dataArray['weights']['cargo']; 
$pEstTow = $dataArray['weights']['est_tow'];
$pPayload = $dataArray['weights']['payload']; 
$pCapt = $dataArray['crew']['cpt']; 
$pFo = $dataArray['crew']['fo']; 
$pAcftType = $dataArray['api_params']['type']; 
$pAcftReg = $dataArray['api_params']['reg']; 
$pFuelTakeoff = $dataArray['fuel']['plan_takeoff']; 
$pFuelLanding = $dataArray['fuel']['plan_landing']; 
$pFuelTaxi = $dataArray['fuel']['taxi']; 


$escposTemplate = file_get_contents("esc.pos");
// \"FUEL: TAXI $pFuelTaxi TO $pFuelTakeoff ENROUTE $pTotalBurn\" LF
$contentData = 
"
\"$pCallsign $pAcftType $pAcftReg AIRAC $pAirac \" LF
\"$pOrig  $pRoute  $pDest \" LF
\"DIST $pRouteDist ALT $pAlternate DIST $pDistToAlt \" LF
\"PAX $pPax CARGO $pCargo PAYLOAD $pPayload TOW $pEstTow\" LF
";

$localTime = date("H:i").'L';
$template = str_replace('%titleLine%', "SIMBRIEF  ", $escposTemplate);
$template = str_replace('%localTime%', "$localTime", $template);
$template = str_replace('%contentData%', $contentData, $template);

echo $template;

?>