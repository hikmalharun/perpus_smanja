<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-07-05 09:50
 * @File name           : index.php
 *
 * Background vector created by Patrickss - www.freepik.com
 * Source: https://www.freepik.com/free-photos-vectors/background
 */

/* Member card print */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../../sysconfig.inc.php';
// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-membership');
// start the session
require SB . 'admin/default/session.inc.php';
require SB . 'admin/default/session_check.inc.php';
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require SIMBIO . 'simbio_DB/simbio_dbop.inc.php';
require 'Arr.php';

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
  die('<div class="errorBox">You dont have enough privileges to view this section</div>');
}

// local settings
$max_print = 10;

// clean print queue
if (isset($_GET['action']) AND $_GET['action'] == 'clear') {
  // update print queue count object
  echo '<script type="text/javascript">parent.$(\'#queueCount\').html(\'0\');</script>';
  utility::jsAlert(__('Print queue cleared!'));
  unset($_SESSION['card']);
  exit();
}

if (isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])) {
  if (!$can_read) {
    die();
  }
  if (!is_array($_POST['itemID'])) {
    // make an array
    $_POST['itemID'] = array($_POST['itemID']);
  }
  // loop array
  if (isset($_SESSION['card'])) {
    $print_count = count($_SESSION['card']);
  } else {
    $print_count = 0;
  }
  // card size
  $size = 2;
  // create AJAX request
  echo '<script type="text/javascript" src="' . JWB . 'jquery.js"></script>';
  echo '<script type="text/javascript">';
  // loop array
  foreach ($_POST['itemID'] as $itemID) {
    if ($print_count == $max_print) {
      $limit_reach = true;
      break;
    }
    if (isset($_SESSION['card'][$itemID])) {
      continue;
    }
    if (!empty($itemID)) {
      $card_text = trim($itemID);
      echo '$.ajax({url: \'' . SWB . 'lib/phpbarcode/barcode.php?code=' . $card_text . '&encoding=' . $sysconf['barcode_encoding'] . '&scale=' . $size . '&mode=png\', type: \'GET\', error: function() { alert(\'Error creating member card!\'); } });' . "\n";
      // add to sessions
      $_SESSION['card'][$itemID] = $itemID;
      $print_count++;
    }
  }
  echo '</script>';
  if (isset($limit_reach)) {
    $msg = str_replace('{max_print}', $max_print, __('Selected items NOT ADDED to print queue. Only {max_print} can be printed at once')); //mfc
    utility::jsAlert($msg);
  } else {
    // update print queue count object
    echo '<script type="text/javascript">parent.$(\'#queueCount\').html(\'' . $print_count . '\');</script>';
    utility::jsAlert(__('Selected items added to print queue'));
  }
  exit();
}

// card pdf download
if (isset($_GET['action']) AND $_GET['action'] == 'print') {
  // check if label session array is available
  if (!isset($_SESSION['card'])) {
    utility::jsAlert(__('There is no data to print!'));
    die();
  }
  if (count($_SESSION['card']) < 1) {
    utility::jsAlert(__('There is no data to print!'));
    die();
  }
  // concat all ID together
  $member_ids = '';
  foreach ($_SESSION['card'] as $id) {
    $member_ids .= '\'' . $id . '\',';
  }
  // strip the last comma
  $member_ids = substr_replace($member_ids, '', -1);

  $member_q = $dbs->query('SELECT m.member_name, m.member_id, m.member_image, m.member_address, m.member_email, m.inst_name, m.postal_code, m.pin, m.member_phone, m.expire_date, m.register_date, m.birth_date, mt.member_type_name FROM member AS m
        LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id
        WHERE m.member_id IN(' . $member_ids . ')');
  $member_datas = array();
  while ($member_d = $member_q->fetch_assoc()) {
    if ($member_d['member_id']) {
      $member_datas[] = $member_d;
    }
  }
  // Tanggal lahir anggota
  
  // member card setting
  $default_setting = include('default.php');

  if (!function_exists('conf')) {
    function conf($key, $allow_array = false)
    {
      global $sysconf, $default_setting;

      $getValue = function ($keys, $array) {
        foreach ($keys as $key) {
          if (is_array($array)) $array = $array[$key];
        }
        return $array;
      };

      $keys = explode('.', $key);
      if (isset($sysconf['membercard_ia'])) {
        $value = $getValue($keys, $sysconf['membercard_ia']);
        if ($value == '') {
          $value = $getValue($keys, $default_setting);
          if (isset($value['default'])) return $value['default'];
        }
      } else {
        $value = $getValue($keys, $default_setting);
        if (isset($value['default'])) return $value['default'];
      }

      return $value;
    }
  }
  if (!function_exists('display')) {
    function display($key, $display = 'block')
    {
      if (conf($key)) return $display;
      return 'none';
    }
  }

  // combine variable
  $assets = MWB . 'membership/card/assets/';
  $image = SWB . 'images/persons/';
  $conf = 'conf';
  $display = 'display';
  $intval = 'intval';
  $rules = '';
  foreach (conf('back.rules.rules') as $item) {
    $rules .= '<div>' . $item . '</div>';
  }

  $content_str = '';
  $n = 1;
  foreach ($member_datas as $member_data) {
    if (conf('back.layout') == 'logo') {
      $back = <<<HTML
<div class="box box-front flex flex-col justify-center items-center">
    <img style="width:{$conf('back.logo.width')};height:{$conf('back.logo.height')}" class="w-12 h-12" src="{$conf('back.logo.path')}" alt="logo">
    <h1 style="color:{$conf('back.logo.libraryName.color')};font-size:{$conf('back.logo.libraryName.size')}" class="text-lg font-bold">{$conf('back.logo.libraryName.text')}</h1>
    <span style="color:{$conf('back.logo.librarySubName.color')};font-size:{$conf('back.logo.librarySubName.size')}" class="text-xs">{$conf('back.logo.librarySubName.text')}</span>
</div>
HTML;
    } else {
      $back = <<<HTML
<div class="box box-front flex flex-col justify-center items-center">
    <div class="rules w-full h-full rounded opacity-75 p-2 flex flex-col justify-between">
        <div>
            <h1 class="font-bold text-xs">{$conf('back.rules.title')}</h1>
            {$rules}
        </div>
        <div>
        <strong>Perpustakaan Ulil Albab</strong>
        </div>
    </div>
</div>
HTML;
    }

    $biodata = '';
    foreach (conf('front.profile', true) as $key => $item) {
      $show = isset($item['show']['default']) ? $item['show']['default'] : $item['show'];
      if (!$show) continue;
      $biodata .= '<div class="flex flex-row-reverse items-center pb-1">';
      $src = isset($item['icon']) ? (isset($item['icon']['default']) ? $item['icon']['default'] : $item['icon']) : $default_setting['front']['profile'][$key]['icon']['default'];
      $biodata .= '<img class="w-3 h-3" src="' . $src . '" alt="">';
      $member_key = isset($item['key']['default']) ? $item['key']['default'] : $item['key'];
      $biodata .= '<span class="px-2 leading-none">' . $member_data[$member_key] . '</span>';
      $biodata .= '</div>';
    }

    $photo_path = $image . 'avatar.jpg';
    if ($member_data['member_image']) $photo_path = $image . $member_data['member_image'];

    $front = <<<HTML
<div class="box box-back flex flex-col justify-between">
    <div class="flex justify-between">
        <div class="flex flex-col pl-12">
            <h1 style="color:{$conf('front.memberName.color')};font-size:{$conf('front.memberName.size')}" class="text-sm font-bold">{$member_data['member_name']}</h1>
            <span style="color:{$conf('front.memberId.color')};font-size:{$conf('front.memberId.size')}" class="text-xs">{$member_data['member_id']}</span>
        </div>
        <div style="padding:5px;background:#fff;display:{$display('front.qrcode.show')};width:{$conf('front.qrcode.width')};height:{$conf('front.qrcode.height')}" id="qrcode-{$member_data['member_id']}" class="w-10 h-10 rounded"></div>
    </div>
    <div class="flex">
        <div class="flex items-end w-24"><img style="display:{$display('front.photo.show')};width:{$conf('front.photo.width')};height:{$conf('front.photo.height')}" class="rounded" src="{$photo_path}" alt=""></div>
        <div class="flex-1 flex flex-col items-end">
            <div class="flex-1 flex flex-col justify-center items-end text-right biodata">
                {$biodata}
            </div>
            <div style="display:{$display('front.barcode.show', 'flex')};width:{$conf('front.barcode.width')};height:{$conf('front.barcode.height')}" class="h-8 overflow-hidden flex justify-end -mr-2">
                <svg id="barcode-{$member_data['member_id']}"></svg>
            </div>
        </div>
    </div>
</div>
<script>JsBarcode("#barcode-{$member_data['member_id']}", "{$member_data['member_id']}", { height: 60, displayValue: false });</script>
<script>new QRCode(document.getElementById("qrcode-{$member_data['member_id']}"), {text: "{$member_data['member_id']}", width: "{$intval($conf('front.qrcode.width'))}", height: "{$intval($conf('front.qrcode.height'))}"});</script>
HTML;

    // combine it
    $content_str .= '<div class="flex flex-row justify-center pb-2">';
    $content_str .= $back . '<div class="w-2" style="width:' . conf('general.space') . '"></div>' . $front;
    $content_str .= '</div>';

    if ($n % intval(conf('general.breakAfterRow')) == 0) {
      $content_str .= '<div class="page-break"></div>';
    }
    $n++;
  }

  // create html ouput
  $html_str = <<<HTML
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="{$assets}tailwind.min.css" rel="stylesheet">

    <title>Assalamualaikum Mas Ilmi</title>
    <style>
        ol, ul {list-style: square;}
        .box {
            width: 325px; /* 325.03937008 = 8.6cm */
            height: 204px; /*204.09448819px = 5.4cm */
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .box-front {
            background: #ffffff url('{$conf('back.background')}') no-repeat left;
            background-size: cover;
            padding: 0.5rem;
        }
        .box-back {
            background: #ffffff url('{$conf('front.background')}') no-repeat left;
            background-size: cover;
            padding: 1rem;
        }
        .biodata {
            font-size: 10px;
        }
        .rules {
            font-size: {$conf('back.rules.size')};
            color: {$conf('back.rules.color')};
        }
        .footer {
            font-size: 7px;
        }
        .sign {
            top: 10px;
            left: -10px;
        }
        .sign .stamp {
            width: 30px;
        }
        .sign .signature {
            width: 30px;
            margin-left: -10px;
        }
        @media print {
            .no-print, .no-print * {
                display: none !important;
            }

            .no-margin-on-print {
                padding: 0 !important;
                margin: 0 !important;
            }
            
            .box {
                box-shadow: none;
                border: 1px solid #f1f1f1;
            }
            
            body.bg-gray-200 {
                background: transparent;
            }
            
            body.p-4 {
                padding: 0;
            }
            
            .page-break {
                page-break-after: always;
            }
        }
    </style>
    <script src="{$assets}JsBarcode.code128.min.js"></script>
    <script src="{$assets}qrcode.min.js"></script>
  </head>
  <body class="bg-gray-200 p-4">
    <div class="fixed left-0 top-0 z-50 pt-4 pl-3 no-print">
        <a class="w-12 h-12 p-3 shadow-lg flex-no-shrink flex flex-col justify-center items-center text-center rounded-full bg-green-500 hover:bg-green-600 no-underline text-white"
           href="#"
           title="print this card"
           onclick="window.print()">
            <svg
                    class="fill-current w-12 h-12"
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px" y="0px" width="458.6px"
                    height="482.5px" viewBox="0 0 458.6 482.5"
                    style="enable-background:new 0 0 458.6 482.5;"
                    xml:space="preserve">
                <path d="M387.3,98.9h-12.4V71.3c0-39.3-32-71.3-71.3-71.3H153.9c-39.3,0-71.3,32-71.3,71.3v27.6H71.3
                    C32,98.9,0,130.9,0,170.2v115c0,39.3,32,71.3,71.3,71.3h11.2v90.4c0,19.6,16,35.6,35.6,35.6h221.1c19.6,0,35.6-16,35.6-35.6v-90.4
                    h12.5c39.3,0,71.3-32,71.3-71.3v-115C458.6,130.9,426.6,98.9,387.3,98.9z M109.5,71.3c0-24.4,19.9-44.3,44.3-44.3h149.6
                    c24.4,0,44.3,19.9,44.3,44.3v27.6H109.5V71.3z M347.8,447.1c0,4.7-3.9,8.6-8.6,8.6H118.1c-4.7,0-8.6-3.9-8.6-8.6V298h238.3V447.1z
                     M431.6,285.3c0,24.4-19.9,44.3-44.3,44.3h-12.4V298h17.8c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-330c-7.5,0-13.5,6-13.5,13.5
                    s6,13.5,13.5,13.5h19.9v31.6H71.3c-24.4,0-44.3-19.9-44.3-44.3v-115c0-24.4,19.9-44.3,44.3-44.3h316c24.4,0,44.3,19.9,44.3,44.3
                    V285.3z M128.7,350.9c0-7.5,6-13.5,13.5-13.5h171.9c7.5,0,13.5,6,13.5,13.5s-6,13.5-13.5,13.5H142.2
                    C134.8,364.4,128.7,358.4,128.7,350.9z M328.6,406.1c0,7.5-6,13.5-13.5,13.5H143.2c-7.5,0-13.5-6-13.5-13.5s6-13.5,13.5-13.5h172
                    C322.6,392.6,328.6,398.6,328.6,406.1z M400.5,165.4c0,7.5-6,13.5-13.5,13.5h-27.4c-7.5,0-13.5-6-13.5-13.5s6-13.5,13.5-13.5H387
                    C394.5,151.9,400.5,157.9,400.5,165.4z"/>
            </svg>
        </a>
    </div>
    {$content_str}
    <div class="no-print pt-4 text-right">
        <hr>
        
        </div>
    </div>
  </body>
</html>
HTML;

  // unset the session
  unset($_SESSION['card']);
  // write to file
  $print_file_name = 'member_card_gen_print_result_' . strtolower(str_replace(' ', '_', $_SESSION['uname'])) . '.html';
  $file_write = @file_put_contents(UPLOAD . $print_file_name, $html_str);
  if ($file_write) {
    // update print queue count object
    echo '<script type="text/javascript">parent.$(\'#queueCount\').html(\'0\');</script>';
    // open result in window
    echo '<script type="text/javascript">top.jQuery.colorbox({href: "' . SWB . FLS . '/' . $print_file_name . '", iframe: true, width: 950, height: 600, title: "' . __('Member Card Printing') . '"})</script>';
  } else {
    utility::jsAlert(str_replace('{directory}', SB . FLS, __('ERROR! Cards failed to generate, possibly because {directory} directory is not writable')));
  }
  exit();
}

?>
    <fieldset class="menuBox">
        <div class="menuBoxInner printIcon">
            <div class="per_title">
                <h2><?php echo __('Member Card Printing'); ?></h2>
            </div>
            <div class="sub_section">
                <div class="btn-group">
                    <a target="blindSubmit" href="<?php echo MWB; ?>membership/card/index.php?action=clear"
                       class="notAJAX btn btn-default" style="color: #f00;"><i class="glyphicon glyphicon-trash"></i>&nbsp;<?php echo __('Clear Print Queue'); ?>
                    </a>
                    <a target="blindSubmit" href="<?php echo MWB; ?>membership/card/index.php?action=print"
                       class="notAJAX btn btn-default"><i
                                class="glyphicon glyphicon-print"></i>&nbsp;<?php echo __('Print Member Cards'); ?>
                    </a>
                    <a href="<?php echo MWB; ?>membership/card/setting_editor.php"
                       class="btn btn-default"
                       title="<?php echo __('Member card print settings'); ?>"><i
                                class="glyphicon glyphicon-wrench"></i></a>
                </div>
                <form name="search" action="<?php echo MWB; ?>membership/card/index.php" id="search" method="get"
                      style="display: inline;"><?php echo __('Search'); ?>:
                    <input type="text" name="keywords" size="30"/>
                    <input type="submit" id="doSearch" value="<?php echo __('Search'); ?>" class="button"/>
                </form>
            </div>
            <div class="infoBox">
              <?php
              echo __('Maximum') . ' <font style="color: #f00">' . $max_print . '</font> ' . __('records can be printed at once. Currently there is') . ' '; //mfc
              if (isset($_SESSION['card'])) {
                echo '<font id="queueCount" style="color: #f00">' . count($_SESSION['card']) . '</font>';
              } else {
                echo '<font id="queueCount" style="color: #f00">0</font>';
              }
              echo ' ' . __('in queue waiting to be printed.'); //mfc
              ?>
            </div>
        </div>
    </fieldset>
<?php
/* search form end */
/* ITEM LIST */
// table spec
$table_spec = 'member AS m
    LEFT JOIN mst_member_type AS mt ON m.member_type_id=mt.member_type_id';
// create datagrid
$datagrid = new simbio_datagrid();
$datagrid->setSQLColumn('m.member_id',
  'm.member_id AS \'' . __('Member ID') . '\'',
  'm.member_name AS \'' . __('Member Name') . '\'',
  'mt.member_type_name AS \'' . __('Membership Type') . '\'');
$datagrid->setSQLorder('m.last_update DESC');
// is there any search
if (isset($_GET['keywords']) AND $_GET['keywords']) {
  $keyword = $dbs->escape_string(trim($_GET['keywords']));
  $words = explode(' ', $keyword);
  if (count($words) > 1) {
    $concat_sql = ' (';
    foreach ($words as $word) {
      $concat_sql .= " (m.member_id LIKE '%$word%' OR m.member_name LIKE '%$word%'";
    }
    // remove the last AND
    $concat_sql = substr_replace($concat_sql, '', -3);
    $concat_sql .= ') ';
    $datagrid->setSQLCriteria($concat_sql);
  } else {
    $datagrid->setSQLCriteria("m.member_id LIKE '%$keyword%' OR m.member_name LIKE '%$keyword%'");
  }
}
// set table and table header attributes
$datagrid->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
// edit and checkbox property
$datagrid->edit_property = false;
$datagrid->chbox_property = array('itemID', __('Add'));
$datagrid->chbox_action_button = __('Add To Print Queue');
$datagrid->chbox_confirm_msg = __('Add to print queue?');
$datagrid->column_width = array('10%', '70%', '15%');
// set checkbox action URL
$datagrid->chbox_form_URL = $_SERVER['PHP_SELF'];
// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 20, $can_read);
if (isset($_GET['keywords']) AND $_GET['keywords']) {
  echo '<div class="infoBox">' . __('Found') . ' ' . $datagrid->num_rows . ' ' . __('from your search with keyword') . ': "' . $_GET['keywords'] . '"</div>'; //mfc
}
echo $datagrid_result;
/* main content end */
