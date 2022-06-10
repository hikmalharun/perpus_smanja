<?php
/**
 *
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/**
*
Grafik Jumlah Denda per Tahun untuk SLiMS 8 oleh Ruswandi, S.T. 
(www.sukabumikode.com | sukabumikode@gmail.com) 
*
*/

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../../sysconfig.inc.php';
// IP based access limitation
require LIB.'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-reporting');
// start the session
require SB.'admin/default/session.inc.php';
require SB.'admin/default/session_check.inc.php';
// privileges checking
$can_read = utility::havePrivilege('reporting', 'r');
$can_write = utility::havePrivilege('reporting', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to access this area!').'</div>');
}

require SIMBIO.'simbio_GUI/form_maker/simbio_form_element.inc.php';

  // years array
$years['2014'] = __('2014');
$years['2015'] = __('2015');
$years['2016'] = __('2016');
$years['2017'] = __('2017');
$years['2018'] = __('2018');
$years['2019'] = __('2019');
$years['2020'] = __('2020');
$years['2021'] = __('2021');

$page_title = 'Library fines Report by Mounth';
$reportView = false;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
    ?>
    <!-- filter -->
    <fieldset>
        <div class="per_title">
            <h2><?php echo __('Laporan Jumlah Denda Per Tahun'); ?></h2>
        </div>
        <div class="infoBox">
            <?php echo __('Report Filter'); ?>
        </div>
       
    </fieldset>
    <!-- filter end -->
    <iframe name="reportView" id="reportView" src="<?php echo $_SERVER['PHP_SELF'].'?reportView=true'; ?>" frameborder="0" style="width: 100%; height: 1000px;"></iframe>
    <?php
} else {
    ob_start();

    // table start

    ?>

    <?php
    $row_class = 'alterCellPrinted';
    $output = '<table align="center" class="border" style="width: 100%;" cellpadding="3" cellspacing="0">';

    // header
    $output .= '<tr>';
    $output .= '<td class="dataListHeaderPrinted">'.__('Nama Tahun').'</td>';
    foreach ($years as $year_num => $year) {
        $total_month[$year_num] = 0;
        $output .= '<td class="dataListHeaderPrinted">'.$year.'</td>';
    }
    $output .= '</tr>';



    $lable_name = 'Jumlah Denda';
    $r = 1;
    // count library member fines each month
    $row_class = ($r%2 == 0)?'alterCellPrinted':'alterCellPrinted2';
    $output .= '<tr>';
    $output .= '<td class="'.$row_class.'">'.$lable_name.'</td>'."\n";
    $outfines  = '';
    $outfines .= '{';
    $outfines .= 'fillColor : "#30c0fb",';
    $outfines .= 'title: "'.$lable_name.'",';
    $outfines .= 'data:[';
    foreach ($years as $year_num => $year) {
        $sql_str = "SELECT  SUM(debet)  FROM fines WHERE fines_date LIKE '$year%'";
        $fines_q = $dbs->query($sql_str);
        $fines_d = $fines_q->fetch_row();
        if ($fines_d[0] > 0) {
            $output .= '<td class="'.$row_class.'"><strong style="font-size: 1.5em;">'.$fines_d[0].'</strong></td>';
            $outfines .= $fines_d[0].',';
        } else {
            $output .= '<td class="'.$row_class.'"><span style="color: #ff0000;">'.$fines_d[0].'</span></td>';
            $outfines .= '0,';
        }
        $total_month[$year_num] += $fines_d[0];
    }
    $outfines .= ']},';
    $output .= '</tr>';
    $r++;

    $output .= '<tr>';
    $output .= '<td class="dataListHeaderPrinted">'.__('Total Denda / Tahun').'</td>';
    foreach ($years as $year_num => $year) {
        $output .= '<td class="dataListHeaderPrinted">'.$total_month[$year_num].'</td>';
    }
    $output .= '</tr>';

    $output .= '</table>';

    // print out
    echo '<div class="printPageInfo">Jumlah Denda Per Tahun <a class="printReport" onclick="window.print()" href="#">'.__('Print Current Page').'</a></div>'."\n";

    ?>
    <center><h2>Jumlah Denda Per Tahun</h2></center>

    <!-- Developed for SLiMS 8 by Ruswan, modified from visitor chart SLiMS 7 by Ido Alit -->

    <canvas id="chart" height="300" width="1100">Browser kamu tidak mendukung canvas element! Silahkan update browser anda!</canvas>
    <div id="lChart" style="padding: 6px 10px; border: 1px solid #ccc; margin: 10px 0;"></div>
    <script src="<?php echo JWB; ?>chartjs/Chart.min.js"></script>
    <script>
        var barChartData = {
            labels : [
            <?php
            foreach ($years as $year_num => $year) {
                $total_month[$year_num] = 0;
                echo '"'.$year.'", ';
            }
            ?>
            ],
            datasets : [<?php echo $outfines;?>]
        }
        var myLine = new Chart(document.getElementById("chart").getContext("2d")).Bar(barChartData);

        legend(document.getElementById("lChart"), barChartData);
        function legend(parent, data) {
            parent.className = 'legend';
            var datas = data.hasOwnProperty('datasets') ? data.datasets : data;

            datas.forEach(function(d) {
                var title = document.createElement('span');
                title.className = 'per_title';
            //title.style.background = d.hasOwnProperty('fillColor') ? d.fillColor : d.color;
            var borderColor = d.hasOwnProperty('fillColor') ? d.fillColor : d.color;
            title.style.borderLeft = '20px solid' + borderColor;
            title.style.padding = '0px 5px';
            title.style.margin = '5px';
            title.style.color = '#333';
            parent.appendChild(title);

            var text = document.createTextNode(d.title);
            title.appendChild(text);
        });
        }

    </script>
    <br/><br/>
    <?php
    echo $output;

    $content = ob_get_clean();
    // include the page template
    require SB.'/admin/'.$sysconf['admin_template']['dir'].'/printed_page_tpl.php';
}
