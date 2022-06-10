<?php
/**
 * @maintener Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2020-08-21 23:57:56
 * @modify date 2020-08-21 23:57:56
 * @desc main template based tailwind and slims css core
 */

//  Include template
include SB.'admin/admin_template/360/func.inc.php';

// load menu
if (isset($_GET['loadMenu']))
{
    loadSubmenu($_GET['loadMenu']);
    exit;
}

// load chart in json
if (isset($_GET['chart']))
{   
    header('Content-type: application/json');
    echo json_encode(chart($_GET['chart']));
    exit;
}
?>
<!-- 
 _____  __    ___  _ 
|___ / / /_  / _ \( )
  |_ \| '_ \| | | |/ 
 ___) | (_) | |_| |  
|____/ \___/ \___/   
                  template design by Drajat Hasan (drajathasan20@gmail.com)
 -->
<!DOCTYPE html>
<html>
    <head>
        <title><?=$page_title?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0" />
        <meta http-equiv="Expires" content="Sat, 26 Jul 1997 05:00:00 GMT" />
    
        <link rel="icon" href="<?=SWB;?>webicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?=SWB;?>webicon.ico" type="image/x-icon" />
        
        <!-- Css -->
        <link href="<?=AWB?>admin_template/360/other_css/bootstrap.min.css?<?php echo date('this') ?>" rel="stylesheet" type="text/css" />
        <link href="<?=AWB?>admin_template/360/assets/css/tailwind.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=AWB?>admin_template/360/assets/css/customs.css?<?=date('this')?>" rel="stylesheet" type="text/css" />
        <link href="<?=AWB?>admin_template/360/other_css/core.css?<?=date('this')?>" rel="stylesheet" type="text/css" />
        <link href="<?=AWB?>admin_template/360/css/customs.css?<?=date('this')?>" rel="stylesheet" type="text/css" />
        <link href="<?=JWB?>colorbox/colorbox.css?<?=date('this')?>" rel="stylesheet" type="text/css" />
        <link href="<?=JWB?>chosen/chosen.css?<?=date('this')?>" rel="stylesheet" type="text/css" />
        <link href="<?=JWB?>jquery.imgareaselect/css/imgareaselect-default.css" rel="stylesheet" type="text/css" />
        <link href="<?=AWB?>admin_template/360/style.css" rel="stylesheet" type="text/css" />
        <!-- Only SLiMS Bulian -->
        <?php if (preg_replace('/[^0-9]/i', '', SENAYAN_VERSION) == 9):?>
        <link href="<?=JWB?>toastr/toastr.min.css?<?=date('this')?>" rel="stylesheet" type="text/css" />
        <?php endif;?>
        
        <!-- Javascript -->
        <script type="text/javascript" src="<?=JWB?>jquery.js"></script>
        <script type="text/javascript" src="<?=AWB?>admin_template/<?=$sysconf['admin_template']['theme']?>/vendor/slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="<?=JWB?>updater.js"></script>
        <script type="text/javascript" src="<?=JWB?>gui.js"></script>
        <script type="text/javascript" src="<?=JWB?>form.js"></script>
        <script type="text/javascript" src="<?=JWB?>calendar.js?v=<?=date('this')?>"></script>
        <script type="text/javascript" src="<?=JWB?>chosen/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="<?=JWB?>chosen/ajax-chosen.min.js"></script>
        <script type="text/javascript" src="<?=JWB?>ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?=JWB?>tooltipsy.js"></script>
        <script type="text/javascript" src="<?=JWB?>colorbox/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="<?=JWB?>jquery.imgareaselect/scripts/jquery.imgareaselect.pack.js"></script>
        <script type="text/javascript" src="<?=JWB?>webcam.js"></script>
        <script type="text/javascript" src="<?=JWB?>scanner.js"></script>
        <!-- Only SLiMS Bulian -->
        <?php if (preg_replace('/[^0-9]/i', '', SENAYAN_VERSION) == 9):?>
        <script type="text/javascript" src="<?php echo JWB; ?>toastr/toastr.min.js"></script>
        <?php endif;?>
    </head>
    <body>

        <!-- Header -->
        <header class="w-full block fixed bg-white z-10">
            <div class="flex flex-row">
                <div class="text-gray-700 text-left w-5/12">
                    <div class="w-full block py-2 pl-4">
                        <!-- Menu Icon -->
                        <svg class="open-menu w-6 p-1 inline-block cursor-pointer hover:bg-gray-200" style="margin-top: -4px;" version="1.1" viewBox="0 0 42 42" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"> <metadata> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/> <dc:title/> </cc:Work> </rdf:RDF> </metadata> <g transform="matrix(1.0093 0 0 .983 -48.302 -43.03)" fill="#2c3e50"> <rect x="48.908" y="44.85" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="63.725" y="44.85" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="78.541" y="44.85" width="10" height="10" style="paint-order:stroke markers fill"/> <g transform="translate(0 -5.8208)"> <rect x="48.908" y="66.017" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="63.725" y="66.017" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="78.541" y="66.017" width="10" height="10" style="paint-order:stroke markers fill"/> </g> <g transform="translate(0 -12.171)"> <rect x="48.908" y="87.713" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="63.725" y="87.713" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="78.541" y="87.713" width="10" height="10" style="paint-order:stroke markers fill"/> </g> </g> </svg>
                        <!-- Library Name -->
                        <span class="text-lg font-semibold text-gray-700 ml-2 inline-block"><?=$sysconf['library_name'];?></span>
                    </div>
                </div>
                <!-- Spacer? -->
                <div class="text-gray-700 text-center w-4/12"></div>
                <!-- Right Content -->
                <div class="text-gray-700 text-center w-3/12">
                    <!-- User pict -->
                    <img class="py-2 mr-4 ml-2 float-right h-12 w-12 userpict cursor-pointer" src="<?=SWB?>images/persons/<?=$_SESSION['upict']?>" />
                    <div class="w-48 h-30 profile-menu hidden absolute bg-gray-100 right-0 mt-10 mr-2 shadow-2xl text-left p-2">
                        <span class="profile font-bold w-full block hover:bg-gray-300 p-2 cursor-pointer hover:rounded-full">
                            <svg class="inline-block w-15 h-5 mr-1" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M13 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM3.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            <?=ucfirst($_SESSION['uname'])?>
                        </span>
                        <span onclick="window.location.href = 'logout.php';" class="font-bold w-full block hover:bg-gray-300 p-2 cursor-pointer hover:rounded-full">
                            <svg class="inline-block w-15 h-5 mr-1" viewBox="0 0 16 16" class="bi bi-arrow-right-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1 0-.708L10.293 8 7.646 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                                <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                            Logout
                        </span>
                    </div>
                    <!-- Ask Question -->
                    <svg class="ask w-5 py-2 mx-2 mt-1 float-right cursor-pointer hover:bg-gray-200" viewBox="0 0 16 16" class="bi bi-question-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M5.25 6.033h1.32c0-.781.458-1.384 1.36-1.384.685 0 1.313.343 1.313 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.007.463h1.307v-.355c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.326 0-2.786.647-2.754 2.533zm1.562 5.516c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg>
                    <!-- Alert -->
                    <svg class="open-alert w-5 py-2 mx-2 mt-1 float-right cursor-pointer hover:bg-gray-200" viewBox="0 0 16 16" class="bi bi-bell" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
                        <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                    </svg>
                    <span class="open-alert cursor-pointer float-right <?=(count(setWarning(0)) == 0)?'bg-gray-600':'bg-red-600'?> font-bold text-white h-5 w-5 -mr-10 mt-3 rounded-full"><?=count(setWarning(0))?></span>
                </div>
            </div>
        </header>
        
        <!-- Alert content -->
        <div class="right-alert hidden bg-white block w-3/12 absolute mt-10 top-0 right-0 mr-24 h-auto z-10 shadow-2xl">
            <div class="flex flex-col p-2">
                <p class="font-bold">Notifikasi Sistem</p>
                <?php
                $systemalert = '';
                if (count(setWarning(0)) > 0):
                    foreach (setWarning(0) as $key => $value):
                        if ($key > 0):
                            $systemalert .= '<div class="bg-red-100 border-l-4 border-red-500 my-1 text-red-700 p-2" role="alert">';
                            $systemalert .= '<span>'.$value.'</span>';
                            $systemalert .= '</div>';
                        endif;
                    endforeach;
                else:
                    $systemalert .= '<div class="my-1 text-blue-700 p-2 w-full text-center" role="alert">';
                    $systemalert .= '<span>Tidak ada</span>';
                    $systemalert .= '</div>';
                endif;
                // set alert
                echo $systemalert;
                ?>
            </div>
        </div>

        <!-- Ask -->
        <div class="right-ask hidden bg-white block w-3/12 absolute mt-10 top-0 right-0 mr-0 h-full z-10 shadow-2xl">
            <div class="ask-content flex flex-col p-2 h-full overflow-auto px-3">

            </div>
        </div>

        <!-- left menu absolute -->
        <div class="left-menu hidden block w-3/12 absolute top-0 left-0 bg-white h-screen z-20 shadow-2xl">
            <div class="flex flex-row">
                <div class="text-gray-700 text-left w-full">
                    <div class="w-full block py-2 pl-4">
                        <!-- Menu icon -->
                        <svg class="open-menu w-6 p-1 inline-block cursor-pointer hover:bg-gray-200" style="margin-top: -4px;" version="1.1" viewBox="0 0 42 42" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"> <metadata> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"/> <dc:title/> </cc:Work> </rdf:RDF> </metadata> <g transform="matrix(1.0093 0 0 .983 -48.302 -43.03)" fill="#2c3e50"> <rect x="48.908" y="44.85" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="63.725" y="44.85" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="78.541" y="44.85" width="10" height="10" style="paint-order:stroke markers fill"/> <g transform="translate(0 -5.8208)"> <rect x="48.908" y="66.017" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="63.725" y="66.017" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="78.541" y="66.017" width="10" height="10" style="paint-order:stroke markers fill"/> </g> <g transform="translate(0 -12.171)"> <rect x="48.908" y="87.713" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="63.725" y="87.713" width="10" height="10" style="paint-order:stroke markers fill"/> <rect x="78.541" y="87.713" width="10" height="10" style="paint-order:stroke markers fill"/> </g> </g> </svg>
                        <!-- Library name -->
                        <span class="text-lg font-semibold text-gray-700 ml-2 inline-block"><?=$sysconf['library_name'];?></span>
                    </div>
                </div>
            </div>
            <div class="block w-full px-2 py-2 mt-2 bg-white mx-auto">
                <div class="w-full block">
                    <h1 class="text-lg font-semibold text-gray-800"><?=__('Menu')?></h1>
                </div>
                <div class="flex flex-col">
                    <!-- Dashboard -->
                    <div class="text-gray-700 text-left px-4 py-2 mx-2 my-1 cursor-pointer hover:shadow-2xl hover:bg-gray-300" onclick="location.reload()">
                        <svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" width="90mm" height="90mm" viewBox="0 0 90 90" version="1.1" id="svg1469" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" sodipodi:docname="dasboard_web.svg"> <defs id="defs1463" /> <sodipodi:namedview id="base" pagecolor="#ffffff" bordercolor="#666666" borderopacity="1.0" inkscape:pageopacity="0.0" inkscape:pageshadow="2" inkscape:zoom="0.78199074" inkscape:cx="119.33385" inkscape:cy="151.23785" inkscape:document-units="mm" inkscape:current-layer="layer1" inkscape:document-rotation="0" showgrid="false" inkscape:window-width="1366" inkscape:window-height="695" inkscape:window-x="0" inkscape:window-y="25" inkscape:window-maximized="1" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g inkscape:label="Lapis 1" inkscape:groupmode="layer" id="layer1"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1701" cx="42.940338" cy="44.5" r="44.5" /> <g transform="matrix(1.0958328,0,0,1.0958328,-7.7605197,-2.1242657)" id="g895"> <path id="rect869" style="fill:#ddeef8;fill-opacity:1;stroke:#505050;stroke-width:1.42218;stroke-linecap:round;stroke-linejoin:round;stroke-opacity:1;paint-order:stroke markers fill" d="M 46.161905,21.909039 27.756939,40.368712 h -0.08743 v 0.08796 l -0.0863,0.08656 0.0863,-4.72e-4 V 64.95934 H 64.916047 V 40.368712 Z" /> <rect y="19.728247" x="55.04641" height="14.152524" width="4.6315546" id="rect886" style="fill:#d35400;fill-opacity:1;stroke:#505050;stroke-width:0.609837;stroke-linecap:round;stroke-linejoin:round;stroke-opacity:1;paint-order:stroke markers fill" /> <path id="rect871" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:1.44949;stroke-linecap:round;stroke-linejoin:round;stroke-opacity:1;paint-order:stroke markers fill" d="M 22.787711,41.206937 46.156439,20.850705 69.74622,41.016196 46.266965,41.111567 Z" sodipodi:nodetypes="ccccc" /> <rect style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:0.793535;stroke-linecap:round;stroke-linejoin:round;stroke-opacity:1;paint-order:stroke markers fill" id="rect874" width="7.8420811" height="14.152524" x="42.328636" y="50.949081" /> <rect y="41.761353" x="50.652843" height="23.197985" width="14.263207" id="rect888" style="fill:#cfcfcf;fill-opacity:1;stroke:none;stroke-width:1.37015;stroke-linecap:round;stroke-linejoin:round;stroke-opacity:1;paint-order:stroke markers fill" /> </g> </g> </svg><span class="font-bold inline-block text-center text-md">Dashboard </span>';
                    </div>
                    <!-- Left Menu -->
                    <?=moduleLeftList()?>
                </div>
            </div>
        </div>

        <!-- Content Module -->
        <div class="dashboard w-full block bg-white h-screen p-5 mb-16">
            <!-- Module List -->
            <div class="block w-full px-5 py-2 mt-10 bg-white mx-auto">
                <!-- Greeter -->
                <div class="w-full block">
                    <h1 class="text-2xl font-semibold text-gray-800"><?=setGreater()?></h1>
                </div>
                <!-- Set repair -->
                <div class="w-full block">
                    <?=setRepair()?>                            
                </div>
                <!-- Set module list -->
                <?=moduleList()?>
            </div>
            <!-- Summary -->
            <div class="block w-full px-5 py-2 mt-2 bg-white mx-auto mb-20">
                <div class="w-full block">
                    <h1 class="text-2xl font-semibold text-gray-800">Ringkasan</h1>
                </div>
                <!-- Info -->
                <?php
                    $info = '';
                    foreach (setInfo() as $value):
                        $info .= '<div class="mt-2 flex items-center bg-teal-500 text-white text-md font-bold px-4 py-3" role="alert">';
                        $info .= '<svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>';
                        $info .= '<p>'.$value.'</p>';
                        $info .= '</div>';
                    endforeach;
                    // set out
                    echo $info;
                ?>
                <!-- Tab -->
                <div class="flex flex-row">
                    <div class="text-gray-700 text-center py-2 m-2 summary font-semibold text-medium border-bottom-blue">Statistik</div>
                    <div class="text-gray-700 text-center py-2 m-2 summary">Aktivitas</div>
                </div>
                <!-- Statistic -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Counter -->
                    <div class="col-span-1">
                        <div class="grid grid-cols-2 gap-0">
                            <div class="col-span-1 p-3">
                                <svg class="w-20 h-20 inline-block" version="1.1" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg"><circle cx="44.5" cy="44.5" r="44.5" fill="#eee" style="paint-order:stroke markers fill"/><g transform="translate(-1.6777 -9.1612)"><g transform="translate(1.5875 -15.346)"><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round"><path d="m21.816 61.96v10.084h45.87v-0.15038a2.6721 4.3824 0 0 1-1.5963-3.9903 2.6721 4.3824 0 0 1 1.5963-4.0325v-1.9107z" fill="#fff" stroke-width="2.5152" style="paint-order:stroke markers fill"/><rect x="21.297" y="61.582" width="1.9545" height="10.464" fill="#f1c40f" stroke-width="1.21" style="paint-order:stroke markers fill"/><rect transform="rotate(-90)" x="-63.22" y="21.63" width="1.297" height="46.349" fill="#00efff" stroke-width="2.0744" style="paint-order:stroke markers fill"/></g><g fill="#bdc3c7"><rect x="24.463" y="68.424" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="24.463" y="64.191" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="24.463" y="70.541" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="24.463" y="66.837" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="24.463" y="64.72" width="40.438" height=".27196" style="paint-order:stroke markers fill"/></g></g><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round"><path d="m18.775 34.201v10.084h45.87v-0.15038a2.6721 4.3824 0 0 1-1.5963-3.9903 2.6721 4.3824 0 0 1 1.5963-4.0325v-1.9107z" fill="#fff" stroke-width="2.5152" style="paint-order:stroke markers fill"/><rect x="18.256" y="33.827" width="1.9545" height="10.46" fill="#2980b9" stroke-width="1.2097" style="paint-order:stroke markers fill"/><rect transform="rotate(-90)" x="-35.46" y="18.589" width="1.297" height="46.349" fill="#96d5ff" stroke-width="2.0744" style="paint-order:stroke markers fill"/></g><g fill="#bdc3c7"><rect x="21.422" y="35.373" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="21.422" y="40.665" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="21.422" y="39.607" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="21.422" y="34.315" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="21.422" y="42.782" width="40.438" height=".27196" style="paint-order:stroke markers fill"/></g><g transform="translate(10.583)"><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round"><path d="m17.054 59.315v10.084h45.87v-0.15038a2.6721 4.3824 0 0 1-1.5963-3.9903 2.6721 4.3824 0 0 1 1.5963-4.0325v-1.9107z" fill="#fff" stroke-width="2.5152" style="paint-order:stroke markers fill"/><rect x="16.534" y="58.937" width="1.9545" height="10.464" fill="#bdc3c7" stroke-width="1.21" style="paint-order:stroke markers fill"/><rect transform="rotate(-90)" x="-60.574" y="16.868" width="1.297" height="46.349" fill="#bbff90" stroke-width="2.0744" style="paint-order:stroke markers fill"/></g><g fill="#bdc3c7"><rect x="19.7" y="65.778" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="19.7" y="61.545" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="19.7" y="67.895" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="19.7" y="64.191" width="40.438" height=".27196" style="paint-order:stroke markers fill"/><rect x="19.7" y="62.074" width="40.438" height=".27196" style="paint-order:stroke markers fill"/></g></g><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7318"><path d="m26.05 49.646v11.167h0.40284l2.0812-1.8497 2.1849 1.8497h0.38969v-11.167z" fill="#1abc9c" style="paint-order:stroke markers fill"/><path d="m22.095 37.91v11.167h0.40284l2.0812-1.8497 2.1849 1.8497h0.38969v-11.167z" fill="#f39c12" style="paint-order:stroke markers fill"/><path d="m30.284 62.346v11.167h0.40284l2.0812-1.8497 2.1849 1.8497h0.38969v-11.167z" fill="#3498db" style="paint-order:stroke markers fill"/></g></g></svg>
                                <h1 class="absolute inline-block text-xl ml-2 font-semibold text-gray-800"><?=__('Total of Collections')?></h1>
                                <span class="text-base font-bold text-lg ml-2 text-gray-900 count" data-src="0">0</span>
                                <span class="rounded-full bg-indigo-500 text-white px-2 py-1 text-xs font-semibold ml-1"><?=__('Title')?></span>
                            </div>
                            <div class="col-span-1 p-3">
                                <svg class="w-20 h-20 inline-block" version="1.1" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg"><g><circle cx="44.5" cy="44.5" r="44.5" fill="#eee" style="paint-order:stroke markers fill"/><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round"><rect x="26.548" y="20.644" width="35.905" height="47.713" fill="#fff" stroke-width="3" style="paint-order:stroke markers fill"/><rect x="52.913" y="20.644" width="9.5391" height="9.5391" fill="#ecf0f1" stroke-width="1.5" style="paint-order:stroke markers fill"/><rect x="52.913" y="20.644" width="9.5391" height="9.5391" fill="#a3eafc" stroke-width="1.5" style="paint-order:stroke markers fill"/></g><path d="m52.913 20.644 9.5391 9.5391h-9.5391z" fill="#ecf0f1" stroke="#5d5b5b" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" style="paint-order:stroke markers fill"/><g fill="#5c5f60"><rect x="30.472" y="27.176" width="18.003" height="1.3604" style="paint-order:stroke markers fill"/><rect x="30.472" y="35.114" width="18.003" height="1.3604" style="paint-order:stroke markers fill"/><rect x="30.472" y="37.759" width="18.003" height="1.3604" style="paint-order:stroke markers fill"/></g><rect x="30.472" y="40.405" width="18.003" height="1.3604" fill="#505050" style="paint-order:stroke markers fill"/><circle cx="52.178" cy="57.642" r="6" fill="#fff" style="paint-order:stroke markers fill"/><text x="49.380589" y="60.556896" fill="#505050" font-family="sans-serif" font-size="7.7611px" letter-spacing="0px" stroke-width=".26458" word-spacing="0px" style="line-height:1.25" xml:space="preserve"><tspan x="49.380589" y="60.556896" fill="#505050" font-family="Cantarell" stroke-width=".26458">C1</tspan></text><rect x="30.472" y="44.109" width="18.003" height="1.3604" fill="#5c5f60" style="paint-order:stroke markers fill"/><rect x="30.472" y="46.755" width="18.003" height="1.3604" fill="#5c5f60" style="paint-order:stroke markers fill"/><rect x="30.472" y="49.401" width="18.003" height="1.3604" fill="#505050" style="paint-order:stroke markers fill"/><rect x="26.548" y="66.223" width="35.905" height="2.133" fill="#81e9ff" style="paint-order:stroke markers fill"/></g></svg>
                                <h1 class="absolute inline-block text-xl ml-2 font-semibold text-gray-800"><?=__('Total of Items')?></h1>
                                <span class="text-base font-bold text-lg ml-2 text-gray-900 count" data-src="1">0</span>
                                <span class="rounded-full bg-pink-700 text-white px-2 py-1 text-xs font-semibold ml-1"><?=__('eks')?></span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-0">
                            <div class="col-span-1 p-3">
                                <svg class="w-20 h-20 inline-block" version="1.1" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg"><g><circle cx="44.5" cy="44.5" r="44.5" fill="#eee" style="paint-order:stroke markers fill"/><rect x="27.314" y="21.662" width="34.373" height="45.677" fill="#fff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" style="paint-order:stroke markers fill"/><rect x="27.314" y="62.852" width="34.373" height="4.4863" fill="#676767" style="paint-order:stroke markers fill"/><rect x="27.314" y="63.396" width="34.373" height="3.9424" fill="#b5f0ff" style="paint-order:stroke markers fill"/></g><g transform="matrix(.88533 0 0 .88533 4.7705 5.4127)"><g transform="matrix(1.4499 0 0 1.4499 -19.849 -18.17)"><g><circle transform="rotate(90)" cx="41.084" cy="-45.663" r="6.5" fill="#e8fbf7" stroke="#505050" stroke-linejoin="round" stroke-width="1.389" style="paint-order:stroke markers fill"/><circle transform="rotate(54.092)" cx="59.993" cy="-12.693" r="6.5" fill="#fff" stroke="#505050" stroke-linejoin="round" stroke-width="1.389" style="paint-order:stroke markers fill"/><path d="m46.928 44.627h3.2822c0.13566 0 0.24216 0.10924 0.24488 0.24488l0.02889 1.4419c0.04207 0.4517-2.2548 1.6689-3.556 1.8968l-0.24488-0.24488v-3.0938c0-0.13566 0.10922-0.24488 0.24488-0.24488z" fill="#fff" style="paint-order:stroke markers fill"/></g><g transform="rotate(-14.767 78.392 33.95)" fill="#505050" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width=".1"><rect x="47.991" y="34.829" width=".67147" height="4.0232" ry=".33574" style="paint-order:stroke markers fill"/><rect transform="rotate(90)" x="38.181" y="-52.014" width=".67147" height="4.0232" ry=".33574" style="paint-order:stroke markers fill"/></g><path d="m42.08 43.928 3.5182-2.6675 0.07849-3.9518" fill="none" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width=".33996"/></g><text x="48.672585" y="54.418537" fill="#505050" font-family="sans-serif" font-size="7.7611px" letter-spacing="0px" stroke-width=".26458" word-spacing="0px" style="line-height:1.25" xml:space="preserve"><tspan x="48.672585" y="54.418537" fill="#505050" font-family="Cantarell" stroke-width=".26458">?</tspan></text></g><g transform="translate(.27949 1.0606)"><rect x="28.989" y="20.572" width="2.3144" height="45.839" fill="#2980b9" style="paint-order:stroke markers fill"/><rect x="27.93" y="20.572" width="2.3144" height="45.839" fill="#81e9ff" style="paint-order:stroke markers fill"/></g></svg>
                                <h1 class="absolute inline-block text-xl ml-2 font-semibold text-gray-800"><?=__('Lent')?></h1>
                                <span class="text-base font-bold text-lg ml-2 text-gray-900 count" data-src="2">0</span>
                                <span class="rounded-full bg-teal-700 text-white px-2 py-1 text-xs font-semibold ml-1"><?=__('eks')?></span>
                            </div>
                            <div class="col-span-1 p-3">
                                <svg class="w-20 h-20 inline-block" version="1.1" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg"><circle cx="44.5" cy="44.5" r="44.5" fill="#eee" style="paint-order:stroke markers fill"/><g transform="translate(-.97483)"><rect x="27.314" y="21.662" width="34.373" height="45.677" fill="#fff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" style="paint-order:stroke markers fill"/><g transform="matrix(0 1 -.74845 0 77.019 36.035)"><rect x="28.989" y="20.572" width="2.3144" height="45.839" fill="#2980b9" style="paint-order:stroke markers fill"/><rect x="27.93" y="20.572" width="2.3144" height="45.839" fill="#81e9ff" style="paint-order:stroke markers fill"/></g><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round"><path d="m64.044 41.568h-14.088v0.50822l2.3336 2.6256-2.3336 2.7564v0.49162h14.088z" fill="#f39c12" stroke-width="2.1848" style="paint-order:stroke markers fill"/><text transform="matrix(2.8446 0 0 3.2427 -73.765 -75.325)" fill="#505050" font-family="sans-serif" font-size="7.7611px" letter-spacing="0px" stroke-width=".32926" word-spacing="0px" style="line-height:1.25;shape-inside:url(#rect3632);white-space:pre" xml:space="preserve"><tspan x="37.246094" y="39.653168"><tspan fill="#505050" font-family="Cantarell" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width=".32926">A</tspan></tspan></text><ellipse cx="49.855" cy="44.802" rx="3.496" ry="3.496" fill="#f1c40f" stroke-width="2" style="paint-order:stroke markers fill"/></g></g></svg>
                                <h1 class="absolute inline-block text-xl ml-2 font-semibold text-gray-800"><?=__('Available')?></h1>
                                <span class="text-base font-bold text-lg ml-2 text-gray-900 count" data-src="3">0</span>
                                <span class="rounded-full bg-green-700 text-white px-2 py-1 text-xs font-semibold ml-1"><?=__('eks')?></span>
                            </div>
                        </div>
                    </div>
                    <!-- Chart -->
                    <div class="flex">
                        <div class="flex-initial c1 w-8/12 text-gray-700 text-center px-4 py-2 m-2" id="chart-c1">
                            
                        </div>
                        <div class="flex-initial c2 w-4/12 text-gray-700 text-center px-4 py-2 m-2" id="chart-c2">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MainContent -->
        <div class="flex flex-row" id="content">
            <div class="w-2/12">
                <div class="fixed mt-12 h-full w-2/12 z-10" style="background: #4a5568">
                   <div id="sidpan" class="h-64 text-white overflow-auto">
                       <div id="submenu" class="submenu pt-2">

                       </div>
                   </div>
                </div>
            </div>
            <div class="w-10/12">
                <div class="loader"></div>
                <div id="mainContent" class="w-full block bg-white h-auto py-5 hidden">
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="w-full block fixed bottom-0 bg-white mb-0 z-0 py-2">
            <div class="flex flex-row">
                <div class="text-gray-700 text-right w-full block pr-5">
                    <span class="font-bold text-right block text-md "><?=$sysconf['library_name'].' | '.$sysconf['library_subname']?></span>
                </div>
            </div>
        </div>

        <!-- Set fake iframe -->
        <iframe name="blindSubmit" class="hidden"></iframe>
        <!-- Chart -->
        <link href="<?=AWB?>admin_template/360/node_modules/tui-chart/dist/tui-chart.min.css" rel="stylesheet"></link>
        <script src="<?=AWB?>admin_template/360/node_modules/tui-chart/dist/tui-chart-all.min.js" type="text/javascript"></script>
        <!-- Load ui -->
        <script>
            let awb = '<?=AWB?>';
            let barchart = [<?="'".__('Latest Transactions')."', '".__('Loan')."', '".__('Return')."', '".__('Extend')."'"?>];
            let doughchart = [<?="'".__('Summary')."', '".__('Total')."', '".__('Loan')."', '".__('Return')."', '".__('Extend')."', '".__('Overdue')."'"?>];
        </script>
        <script src="<?=AWB?>admin_template/360/assets/js/ui.js?<?=date('this')?>"></script>
    </body>
</html>
