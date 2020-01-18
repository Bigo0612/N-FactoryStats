<?php
include ('inc/function.php');

$fichier = file_get_contents('asset/json/capture.json');
$json = json_decode($fichier, true);

debug($json);

$tableau = array();
$countTCP = 0;
$countUDP = 0;
$countIPV4 = 0;

foreach ($json as $j) {
    $time = $j['_source']['layers']['frame']['frame.time'];
    $source = $j['_source']['layers']['ip']['ip.src'];
    $destination = $j['_source']['layers']['ip']['ip.dst'];
    $protocol = $j['_source']['layers']['ip']['ip.dst'];
    $tableau[] = array(
            'time' => $time,
            'source' => $source,
            'destination' => $destination,
    );
}


debug($tableau);

echo $countTCP;


