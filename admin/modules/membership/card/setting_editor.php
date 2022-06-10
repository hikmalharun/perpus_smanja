<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2019-07-05 09:56
 * @File name           : settings_editor.php
 */

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
require SIMBIO . 'simbio_DB/simbio_dbop.inc.php';
require SIMBIO . 'simbio_FILE/simbio_file_upload.inc.php';
require 'Arr.php';

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
  die('<div class="errorBox">You dont have enough privileges to view this section</div>');
}

// load setting from database
utility::loadSettings($dbs);

$old_setting = [];
if (isset($sysconf['membercard_ia']) && is_array($sysconf['membercard_ia']))
  $old_setting = Arr::unpack($sysconf['membercard_ia'], Arr::UNPACK_PRESERVE_LIST_ARRAY);

if (isset($_POST['updateSettings'])) {
  // fix array value
  if (isset($_POST['array']) && count($_POST['array']) > 0) {
    foreach ($_POST['array'] as $ka) {
      $_POST[str_replace('.', '_', $ka)] = explode(';', $_POST[str_replace('.', '_', $ka)]);
    }
  }
  // from post
  $setting1 = Arr::filterByKeys(Arr::pack($_POST, '_'), ['general', 'front', 'back']);
  // from file
  $image_upload = new simbio_file_upload();
  $image_upload->setAllowableFormat($sysconf['allowed_images']);
  $image_upload->setMaxSize($sysconf['max_image_upload'] * 1024);
  $image_upload->setUploadDir(UPLOAD . 'membercard');
  $raw_setting2 = [];
  foreach ($_FILES as $key => $file) {
    if ($file['size'] > 0) {
      $img_upload_status = $image_upload->doUpload($key, preg_replace('@\s+@i', '_', $file['name']));
      if ($img_upload_status == UPLOAD_SUCCESS) {
        $raw_setting2[$key] = SWB . 'files/membercard/' . $dbs->escape_string($image_upload->new_filename);
      } else {
        if (!empty($old_setting))
          $raw_setting2[$key] = $old_setting[str_replace('_', Arr::KEY_SEPARATOR, $key)];
      }
    } else {
      if (!empty($old_setting)) {
        if (isset($old_setting[str_replace('_', Arr::KEY_SEPARATOR, $key)])) {
          $raw_setting2[$key] = $old_setting[str_replace('_', Arr::KEY_SEPARATOR, $key)];
        }
      }
    }
  }
  $setting2 = Arr::pack($raw_setting2, '_');
  $settings = array_merge_recursive($setting1, $setting2);

  $sql_op = new simbio_dbop($dbs);
  $data['setting_value'] = serialize($settings);
  $data['setting_name'] = 'membercard_ia';
  $insert = $sql_op->insert('setting', $data);
  if ($insert) {
    utility::jsAlert('Setting updated!!');
  } else {
    unset($data['setting_name']);
    $update = $sql_op->update('setting', $data, "setting_name='membercard_ia'");
    if (!$update) {
      utility::jsAlert('Update setting FAILED!');
    } else {
      utility::jsAlert('Setting updated!');
    }
  }
}

?>

    <fieldset class="menuBox">
        <div class="menuBoxInner printIcon">
            <div class="per_title">
                <h2><?php echo __('Member Card Printing Settings'); ?></h2>
            </div>
            <div class="sub_section">
                <a href="<?php echo MWB; ?>membership/card/index.php"
                   class="btn btn-default"><i
                            class="glyphicon glyphicon-arrow-left"></i>&nbsp;<?php echo __('Back to Member List'); ?>
                </a>
                <a href="<?php echo MWB; ?>membership/card/setting_editor.php"
                   class="btn btn-default"><i
                            class="glyphicon glyphicon-refresh"></i>&nbsp;<?php echo __('Reload'); ?>
                </a>
            </div>
        </div>
    </fieldset>

<?php

function itOr($arr, $key, $or)
{
  return isset($arr[$key]) ? $arr[$key] : $or;
}

// create form instance
$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'], 'post');
$form->submit_button_attr = 'name="updateSettings" value="' . __('Save Settings') . '" class="btn btn-primary"';

// form table attributes
$form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

$default_settings = include('default.php');
$sysconf_settings = [];
if (isset($sysconf['membercard_ia']) && is_array($sysconf['membercard_ia'])) {
  $sysconf_settings = Arr::unpack($sysconf['membercard_ia'], Arr::UNPACK_PRESERVE_LIST_ARRAY);
}

foreach (Arr::unpack($default_settings, Arr::UNPACK_PRESERVE_ASSOC_ARRAY) as $key => $value) {
  if (!is_array($value)) continue;
  if ($value['type'] == 'string') {
    $form->addTextField('text', $key, $key, itOr($sysconf_settings, $key, $value['default']), 'style="width: 50%;"');
  } elseif ($value['type'] == 'color') {
    $form->addTextField('text', $key, $key, itOr($sysconf_settings, $key, $value['default']), 'style="width: 50%;"', 'Warna bisa menggunakan notasi Heksadesimal (hex) seperti <code>#000000</code> atau Red Green Blue (rgb) seperti <code>rgb(0,0,0)</code>');
  } elseif ($value['type'] == 'boolean') {
    $options = null;
    $options[] = array('0', __('No'));
    $options[] = array('1', __('Yes'));
    $form->addSelectList($key, $key, $options, itOr($sysconf_settings, $key, $value['default']), 'style="width: 120px"');
  } elseif ($value['type'] == 'image') {
    $str_input = '<div id="' . $key . '"><a href="' . itOr($sysconf_settings, $key, $value['default']) . '" title="' . basename(itOr($sysconf_settings, $key, itOr($sysconf_settings, $key, $value['default']))) . '" class="openPopUp notAJAX"><strong>' . basename(itOr($sysconf_settings, $key, $value['default'])) . '</strong></a></div>';
    $str_input .= simbio_form_element::textField('file', $key);
    $str_input .= ' Maximum ' . $sysconf['max_image_upload'] . ' KB';
    $form->addAnything($key, $str_input);
  } elseif ($value['type'] == 'select') {
    $options = null;
    foreach ($value['options'] as $option) {
      $options[$option] = array($option, $option);
    }
    $form->addSelectList($key, $key, $options, itOr($sysconf_settings, $key, $value['default']), 'style="width: 240px"');
  } elseif ($value['type'] == 'array') {
    $str_array = implode(';', (array)itOr($sysconf_settings, $key, $value['default']));
    $form->addTextField('textarea', $key, $key, $str_array, 'style="width: 100%; height: auto;"rows="5"', 'Setiap item pisahkan dengan titik koma ( ; )');
    $form->addHidden('array[]', $key);
  } elseif ($value['type'] == 'key') {
    $options = null;
    $keys = ['member_name', 'member_id', 'member_image', 'member_address', 'member_email', 'inst_name', 'postal_code', 'pin', 'member_phone', 'expire_date', 'register_date', 'birth_date', 'member_type_name'];
    foreach ($keys as $option) {
      $options[$option] = array($option, $option);
    }
    $form->addSelectList($key, $key, $options, itOr($sysconf_settings, $key, $value['default']), 'style="width: 240px"');
  } elseif ($value['type'] = 'date') {
    $form->addDateField(str_replace('.', '_', $key), $key, itOr($sysconf_settings, $key, $value['default']));
  }
}

echo $form->printOut();
