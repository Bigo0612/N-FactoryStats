<?php session_start();
require('inc/function.php');
$fichier = file_get_contents('asset/json/capture.json');
$json = json_decode($fichier, true);
//debug($json);

include("inc/header.php");
if (is_logged()) { ?>

    <div class="tcpudp">
        <canvas id="tcpudp"></canvas>
    </div>
    <div class="constructeur">
        <canvas id="constructeur"></canvas>
    </div>

    <div class="wrap-tab">
        <table id="tableau">
            <thead>
            <tr class="headtableau">
                <th>Date</th>
                <th>IP Source</th>
                <th>IP Destination</th>
                <th>MAC Source</th>
                <th>MAC Destination</th>
                <th>Constructeur</th>
                <th>Protocole</th>
                <th>Port Source</th>
                <th>Port Destination</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $tcp = 0;
            $udp = 0;
            $apple = 0;
            $intel = 0;
            $autres = 0;
            $count = count($json);
            for ($i = 0; $i < $count; $i++) {
                echo '<tr>';
                $short = $json[$i]['_source']['layers'];

                if (!empty($short['frame'])) {
                    echo '<td>' . $json[$i]['_source']['layers']['frame']['frame.time'] . '</td>';
                } else {
                    echo '<td>-</td>';
                }

                if (!empty($short['ip'])) {
                    echo '<td>' . $json[$i]['_source']['layers']['ip']['ip.src'] . '</td>';
                    echo '<td>' . $json[$i]['_source']['layers']['ip']['ip.dst'] . '</td>';
                } else {
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                }

                if (!empty($short['eth'])) {
                    echo '<td>' . $json[$i]['_source']['layers']['eth']['eth.src'] . '</td>';
                    echo '<td>' . $json[$i]['_source']['layers']['eth']['eth.dst'] . '</td>';
                    if ($json[$i]['_source']['layers']['eth']['eth.src_tree']['eth.src.oui_resolved'] == 'Apple, Inc.') {
                        $apple++;
                    } elseif ($json[$i]['_source']['layers']['eth']['eth.src_tree']['eth.src.oui_resolved'] == 'Intel Corporate') {
                        $intel++;
                    } else {
                        $autres++;
                    }
                } else {
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                }

                if (!empty($short['eth']['eth.dst_tree']['eth.dst.oui_resolved'])) {
                    echo '<td>' . $json[$i]['_source']['layers']['eth']['eth.dst_tree']['eth.dst.oui_resolved'] . '</td>';
                } else {
                    echo '<td>-</td>';
                }

                if (!empty($short['udp'])) {
                    echo '<td>UDP</td>';
                    echo '<td>' . $json[$i]['_source']['layers']['udp']['udp.srcport'] . '</td>';
                    echo '<td>' . $json[$i]['_source']['layers']['udp']['udp.dstport'] . '</td>';
                    $udp++;
                } else if (!empty($short['tcp'])) {
                    echo '<td>TCP</td>';
                    echo '<td>' . $json[$i]['_source']['layers']['tcp']['tcp.srcport'] . '</td>';
                    echo '<td>' . $json[$i]['_source']['layers']['tcp']['tcp.dstport'] . '</td>';
                    $tcp++;
                } else {
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                }
                echo '</tr>';
            }
            } else {
                header('Location: 403.php');
            }
            ?>
            </tbody>
        </table>
    </div>

    <script>
        var ctx = document.getElementById('tcpudp').getContext('2d');
        var tcpudp = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['TCP', 'UDP'],
                datasets: [{
                    label: 'Types de connexions',
                    data: [<?=$udp?>, <?=$tcp?>],
                    backgroundColor: [
                        'rgba(25,255,0,0.19)',
                        'rgba(235,0,8,0.2)'
                    ],
                    borderColor: [
                        'rgb(0,255,51)',
                        'rgb(235,0,16)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Protocole TCP / UDP',
                }
            }
        });

        var ctx2 = document.getElementById('constructeur').getContext('2d');
        var constructeur = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Apple', 'Intel', 'Autres'],
                datasets: [{
                    label: 'Types de connexions',
                    data: [<?=$apple?>, <?=$intel?>, <?=$autres?>],
                    backgroundColor: [
                        'rgba(255, 165, 0, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(155, 155, 155,0.2)',
                        'rgba(255, 0 ,0, 0.2)',
                        'rgba(40, 250 ,0, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 165, 0, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(155, 155, 155,1)',
                        'rgba(255, 0 ,0, 1)',
                        'rgba(40, 250 ,0, 1)'
                    ],

                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Constructeur de l\'appareil',
                }
            }
        });


    </script>


<?php require("inc/footer.php");