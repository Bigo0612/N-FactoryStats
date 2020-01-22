<?php
include ('inc/function.php');

$fichier = file_get_contents('asset/json/capture.json');
$json = json_decode($fichier, true);

debug($json);

$tableau = array();
$countTCP = 0;
$countUDP = 0;


foreach ($json as $j) {
    $time = $j['_source']['layers']['frame']['frame.time'];

    if(!empty($j['_source']['layers']['ip']['ip.src'])) {
        $ipSrc = $j['_source']['layers']['ip']['ip.src'];
    } else {
        $ipSrc = '';
    }

    if (!empty($j['_source']['layers']['ip']['ip.dst'])) {
        $ipDst = $j['_source']['layers']['ip']['ip.dst'];
    } else {
        $ipDst = '';
    }

    $ethSrc =$j['_source']['layers']['eth']['eth.src'];
    $ethDst =$j['_source']['layers']['eth']['eth.dst'];

    if (!empty($j['_source']['layers']['tcp']['tcp.srcport'])){
        $tcpSrc = $j['_source']['layers']['tcp']['tcp.srcport'];
    } else {
        $tcpSrc = '';
    }

    if (!empty($j['_source']['layers']['udp']['udp.srcport'])){
        $udpSrc = $j['_source']['layers']['udp']['udp.srcport'];
    } else {
        $udpSrc = '';
    }

    if (!empty($j['_source']['layers']['eth']['eth.dst_tree']['eth.dst.oui_resolved'])){
        $constructeur = $j['_source']['layers']['eth']['eth.dst_tree']['eth.dst.oui_resolved'];
    } else {
        $constructeur = '';
    }




    $tableau[] = array(
            'time' => $time,
            'ip_source' => $ipSrc,
            'ip_destination' => $ipDst,
            'adresse_MAC_source' => $ethSrc,
            'adresse_MAC_destination' => $ethDst,
            'tcp_source' => $tcpSrc,
            'udp_source' => $udpSrc,
            'constructeur' => $constructeur
    );
}


debug($tableau);



