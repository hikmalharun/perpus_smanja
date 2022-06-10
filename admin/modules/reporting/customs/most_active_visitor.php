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
10 Pengunjung Teraktif per Bulan oleh Ruswandi, S.T. 
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

$page_title = 'Library Visitor Report';
$reportView = false;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

 // months array
$months['01'] = __('Januari');
$months['02'] = __('Februari');
$months['03'] = __('Maret');
$months['04'] = __('April');
$months['05'] = __('Mei');
$months['06'] = __('Juni');
$months['07'] = __('Juli');
$months['08'] = __('Agustus');
$months['09'] = __('September');
$months['10'] = __('Oktober');
$months['11'] = __('November');
$months['12'] = __('Desember');


function MonthName($number)
{
    switch ($number) {
        case 1:
        return "Januari";
        break;
        case 2:
        return "Februari";
        break;
        case 3:
        return "Maret";
        break;
        case 4:
        return "April";
        break;
        case 5:
        return "Mei";
        break;
        case 6:
        return "Juni";
        break;
        case 7:
        return "Juli";
        break;
        case 8:
        return "Agustus";
        break;
        case 9:
        return "September";
        break;
        case 10:
        return "Oktober";
        break;
        case 11:
        return "November";
        break;
        case 12:
        return "Desember";
        break;
    }
}

if (!$reportView) {
    ?>
    <!-- filter -->
    <fieldset>
        <div class="per_title">
            <h2><?php echo __('Laporan 10 Pengunjung Teraktif'); ?></h2>
        </div>
        <div class="infoBox">
            <?php echo __('Report Filter'); ?>
        </div>
        <div class="sub_section">
            <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="reportView">
                <div id="filterForm">
                    <div class="divRow">
                        <div class="divRowLabel"><?php echo __('Year'); ?></div>
                        <div class="divRowContent">
                            <?php
                            $current_year = date('Y');
                            $year_options = array();
                            for ($y = $current_year; $y > 1999; $y--) {
                                $year_options[] = array($y, $y);
                            }
                            echo simbio_form_element::selectList('year', $year_options, $current_year);
                            ?>
                        </div>
                    </div>
                </div>

                <div id="filterForm">
                    <div class="divRow">
                        <div class="divRowLabel"><?php echo __('Bulan'); ?></div>
                        <div class="divRowContent">
                            <?php
                            $current_month = date('m');
                            $month_options = array();
                            foreach ($months as $month => $value) {
                             $month_options[] = array($month, $value);
                         }

                         echo simbio_form_element::selectList('month', $month_options, $current_month);
                         ?>
                     </div>
                 </div>
             </div>

             <div style="padding-top: 10px; clear: both;">
                <input type="submit" name="applyFilter" value="<?php echo __('Apply Filter'); ?>" />
                <input type="hidden" name="reportView" value="true" />
            </div>
        </form>
    </div>
</fieldset>
<!-- filter end -->
<iframe name="reportView" id="reportView" src="<?php echo $_SERVER['PHP_SELF'].'?reportView=true'; ?>" frameborder="0" style="width: 100%; height: 1000px;"></iframe>
<?php
} else {
    ob_start();


  // year
    $selected_year = date('Y');
    if (isset($_GET['year']) AND !empty($_GET['year'])) {
        $selected_year = (integer)$_GET['year'];
    }

    // month
    $selected_month = date('m');
    if (isset($_GET['month']) AND !empty($_GET['month'])) {
        $selected_month = (integer)$_GET['month'];
    }


     // print out
    echo '<div class="printPageInfo">'. str_replace('{selectedYear}', $selected_year,__('Laporan Pengunjung Teraktif')).' <a class="printReport" onclick="window.print()" href="#">'.__('Print Current Page').'</a></div>'."\n";
    ?>

    <center><h3>Laporan 10 Pengunjung Teraktif Bulan <?php echo MonthName($selected_month);?> Tahun <?php echo $selected_year;?></h3></center>
    <hr/>

    <!-- Start Table -->
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Jumlah Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql_str = "SELECT v.member_id, count(v.member_id)  as jml, m.member_name FROM visitor_count AS v join member as m on v.member_id=m.member_id  WHERE YEAR(v.checkin_date)=".$selected_year." AND MONTH(v.checkin_date)=".$selected_month." group by v.member_id order by jml desc limit 10";
            $visitor_q = $dbs->query($sql_str);
            $no = 1;
            while ($data = $visitor_q->fetch_row()) {
                echo "
                <tr>
                <td>".$no."</td>
                <td>".$data[0]."</td>
                <td>".$data[2]."</td>
                <td>".$data[1]."</td>
                </tr>
                "; $no++; } ?>
            </tbody>
        </table>
        <!-- End Table -->
        <?php

        $content = ob_get_clean();
    // include the page template
        require SB.'/admin/'.$sysconf['admin_template']['dir'].'/printed_page_tpl.php';
    }
