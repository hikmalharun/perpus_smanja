<?php
/**
 * @maintener Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2020-08-18 21:08:13
 * @modify date 2020-08-21 23:57:32
 * @desc Function 360
 */

// set index auth
if (!defined('INDEX_AUTH'))
{
    die('No direct access!');
}

// Module path
function modulePath($module)
{
    global $dbs;

    $mod_q = $dbs->query('SELECT module_path FROM mst_module WHERE module_name ="'.$dbs->escape_string($module).'"');

    if ($mod_q->num_rows == 1)
    {
        $mod_d = $mod_q->fetch_row();
        return $mod_d[0];
    }

    return '-';
}

// get module data
function getModule()
{
    global $dbs;

    $mod_q = $dbs->query('SELECT module_path, module_name FROM mst_module');
    $mod_data = [];
    if ($mod_q->num_rows > 0)
    {
        while($mod_d = $mod_q->fetch_row())
        {
            $mod_data[] = $mod_d;
        }
    }

    return $mod_data;
}

// set module list
function moduleList()
{
    // define icon
    $module_icon = [
        'bibliography' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1"> <g id="g1174" transform="translate(106.46753,128.49679)"> <g transform="matrix(1.2714286,0,0,1.2714286,-120.88742,-140.01499)" id="g907"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.583359;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle895" cx="46.341488" cy="44.059261" r="35" /> <g id="g905" transform="translate(2.737582,-2.1401071)"> <rect style="fill:#3498db;stroke:#505050;stroke-width:1.71834;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect897" width="29.254547" height="37.815216" x="30.942619" y="27.134706" /> <rect y="28.161148" x="30.926674" height="36.804504" width="28.162392" id="rect899" style="fill:#ecf0f1;stroke:#505050;stroke-width:1.66329;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect y="27.134617" x="27.010555" height="38.145092" width="28.995415" id="rect901" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:1.71816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path d="m 30.926704,27.119118 v 11.08032 h 0.399725 l 2.065052,-1.835416 2.167962,1.835416 h 0.386668 v -11.08032 z" style="fill:#ecf0f1;stroke:#505050;stroke-width:1.71834;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path903" /> </g> </g> </g> </g> </svg>',
        'circulation' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="circulation_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1185" transform="translate(0.18314067,129.50548)"> <g id="g962" transform="translate(-0.71230785,-130.03465)"> <circle r="44.5" cy="45.029167" cx="45.029167" id="path861" style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <g transform="matrix(0.82613357,0,0,0.80992807,6.6088374,9.8078435)" id="g952"> <rect style="fill:#2ecc71;fill-opacity:1;stroke:#505050;stroke-width:3;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect915" width="63.603176" height="61.420513" x="14.704608" y="12.776721" ry="4.7307506" /> <g id="g944" transform="matrix(0.863902,0,0,0.85945422,6.2086824,6.099837)"> <path d="m 27.621669,29.502204 -6.688728,7.50794 4.298743,-0.05985 v 20.020304 h 4.329284 V 36.889691 l 4.697947,-0.06544 z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:2.78906;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect923" /> <path id="path928" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:2.78906;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 65.721672,57.499844 -6.688728,-7.50794 4.298743,0.05985 v -20.0203 h 4.329284 v 20.080903 l 4.697947,0.06544 z" /> <path id="path930" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:3.02138;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 62.763539,23.683013 -8.810832,-6.688728 0.07024,4.298743 H 30.528415 v 4.329284 h 23.565648 l 0.07679,4.697947 z" /> <path d="m 29.999151,63.370517 8.810832,-6.688728 -0.07024,4.298743 h 23.494532 v 4.329284 H 38.668627 l -0.07679,4.697947 z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:3.02138;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path932" /> </g> </g> </g> </g> </g> </svg>',
        'membership' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="membership_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1196" transform="translate(-102.73074,122.68412)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1056" cx="147.23074" cy="-78.18412" r="44.5" /> <g transform="translate(97.224381,-120.36928)" id="g1072"> <g id="g1064"> <ellipse ry="5.5320091" rx="5.532011" cy="25.856213" cx="59.352348" id="ellipse1058" style="fill:#2ecc71;fill-opacity:1;stroke:#505050;stroke-width:3.93598;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path sodipodi:nodetypes="cccc" d="M 58.850186,36.76772 76.690708,54.304511 C 63.643093,70.950737 46.154262,61.325033 41.313396,54.608241 Z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:4.98354;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1060" /> <path id="path1062" style="fill:#2980b9;fill-opacity:1;stroke:none;stroke-width:1.14713;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 58.850186,36.76772 3.295668,5.029989 -3.23956,5.117109 -3.295668,-5.02999 z" /> </g> <ellipse ry="5.5320091" rx="5.532011" cy="25.856213" cx="41.360695" id="ellipse1066" style="fill:#7f8c8d;fill-opacity:1;stroke:#505050;stroke-width:3.93598;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path sodipodi:nodetypes="cccc" d="m 40.858534,36.76772 17.840522,17.536791 -35.377311,0.30373 z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:4.98354;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1068" /> <path id="path1070" style="fill:#16a085;fill-opacity:1;stroke:none;stroke-width:1.14713;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 40.858534,36.76772 3.295668,5.029989 -3.23956,5.117109 -3.295667,-5.02999 z" /> </g> </g> </g> </svg>',
        'master_file' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="masterfile_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1216" transform="translate(-205.71654,129.46401)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1188" cx="250.21654" cy="-84.964012" r="44.5" /> <g transform="matrix(0.8137019,0,0,0.8137019,213.41493,-119.95353)" id="g1222"> <rect y="12.967948" x="26.920876" height="55.302444" width="41.904682" id="rect1190" style="fill:#a0d9ff;fill-opacity:1;stroke:#505050;stroke-width:5.40838;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <g id="g1220"> <rect y="25.099907" x="32.306278" height="0.93088984" width="33.146427" id="rect1192" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1194" width="33.146427" height="0.93088984" x="32.306278" y="30.391573" /> <rect y="36.212406" x="32.306278" height="0.93088984" width="33.146427" id="rect1196" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1198" width="33.146427" height="0.93088984" x="32.306278" y="41.504074" /> <rect y="46.795742" x="32.306278" height="0.93088984" width="33.146427" id="rect1200" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1202" width="33.146427" height="0.93088984" x="32.306278" y="52.616577" /> <g transform="translate(1.0583333,-0.52916667)" id="g1218"> <rect style="fill:#fbfbfb;fill-opacity:1;stroke:#505050;stroke-width:5.40838;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1204" width="41.904682" height="55.302444" x="20.570877" y="18.259615" /> <rect y="30.92074" x="24.897945" height="0.93088984" width="33.146427" id="rect1206" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1208" width="33.146427" height="0.93088984" x="24.897945" y="36.212406" /> <rect y="42.033241" x="24.897945" height="0.93088984" width="33.146427" id="rect1210" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1212" width="33.146427" height="0.93088984" x="24.897945" y="47.324909" /> <rect y="52.616577" x="24.897945" height="0.93088984" width="33.146427" id="rect1214" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1216" width="33.146427" height="0.93088984" x="24.897945" y="58.437412" /> </g> </g> </g> </g> </g> </svg>',
        'stock_take' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="stocktake.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1233" transform="translate(-310.27756,128.244)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1467" cx="354.77756" cy="-83.744003" r="44.5" /> <g transform="matrix(1.1048537,0,0,1.1926895,306.82624,-135.28149)" id="g1495"> <rect y="20.591423" x="54.623814" height="35.920689" width="6.7774096" id="rect1469" style="fill:#f1c40f;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect y="24.991159" x="38.571468" height="35.920689" width="6.7774096" id="rect1471" style="fill:#64edff;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#27ae60;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1473" width="6.7774096" height="35.920689" x="46.508976" y="23.932825" /> <rect y="23.846973" x="46.423122" height="36.594509" width="1.6522932" id="rect1475" style="fill:#1abc9c;fill-opacity:1;stroke:#505050;stroke-width:0.669427;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#57ebce;fill-opacity:1;stroke:#505050;stroke-width:0.669427;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1477" width="1.6522932" height="36.594509" x="38.485615" y="24.905308" /> <g id="g1483" transform="matrix(1.6091572,0,0,1.1336288,-23.012641,-8.361513)"> <rect y="24.991159" x="30.633961" height="35.920689" width="6.7774096" id="rect1479" style="fill:#ff6524;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#ffb624;fill-opacity:1;stroke:#505050;stroke-width:0.669427;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1481" width="1.6522932" height="36.594509" x="30.548107" y="24.905308" /> </g> <rect style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:1.80724;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1485" width="38.484158" height="31.685684" x="24.166206" y="34.625195" /> <rect style="fill:#d35400;fill-opacity:1;stroke:#505050;stroke-width:1.16575;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1487" width="1.1278092" height="13.156289" x="60.211086" y="20.653749" /> <rect y="34.625195" x="45.080639" height="31.685684" width="17.569723" id="rect1489" style="fill:#dcdcdc;fill-opacity:1;stroke:none;stroke-width:1.22112;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#1b8eff;fill-opacity:1;stroke:#505050;stroke-width:2.27118;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1491" width="44.190067" height="9.3513784" x="21.305571" y="34.798729" /> <rect style="fill:#ccd1d5;fill-opacity:1;stroke:none;stroke-width:1.91706;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1493" width="13.392535" height="11.290557" x="26.662313" y="52.423279" /> </g> </g> </g> </svg>',
        'system' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="system_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1244" transform="translate(-404.83862,119.50776)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1701" cx="449.33862" cy="-75.007759" r="44.5" /> <g transform="matrix(0.97432515,0,0,0.97432515,406.46847,-119.45502)" id="g1717"> <g id="g1715" transform="matrix(1.0204816,0,0,1.0204816,-0.83248189,0.60650808)"> <path d="m 55.667278,31.744057 v 4.787716 a 9.834351,10.038859 0 0 0 -5.387687,2.120705 l -3.279044,-3.438233 -1.240342,1.183061 3.279643,3.439439 a 9.834351,10.038859 0 0 0 -2.473453,5.74948 h -4.740679 v 1.714291 h 4.723193 a 9.834351,10.038859 0 0 0 1.946442,5.278549 l -3.427377,3.11322 1.15291,1.268685 3.40567,-3.093927 a 9.834351,10.038859 0 0 0 6.040724,2.69294 v 4.582099 h 1.714896 v -4.612249 a 9.834351,10.038859 0 0 0 5.346079,-2.338383 l 3.320048,3.481043 1.240946,-1.183662 -3.367681,-3.531092 a 9.834351,10.038859 0 0 0 2.240097,-5.657223 h 5.062073 v -1.714291 h -5.079559 a 9.834351,10.038859 0 0 0 -1.883734,-5.012028 l 3.720429,-3.37974 -1.152307,-1.269288 -3.690279,3.352003 a 9.834351,10.038859 0 0 0 -5.756112,-2.714647 v -4.818468 z" style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:3.50055;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1703" /> <ellipse ry="5.2658691" rx="5.2658701" cy="46.443069" cx="56.524727" id="ellipse1705" style="fill:#ecbdff;fill-opacity:1;stroke:#505050;stroke-width:3.50055;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path id="path1707" style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:2.5137;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 40.056605,17.33706 -1.111617,3.253326 a 7.0619212,7.208776 18.864581 0 0 -4.153403,0.190133 l -1.42987,-3.097662 -1.117515,0.515923 1.429997,3.098622 a 7.0619212,7.208776 18.864581 0 0 -3.015669,3.332573 l -3.221366,-1.100696 -0.398026,1.164887 3.209484,1.096636 a 7.0619212,7.208776 18.864581 0 0 0.09706,4.038782 l -3.051786,1.319709 0.488855,1.129775 3.032557,-1.31164 a 7.0619212,7.208776 18.864581 0 0 3.479515,3.232436 l -1.063876,3.113607 1.165299,0.398165 1.070875,-3.134093 a 7.0619212,7.208776 18.864581 0 0 4.175673,-0.34771 l 1.447791,3.136273 1.118066,-0.516191 -1.468539,-3.181344 a 7.0619212,7.208776 18.864581 0 0 2.835679,-3.324063 l 3.439757,1.175318 0.398026,-1.164887 -3.45164,-1.179377 a 7.0619212,7.208776 18.864581 0 0 -0.116323,-3.843118 l 3.312799,-1.432773 -0.488306,-1.130044 -3.285872,1.420926 a 7.0619212,7.208776 18.864581 0 0 -3.281078,-3.181104 l 1.118757,-3.274223 z" /> <ellipse transform="rotate(18.864581)" style="fill:#7f8c8d;fill-opacity:1;stroke:#505050;stroke-width:2.5137;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="ellipse1709" cx="43.992702" cy="14.096194" rx="3.7813537" ry="3.7813528" /> <path d="m 34.126266,45.519806 -1.268579,3.517335 a 7.769068,8.0847094 80.78347 0 0 -4.739875,0.205563 l -1.631771,-3.349039 -1.275311,0.557791 1.631915,3.350076 a 7.769068,8.0847094 80.78347 0 0 -3.44149,3.603013 l -3.67623,-1.190018 -0.454228,1.259419 3.662671,1.185628 a 7.769068,8.0847094 80.78347 0 0 0.110769,4.366531 l -3.482707,1.426804 0.557884,1.221457 3.46076,-1.41808 a 7.769068,8.0847094 80.78347 0 0 3.970834,3.49475 l -1.214099,3.366278 1.329841,0.430477 1.222087,-3.388428 a 7.769068,8.0847094 80.78347 0 0 4.765287,-0.375927 l 1.652224,3.390785 1.27594,-0.558081 -1.6759,-3.43951 a 7.769068,8.0847094 80.78347 0 0 3.236084,-3.593813 l 3.92546,1.270695 0.454228,-1.259418 -3.939021,-1.275085 A 7.769068,8.0847094 80.78347 0 0 38.450281,54.164021 L 42.230857,52.614978 41.6736,51.39323 37.923755,52.929464 a 7.769068,8.0847094 80.78347 0 0 -3.744376,-3.439252 l 1.276729,-3.539928 z" style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:2.79215;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1711" /> <ellipse transform="matrix(0.95139532,0.3079723,-0.33927307,0.94068793,0,0)" ry="4.1125383" rx="4.2921138" cy="44.294975" cx="48.270733" id="ellipse1713" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:2.79292;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> </g> </g> </g> </g> </svg>',
        'reporting' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="reporting_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1267" transform="translate(-516.36298,120.59798)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1901" cx="560.86298" cy="-76.097977" r="44.5" /> <g transform="matrix(0.92804321,0,0,0.92804321,520.0157,-115.53812)" id="g1941"> <rect style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:2.72882;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1903" width="46.066586" height="55.778526" x="20.981127" y="14.608912" /> <g id="g1915" transform="translate(-18.975105,11.590445)"> <rect y="30.855707" x="58.4202" height="17.347778" width="2.5664048" id="rect1905" style="fill:#f17f0f;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#2ecc71;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1907" width="2.5664048" height="14.502365" x="55.376896" y="33.701122" /> <rect y="37.130905" x="52.333588" height="11.072581" width="2.5664048" id="rect1909" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#ff5900;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1911" width="2.5664048" height="14.401514" x="49.290279" y="33.801968" /> <rect y="37.943485" x="46.246971" height="10.26" width="2.5664048" id="rect1913" style="fill:#f1c40f;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> </g> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1917" width="18.842707" height="1.2298776" x="24.64933" y="27.746386" /> <rect y="30.647217" x="24.64933" height="1.2298776" width="18.842707" id="rect1919" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#7f8c8d;fill-opacity:1;stroke:none;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1921" width="37.877144" height="7.3541164" x="24.639267" y="16.698078" /> <g id="g1927" transform="matrix(0.95852127,0,0,0.91364867,3.1976965,-6.4923595)"> <ellipse ry="9.5109682" rx="9.5109673" cy="65.487984" cx="53.384186" id="ellipse1923" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:0.978064;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path transform="matrix(0.00469988,-0.99998896,0.99999192,0.00402008,0,0)" inkscape:transform-center-y="-2.1668337" inkscape:transform-center-x="-5.5960088" sodipodi:arc-type="slice" sodipodi:end="1.5833133" sodipodi:start="0" sodipodi:ry="10.519011" sodipodi:rx="9.7285824" sodipodi:cy="53.966728" sodipodi:cx="-64.537109" sodipodi:type="arc" style="fill:#9b59b6;fill-opacity:1;stroke:#505050;stroke-width:1.04029;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1925" d="m -54.808527,53.966728 a 9.7285824,10.519011 0 0 1 -2.892623,7.484469 9.7285824,10.519011 0 0 1 -6.957729,3.033718 l 0.12177,-10.518187 z" /> </g> <rect y="33.038052" x="24.64933" height="1.2298776" width="18.842707" id="rect1929" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1931" width="18.842707" height="1.2298776" x="24.64933" y="35.938885" /> <rect y="27.746386" x="45.815998" height="1.2298776" width="18.842707" id="rect1933" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1935" width="18.842707" height="1.2298776" x="45.815998" y="30.647217" /> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1937" width="18.842707" height="1.2298776" x="45.815998" y="33.038052" /> <rect y="35.938885" x="45.815998" height="1.2298776" width="18.842707" id="rect1939" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> </g> </g> </g> </svg>',
        'serial_control' => '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="serialcontrol_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1286" transform="translate(-281.49057,-2.5378113)"> <circle r="44.5" cy="47.037811" cx="325.99057" id="circle964" style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <g transform="matrix(0.91798972,0,0,0.89364827,284.7082,10.037406)" id="g981"> <g id="g964"> <rect y="16.165668" x="23.852057" height="52.949757" width="25.184425" id="rect2016" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:2.55707;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:3.26181;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1966" width="41.531956" height="52.245018" x="24.204426" y="16.518038" /> <rect y="16.186131" x="23.872519" height="52.772163" width="27.061792" id="rect2018" style="fill:#16a085;fill-opacity:1;stroke:none;stroke-width:2.64622;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#7f8c8d;fill-opacity:1;stroke:#505050;stroke-width:1.08;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1970" width="13.623199" height="9.219327" x="50.406734" y="24.585953" /> <rect y="38.142365" x="50.116444" height="0.65573901" width="14.203777" id="rect1972" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path style="fill:#bdc3c7;fill-opacity:1;stroke:#505050;stroke-width:1.08;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="M 50.953404,68.67798 C 47.763061,45.740566 33.02911,62.237914 31.893764,39.516706 l -0.06458,-26.56323 c 3.152654,4.002705 11.302976,-3.3389856 18.675511,2.597708 0.182409,7.448094 -0.342627,14.784271 -0.293811,21.639773 0.07634,10.72012 0.103515,21.13569 0.742518,31.487023 z" id="path1968" sodipodi:nodetypes="ccccscc" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2006" width="14.203777" height="0.65573901" x="50.116444" y="42.375698" /> <rect y="46.609035" x="50.116444" height="0.65573901" width="14.203777" id="rect2008" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2010" width="14.203777" height="0.65573901" x="50.116444" y="38.142365" /> <rect y="42.375698" x="50.116444" height="0.65573901" width="14.203777" id="rect2012" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2014" width="14.203777" height="0.65573901" x="50.116444" y="46.609035" /> <rect style="fill:#1abc9c;fill-opacity:1;stroke:none;stroke-width:1.20148;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2020" width="3.3098521" height="46.953247" x="24.204426" y="16.518038" /> <text id="text948" y="64.037369" x="58.702221" style="font-size:7.7611px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#505050;fill-opacity:1;stroke-width:0.264583" xml:space="preserve"><tspan style="font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-family:Impact;-inkscape-font-specification:Impact;fill:#505050;fill-opacity:1;stroke-width:0.264583" y="64.037369" x="58.702221" id="tspan946" sodipodi:role="line">1</tspan></text> </g> </g> </g> </g> </svg>'
    ];

    // define other icon for custom module
    $other = [
        '<svg class="w-32 h-32 mx-auto block cursor-pointer hover:shadow-2xl hover:bg-gray-300 p-1 rounded-full" version="1.1" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg"><g><circle cx="44.5" cy="44.5" r="44.5" fill="#eee" style="paint-order:stroke markers fill"/><rect x="27.879" y="23.195" width="33.242" height="42.61" fill="#ebf5ff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3648" style="paint-order:stroke markers fill"/><rect x="29.312" y="23.198" width="30.875" height="42.605" fill="#bdc3c7" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width=".68698" style="paint-order:stroke markers fill"/></g><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3513"><rect x="45.112" y="25.55" width="14.789" height="8.2256" ry="1.3955" fill="#e67e22" style="paint-order:stroke markers fill"/><rect x="44.397" y="35.919" width="14.789" height="8.2256" ry="1.3955" fill="#3498db" style="paint-order:stroke markers fill"/><rect x="44.039" y="45.93" width="14.789" height="8.2256" ry="1.3955" fill="#27ae60" style="paint-order:stroke markers fill"/></g><g><rect x="27.869" y="23.185" width="29.378" height="42.629" fill="#fff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6694" style="paint-order:stroke markers fill"/><rect x="27.814" y="23.13" width="25.543" height="42.74" fill="#68c2ff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5587" style="paint-order:stroke markers fill"/><rect x="27.879" y="23.192" width="1.4269" height="42.613" fill="#3b9dff" style="paint-order:stroke markers fill"/><text transform="scale(1.13 .88499)" x="33.284637" y="55.413918" fill="#505050" font-family="sans-serif" font-size="20.274px" stroke-width=".50686" style="line-height:1.25" xml:space="preserve"><tspan x="33.284637" y="55.413918" fill="#505050" font-family="Cantarell" stroke-width=".50686">?</tspan></text></g></svg>
        '];

    // start buffer
    ob_start();
    $module_list = '';
    
    // chunk into 8
    $module_data = array_chunk(getModule(), 8);

    // Generate
    foreach ($module_data as $module) 
    {
        $module_list .= '<div class="grid grid-flow-col grid-cols-6 grid-rows-1 gap-1">';
        foreach ($module as $mod) 
        {
            // check privileages
            $modname = strtolower($mod[1]);
            if (isset($_SESSION['priv'][$modname]) && ($_SESSION['priv'][$modname]['r']))
            {
                // check icon
                if (isset($module_icon[$modname]))
                {
                    $moduleName   = ucwords(str_replace('_', ' ', $modname)); // took from module.inc.php
                    $module_list .= '<div class="load text-gray-700 text-center px-2 py-2 m-1" data-path="'.modulePath($mod[0]).'" data-href="'.MWB.modulePath($mod[0]).'/index.php">'."\n";
                    $module_list .= $module_icon[$modname]."\n";
                    $module_list .= '<span class="font-bold block text-center">'.__($moduleName).'</span>'."\n";
                    $module_list .= '</div>'."\n";
                }
                else
                {
                    // Other module
                    $moduleName   = ucwords(str_replace('_', ' ', $modname)); // took from module.inc.php
                    $module_list .= '<div class="load text-gray-700 text-center px-2 py-2 m-1" data-path="'.modulePath($mod[0]).'" data-href="'.MWB.modulePath($mod[0]).'/index.php">'."\n";
                    $module_list .= $other[0]."\n";
                    $module_list .= '<span class="font-bold block text-center">'.__($moduleName).'</span>'."\n";
                    $module_list .= '</div>'."\n";
                }
            }
        }
        $module_list .= '</div>';
    }
    // set output
    echo $module_list;
    $list = ob_get_clean();
    return $list;
}

// Set module list left
function moduleLeftList()
{
    // define icon
    $module_icon = [
        'bibliography' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1"> <g id="g1174" transform="translate(106.46753,128.49679)"> <g transform="matrix(1.2714286,0,0,1.2714286,-120.88742,-140.01499)" id="g907"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.583359;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle895" cx="46.341488" cy="44.059261" r="35" /> <g id="g905" transform="translate(2.737582,-2.1401071)"> <rect style="fill:#3498db;stroke:#505050;stroke-width:1.71834;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect897" width="29.254547" height="37.815216" x="30.942619" y="27.134706" /> <rect y="28.161148" x="30.926674" height="36.804504" width="28.162392" id="rect899" style="fill:#ecf0f1;stroke:#505050;stroke-width:1.66329;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect y="27.134617" x="27.010555" height="38.145092" width="28.995415" id="rect901" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:1.71816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path d="m 30.926704,27.119118 v 11.08032 h 0.399725 l 2.065052,-1.835416 2.167962,1.835416 h 0.386668 v -11.08032 z" style="fill:#ecf0f1;stroke:#505050;stroke-width:1.71834;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path903" /> </g> </g> </g> </g> </svg>',
        'circulation' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="circulation_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1185" transform="translate(0.18314067,129.50548)"> <g id="g962" transform="translate(-0.71230785,-130.03465)"> <circle r="44.5" cy="45.029167" cx="45.029167" id="path861" style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <g transform="matrix(0.82613357,0,0,0.80992807,6.6088374,9.8078435)" id="g952"> <rect style="fill:#2ecc71;fill-opacity:1;stroke:#505050;stroke-width:3;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect915" width="63.603176" height="61.420513" x="14.704608" y="12.776721" ry="4.7307506" /> <g id="g944" transform="matrix(0.863902,0,0,0.85945422,6.2086824,6.099837)"> <path d="m 27.621669,29.502204 -6.688728,7.50794 4.298743,-0.05985 v 20.020304 h 4.329284 V 36.889691 l 4.697947,-0.06544 z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:2.78906;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect923" /> <path id="path928" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:2.78906;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 65.721672,57.499844 -6.688728,-7.50794 4.298743,0.05985 v -20.0203 h 4.329284 v 20.080903 l 4.697947,0.06544 z" /> <path id="path930" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:3.02138;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 62.763539,23.683013 -8.810832,-6.688728 0.07024,4.298743 H 30.528415 v 4.329284 h 23.565648 l 0.07679,4.697947 z" /> <path d="m 29.999151,63.370517 8.810832,-6.688728 -0.07024,4.298743 h 23.494532 v 4.329284 H 38.668627 l -0.07679,4.697947 z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:3.02138;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path932" /> </g> </g> </g> </g> </g> </svg>',
        'membership' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="membership_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1196" transform="translate(-102.73074,122.68412)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1056" cx="147.23074" cy="-78.18412" r="44.5" /> <g transform="translate(97.224381,-120.36928)" id="g1072"> <g id="g1064"> <ellipse ry="5.5320091" rx="5.532011" cy="25.856213" cx="59.352348" id="ellipse1058" style="fill:#2ecc71;fill-opacity:1;stroke:#505050;stroke-width:3.93598;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path sodipodi:nodetypes="cccc" d="M 58.850186,36.76772 76.690708,54.304511 C 63.643093,70.950737 46.154262,61.325033 41.313396,54.608241 Z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:4.98354;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1060" /> <path id="path1062" style="fill:#2980b9;fill-opacity:1;stroke:none;stroke-width:1.14713;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 58.850186,36.76772 3.295668,5.029989 -3.23956,5.117109 -3.295668,-5.02999 z" /> </g> <ellipse ry="5.5320091" rx="5.532011" cy="25.856213" cx="41.360695" id="ellipse1066" style="fill:#7f8c8d;fill-opacity:1;stroke:#505050;stroke-width:3.93598;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path sodipodi:nodetypes="cccc" d="m 40.858534,36.76772 17.840522,17.536791 -35.377311,0.30373 z" style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:4.98354;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1068" /> <path id="path1070" style="fill:#16a085;fill-opacity:1;stroke:none;stroke-width:1.14713;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 40.858534,36.76772 3.295668,5.029989 -3.23956,5.117109 -3.295667,-5.02999 z" /> </g> </g> </g> </svg>',
        'master_file' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="masterfile_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1216" transform="translate(-205.71654,129.46401)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1188" cx="250.21654" cy="-84.964012" r="44.5" /> <g transform="matrix(0.8137019,0,0,0.8137019,213.41493,-119.95353)" id="g1222"> <rect y="12.967948" x="26.920876" height="55.302444" width="41.904682" id="rect1190" style="fill:#a0d9ff;fill-opacity:1;stroke:#505050;stroke-width:5.40838;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <g id="g1220"> <rect y="25.099907" x="32.306278" height="0.93088984" width="33.146427" id="rect1192" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1194" width="33.146427" height="0.93088984" x="32.306278" y="30.391573" /> <rect y="36.212406" x="32.306278" height="0.93088984" width="33.146427" id="rect1196" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1198" width="33.146427" height="0.93088984" x="32.306278" y="41.504074" /> <rect y="46.795742" x="32.306278" height="0.93088984" width="33.146427" id="rect1200" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1202" width="33.146427" height="0.93088984" x="32.306278" y="52.616577" /> <g transform="translate(1.0583333,-0.52916667)" id="g1218"> <rect style="fill:#fbfbfb;fill-opacity:1;stroke:#505050;stroke-width:5.40838;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1204" width="41.904682" height="55.302444" x="20.570877" y="18.259615" /> <rect y="30.92074" x="24.897945" height="0.93088984" width="33.146427" id="rect1206" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1208" width="33.146427" height="0.93088984" x="24.897945" y="36.212406" /> <rect y="42.033241" x="24.897945" height="0.93088984" width="33.146427" id="rect1210" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1212" width="33.146427" height="0.93088984" x="24.897945" y="47.324909" /> <rect y="52.616577" x="24.897945" height="0.93088984" width="33.146427" id="rect1214" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.953461;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1216" width="33.146427" height="0.93088984" x="24.897945" y="58.437412" /> </g> </g> </g> </g> </g> </svg>',
        'stock_take' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="stocktake.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1233" transform="translate(-310.27756,128.244)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1467" cx="354.77756" cy="-83.744003" r="44.5" /> <g transform="matrix(1.1048537,0,0,1.1926895,306.82624,-135.28149)" id="g1495"> <rect y="20.591423" x="54.623814" height="35.920689" width="6.7774096" id="rect1469" style="fill:#f1c40f;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect y="24.991159" x="38.571468" height="35.920689" width="6.7774096" id="rect1471" style="fill:#64edff;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#27ae60;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1473" width="6.7774096" height="35.920689" x="46.508976" y="23.932825" /> <rect y="23.846973" x="46.423122" height="36.594509" width="1.6522932" id="rect1475" style="fill:#1abc9c;fill-opacity:1;stroke:#505050;stroke-width:0.669427;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#57ebce;fill-opacity:1;stroke:#505050;stroke-width:0.669427;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1477" width="1.6522932" height="36.594509" x="38.485615" y="24.905308" /> <g id="g1483" transform="matrix(1.6091572,0,0,1.1336288,-23.012641,-8.361513)"> <rect y="24.991159" x="30.633961" height="35.920689" width="6.7774096" id="rect1479" style="fill:#ff6524;fill-opacity:1;stroke:#505050;stroke-width:1.34325;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#ffb624;fill-opacity:1;stroke:#505050;stroke-width:0.669427;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1481" width="1.6522932" height="36.594509" x="30.548107" y="24.905308" /> </g> <rect style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:1.80724;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1485" width="38.484158" height="31.685684" x="24.166206" y="34.625195" /> <rect style="fill:#d35400;fill-opacity:1;stroke:#505050;stroke-width:1.16575;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1487" width="1.1278092" height="13.156289" x="60.211086" y="20.653749" /> <rect y="34.625195" x="45.080639" height="31.685684" width="17.569723" id="rect1489" style="fill:#dcdcdc;fill-opacity:1;stroke:none;stroke-width:1.22112;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#1b8eff;fill-opacity:1;stroke:#505050;stroke-width:2.27118;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1491" width="44.190067" height="9.3513784" x="21.305571" y="34.798729" /> <rect style="fill:#ccd1d5;fill-opacity:1;stroke:none;stroke-width:1.91706;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1493" width="13.392535" height="11.290557" x="26.662313" y="52.423279" /> </g> </g> </g> </svg>',
        'system' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="system_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1244" transform="translate(-404.83862,119.50776)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1701" cx="449.33862" cy="-75.007759" r="44.5" /> <g transform="matrix(0.97432515,0,0,0.97432515,406.46847,-119.45502)" id="g1717"> <g id="g1715" transform="matrix(1.0204816,0,0,1.0204816,-0.83248189,0.60650808)"> <path d="m 55.667278,31.744057 v 4.787716 a 9.834351,10.038859 0 0 0 -5.387687,2.120705 l -3.279044,-3.438233 -1.240342,1.183061 3.279643,3.439439 a 9.834351,10.038859 0 0 0 -2.473453,5.74948 h -4.740679 v 1.714291 h 4.723193 a 9.834351,10.038859 0 0 0 1.946442,5.278549 l -3.427377,3.11322 1.15291,1.268685 3.40567,-3.093927 a 9.834351,10.038859 0 0 0 6.040724,2.69294 v 4.582099 h 1.714896 v -4.612249 a 9.834351,10.038859 0 0 0 5.346079,-2.338383 l 3.320048,3.481043 1.240946,-1.183662 -3.367681,-3.531092 a 9.834351,10.038859 0 0 0 2.240097,-5.657223 h 5.062073 v -1.714291 h -5.079559 a 9.834351,10.038859 0 0 0 -1.883734,-5.012028 l 3.720429,-3.37974 -1.152307,-1.269288 -3.690279,3.352003 a 9.834351,10.038859 0 0 0 -5.756112,-2.714647 v -4.818468 z" style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:3.50055;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1703" /> <ellipse ry="5.2658691" rx="5.2658701" cy="46.443069" cx="56.524727" id="ellipse1705" style="fill:#ecbdff;fill-opacity:1;stroke:#505050;stroke-width:3.50055;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path id="path1707" style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:2.5137;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" d="m 40.056605,17.33706 -1.111617,3.253326 a 7.0619212,7.208776 18.864581 0 0 -4.153403,0.190133 l -1.42987,-3.097662 -1.117515,0.515923 1.429997,3.098622 a 7.0619212,7.208776 18.864581 0 0 -3.015669,3.332573 l -3.221366,-1.100696 -0.398026,1.164887 3.209484,1.096636 a 7.0619212,7.208776 18.864581 0 0 0.09706,4.038782 l -3.051786,1.319709 0.488855,1.129775 3.032557,-1.31164 a 7.0619212,7.208776 18.864581 0 0 3.479515,3.232436 l -1.063876,3.113607 1.165299,0.398165 1.070875,-3.134093 a 7.0619212,7.208776 18.864581 0 0 4.175673,-0.34771 l 1.447791,3.136273 1.118066,-0.516191 -1.468539,-3.181344 a 7.0619212,7.208776 18.864581 0 0 2.835679,-3.324063 l 3.439757,1.175318 0.398026,-1.164887 -3.45164,-1.179377 a 7.0619212,7.208776 18.864581 0 0 -0.116323,-3.843118 l 3.312799,-1.432773 -0.488306,-1.130044 -3.285872,1.420926 a 7.0619212,7.208776 18.864581 0 0 -3.281078,-3.181104 l 1.118757,-3.274223 z" /> <ellipse transform="rotate(18.864581)" style="fill:#7f8c8d;fill-opacity:1;stroke:#505050;stroke-width:2.5137;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="ellipse1709" cx="43.992702" cy="14.096194" rx="3.7813537" ry="3.7813528" /> <path d="m 34.126266,45.519806 -1.268579,3.517335 a 7.769068,8.0847094 80.78347 0 0 -4.739875,0.205563 l -1.631771,-3.349039 -1.275311,0.557791 1.631915,3.350076 a 7.769068,8.0847094 80.78347 0 0 -3.44149,3.603013 l -3.67623,-1.190018 -0.454228,1.259419 3.662671,1.185628 a 7.769068,8.0847094 80.78347 0 0 0.110769,4.366531 l -3.482707,1.426804 0.557884,1.221457 3.46076,-1.41808 a 7.769068,8.0847094 80.78347 0 0 3.970834,3.49475 l -1.214099,3.366278 1.329841,0.430477 1.222087,-3.388428 a 7.769068,8.0847094 80.78347 0 0 4.765287,-0.375927 l 1.652224,3.390785 1.27594,-0.558081 -1.6759,-3.43951 a 7.769068,8.0847094 80.78347 0 0 3.236084,-3.593813 l 3.92546,1.270695 0.454228,-1.259418 -3.939021,-1.275085 A 7.769068,8.0847094 80.78347 0 0 38.450281,54.164021 L 42.230857,52.614978 41.6736,51.39323 37.923755,52.929464 a 7.769068,8.0847094 80.78347 0 0 -3.744376,-3.439252 l 1.276729,-3.539928 z" style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:2.79215;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1711" /> <ellipse transform="matrix(0.95139532,0.3079723,-0.33927307,0.94068793,0,0)" ry="4.1125383" rx="4.2921138" cy="44.294975" cx="48.270733" id="ellipse1713" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:2.79292;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> </g> </g> </g> </g> </svg>',
        'reporting' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="reporting_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1267" transform="translate(-516.36298,120.59798)"> <circle style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="circle1901" cx="560.86298" cy="-76.097977" r="44.5" /> <g transform="matrix(0.92804321,0,0,0.92804321,520.0157,-115.53812)" id="g1941"> <rect style="fill:#ffffff;fill-opacity:1;stroke:#505050;stroke-width:2.72882;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1903" width="46.066586" height="55.778526" x="20.981127" y="14.608912" /> <g id="g1915" transform="translate(-18.975105,11.590445)"> <rect y="30.855707" x="58.4202" height="17.347778" width="2.5664048" id="rect1905" style="fill:#f17f0f;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#2ecc71;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1907" width="2.5664048" height="14.502365" x="55.376896" y="33.701122" /> <rect y="37.130905" x="52.333588" height="11.072581" width="2.5664048" id="rect1909" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#ff5900;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1911" width="2.5664048" height="14.401514" x="49.290279" y="33.801968" /> <rect y="37.943485" x="46.246971" height="10.26" width="2.5664048" id="rect1913" style="fill:#f1c40f;fill-opacity:1;stroke:#505050;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> </g> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1917" width="18.842707" height="1.2298776" x="24.64933" y="27.746386" /> <rect y="30.647217" x="24.64933" height="1.2298776" width="18.842707" id="rect1919" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#7f8c8d;fill-opacity:1;stroke:none;stroke-width:0.935816;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1921" width="37.877144" height="7.3541164" x="24.639267" y="16.698078" /> <g id="g1927" transform="matrix(0.95852127,0,0,0.91364867,3.1976965,-6.4923595)"> <ellipse ry="9.5109682" rx="9.5109673" cy="65.487984" cx="53.384186" id="ellipse1923" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:0.978064;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path transform="matrix(0.00469988,-0.99998896,0.99999192,0.00402008,0,0)" inkscape:transform-center-y="-2.1668337" inkscape:transform-center-x="-5.5960088" sodipodi:arc-type="slice" sodipodi:end="1.5833133" sodipodi:start="0" sodipodi:ry="10.519011" sodipodi:rx="9.7285824" sodipodi:cy="53.966728" sodipodi:cx="-64.537109" sodipodi:type="arc" style="fill:#9b59b6;fill-opacity:1;stroke:#505050;stroke-width:1.04029;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="path1925" d="m -54.808527,53.966728 a 9.7285824,10.519011 0 0 1 -2.892623,7.484469 9.7285824,10.519011 0 0 1 -6.957729,3.033718 l 0.12177,-10.518187 z" /> </g> <rect y="33.038052" x="24.64933" height="1.2298776" width="18.842707" id="rect1929" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1931" width="18.842707" height="1.2298776" x="24.64933" y="35.938885" /> <rect y="27.746386" x="45.815998" height="1.2298776" width="18.842707" id="rect1933" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1935" width="18.842707" height="1.2298776" x="45.815998" y="30.647217" /> <rect style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1937" width="18.842707" height="1.2298776" x="45.815998" y="33.038052" /> <rect y="35.938885" x="45.815998" height="1.2298776" width="18.842707" id="rect1939" style="fill:#505050;fill-opacity:1;stroke:none;stroke-width:1.03997;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> </g> </g> </g> </svg>',
        'serial_control' => '<svg class="w-10 h-10 inline-block" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="serialcontrol_web.svg" inkscape:version="1.0 (4035a4fb49, 2020-05-01)" id="svg1469" version="1.1" viewBox="0 0 90 90" height="90mm" width="90mm"> <defs id="defs1463" /> <sodipodi:namedview inkscape:window-maximized="1" inkscape:window-y="25" inkscape:window-x="0" inkscape:window-height="695" inkscape:window-width="1366" showgrid="false" inkscape:document-rotation="0" inkscape:current-layer="layer1" inkscape:document-units="mm" inkscape:cy="170.09694" inkscape:cx="612.49572" inkscape:zoom="0.7" inkscape:pageshadow="2" inkscape:pageopacity="0.0" borderopacity="1.0" bordercolor="#666666" pagecolor="#ffffff" id="base" /> <metadata id="metadata1466"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g id="layer1" inkscape:groupmode="layer" inkscape:label="Lapis 1"> <g id="g1286" transform="translate(-281.49057,-2.5378113)"> <circle r="44.5" cy="47.037811" cx="325.99057" id="circle964" style="fill:#eeeeee;fill-opacity:1;stroke:none;stroke-width:0.741699;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <g transform="matrix(0.91798972,0,0,0.89364827,284.7082,10.037406)" id="g981"> <g id="g964"> <rect y="16.165668" x="23.852057" height="52.949757" width="25.184425" id="rect2016" style="fill:#3498db;fill-opacity:1;stroke:#505050;stroke-width:2.55707;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#ecf0f1;fill-opacity:1;stroke:#505050;stroke-width:3.26181;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1966" width="41.531956" height="52.245018" x="24.204426" y="16.518038" /> <rect y="16.186131" x="23.872519" height="52.772163" width="27.061792" id="rect2018" style="fill:#16a085;fill-opacity:1;stroke:none;stroke-width:2.64622;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#7f8c8d;fill-opacity:1;stroke:#505050;stroke-width:1.08;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect1970" width="13.623199" height="9.219327" x="50.406734" y="24.585953" /> <rect y="38.142365" x="50.116444" height="0.65573901" width="14.203777" id="rect1972" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <path style="fill:#bdc3c7;fill-opacity:1;stroke:#505050;stroke-width:1.08;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="M 50.953404,68.67798 C 47.763061,45.740566 33.02911,62.237914 31.893764,39.516706 l -0.06458,-26.56323 c 3.152654,4.002705 11.302976,-3.3389856 18.675511,2.597708 0.182409,7.448094 -0.342627,14.784271 -0.293811,21.639773 0.07634,10.72012 0.103515,21.13569 0.742518,31.487023 z" id="path1968" sodipodi:nodetypes="ccccscc" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2006" width="14.203777" height="0.65573901" x="50.116444" y="42.375698" /> <rect y="46.609035" x="50.116444" height="0.65573901" width="14.203777" id="rect2008" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2010" width="14.203777" height="0.65573901" x="50.116444" y="38.142365" /> <rect y="42.375698" x="50.116444" height="0.65573901" width="14.203777" id="rect2012" style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" /> <rect style="fill:#505050;fill-opacity:1;stroke:#505050;stroke-width:0.294105;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2014" width="14.203777" height="0.65573901" x="50.116444" y="46.609035" /> <rect style="fill:#1abc9c;fill-opacity:1;stroke:none;stroke-width:1.20148;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke markers fill" id="rect2020" width="3.3098521" height="46.953247" x="24.204426" y="16.518038" /> <text id="text948" y="64.037369" x="58.702221" style="font-size:7.7611px;line-height:1.25;font-family:sans-serif;letter-spacing:0px;word-spacing:0px;fill:#505050;fill-opacity:1;stroke-width:0.264583" xml:space="preserve"><tspan style="font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-family:Impact;-inkscape-font-specification:Impact;fill:#505050;fill-opacity:1;stroke-width:0.264583" y="64.037369" x="58.702221" id="tspan946" sodipodi:role="line">1</tspan></text> </g> </g> </g> </g> </svg>'
    ];

    // define other icon for custom module
    $other = [
        '<svg class="w-10 h-10 inline-block" version="1.1" viewBox="0 0 90 90" xmlns="http://www.w3.org/2000/svg"><g><circle cx="44.5" cy="44.5" r="44.5" fill="#eee" style="paint-order:stroke markers fill"/><rect x="27.879" y="23.195" width="33.242" height="42.61" fill="#ebf5ff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3648" style="paint-order:stroke markers fill"/><rect x="29.312" y="23.198" width="30.875" height="42.605" fill="#bdc3c7" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width=".68698" style="paint-order:stroke markers fill"/></g><g stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3513"><rect x="45.112" y="25.55" width="14.789" height="8.2256" ry="1.3955" fill="#e67e22" style="paint-order:stroke markers fill"/><rect x="44.397" y="35.919" width="14.789" height="8.2256" ry="1.3955" fill="#3498db" style="paint-order:stroke markers fill"/><rect x="44.039" y="45.93" width="14.789" height="8.2256" ry="1.3955" fill="#27ae60" style="paint-order:stroke markers fill"/></g><g><rect x="27.869" y="23.185" width="29.378" height="42.629" fill="#fff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6694" style="paint-order:stroke markers fill"/><rect x="27.814" y="23.13" width="25.543" height="42.74" fill="#68c2ff" stroke="#505050" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5587" style="paint-order:stroke markers fill"/><rect x="27.879" y="23.192" width="1.4269" height="42.613" fill="#3b9dff" style="paint-order:stroke markers fill"/><text transform="scale(1.13 .88499)" x="33.284637" y="55.413918" fill="#505050" font-family="sans-serif" font-size="20.274px" stroke-width=".50686" style="line-height:1.25" xml:space="preserve"><tspan x="33.284637" y="55.413918" fill="#505050" font-family="Cantarell" stroke-width=".50686">?</tspan></text></g></svg>
        '];
    

    // Start buffer
    ob_start();
    $module_list = '';
    
    // chunk into 8
    $module_data = array_chunk(getModule(), 8);

    // Generate
    foreach ($module_data as $module) 
    {
        foreach ($module as $mod) 
        {
            // check privileages
            $modname = strtolower($mod[1]);
            // check privileages
            if (isset($_SESSION['priv'][$modname]) && ($_SESSION['priv'][$modname]['r']))
            {
                if (isset($module_icon[$modname]))
                {
                    $moduleName   = ucwords(str_replace('_', ' ', $modname)); // took from module.inc.php
                    $module_list .= '<div class="load text-gray-700 text-left px-4 py-2 mx-2 my-1 cursor-pointer hover:shadow-2xl hover:bg-gray-300" data-path="'.modulePath($mod[0]).'" data-href="'.MWB.modulePath($mod[0]).'/index.php">'."\n";
                    $module_list .= $module_icon[$modname];
                    $module_list .= '<span class="font-bold inline-block text-center text-md">'.__($moduleName).'</span>';
                    $module_list .= '</div>'."\n";
                }
                else
                {
                    $moduleName   = ucwords(str_replace('_', ' ', $modname)); // took from module.inc.php
                    $module_list .= '<div class="load text-gray-700 text-left px-4 py-2 mx-2 my-1 cursor-pointer hover:shadow-2xl hover:bg-gray-300" data-path="'.modulePath($mod[0]).'" data-href="'.MWB.modulePath($mod[0]).'/index.php">'."\n";
                    $module_list .= $other[0];
                    $module_list .= '<span class="font-bold inline-block text-center text-md">'.__($moduleName).'</span>';
                    $module_list .= '</div>'."\n";
                }
            }
        }
    }
    // set output
    echo $module_list;
    $list = ob_get_clean();
    return $list;
}

// load menut
function loadSubmenu($_path)
{
    global $dbs;

    $listmenu = '';

    // check
    if (file_exists(MDLBS.$_path.DS.'submenu.php'))
    {
        // include
        include_once MDLBS.$_path.DS.'submenu.php';

        // loop
        foreach ($menu as $_menu) {
            // Header
            if ($_menu[0] == 'Header')
            {
                $listmenu .= '<h1 class="text-lg ml-2 py-1 font-semibold">'.$_menu[1].'</h1>';
            }
            else
            {
                // content
                $listmenu .= '<span class="load-child px-2 py-1 block w-full font-semibold cursor-pointer hover:shadow-xl hover:bg-gray-800" title="'.$_menu[2].'" data-href="'.$_menu[1].'"><svg class="inline-block" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-justify" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                  </svg> '.$_menu[0].'</span>';
            }
        }
    }
    // set output
    echo $listmenu;
}

// Greate
function setGreater()
{
    $time = '?';
    switch (true) {
        case (date('G') >= 0 && date('G') < 11):
            $time = 'Selamat Pagi, ';
            break;

        case (date('G') >= 11 && date('G') < 15):
            $time = 'Selamat Siang, ';
            break;
        
        case (date('G') >= 15 && date('G') < 21):
            $time = 'Selamat Sore, ';
            break;
        
        case (date('G') >= 21 && date('G') <= 23):
            $time = 'Selamat Malam, ';
            break;
    }

    return $time;
}

// set warning
function setWarning($except = null)
{
    global $dbs,$sysconf;
    /**
     * Took from home.php
     */
    // generate warning messages
    $warnings = array();
    // check if images dir is writable or not
    if (!is_writable(IMGBS) OR !is_writable(IMGBS.'barcodes') OR !is_writable(IMGBS.'persons') OR !is_writable(IMGBS.'docs')) {
        $warnings[] = __('<strong>Images</strong> directory and directories under it is not writable. Make sure it is writable by changing its permission or you won\'t be able to upload any images and create barcodes');
    }
    // check if file repository dir is writable or not
    if (!is_writable(REPOBS)) {
        $warnings[] = __('<strong>Repository</strong> directory is not writable. Make sure it is writable (and all directories under it) by changing its permission or you won\'t be able to upload any bibliographic attachments.');
    }
    // check if file upload dir is writable or not
    if (!is_writable(UPLOAD)) {
        $warnings[] = __('<strong>File upload</strong> directory is not writable. Make sure it is writable (and all directories under it) by changing its permission or you won\'t be able to upload any file, create report files and create database backups.');
    }
    // check mysqldump
    if (!file_exists($sysconf['mysqldump'])) {
        $warnings[] = __('The PATH for <strong>mysqldump</strong> program is not right! Please check configuration file or you won\'t be able to do any database backups.');
    }
    // check installer directory
    if (is_dir('../install/')) {
        $warnings[] = __('Installer folder is still exist inside your server. Please remove it or rename to another name for security reason.');
    }

    // check GD extension
    if (!extension_loaded('gd')) {
        $warnings[] = __('<strong>PHP GD</strong> extension is not installed. Please install it or application won\'t be able to create image thumbnail and barcode.');
    } else {
        // check GD Freetype
        if (!function_exists('imagettftext')) {
            $warnings[] = __('<strong>Freetype</strong> support is not enabled in PHP GD extension. Rebuild PHP GD extension with Freetype support or application won\'t be able to create barcode.');
        }
    }

    if (!is_nan($except))
    {
        unset($warnings[$except]);
    }

    return $warnings;
}

// set info
function setInfo()
{
    global $dbs;
    // info
    $info = [];
    // check for overdue
    $overdue_q = $dbs->query('SELECT COUNT(loan_id) FROM loan AS l WHERE (l.is_lent=1 AND l.is_return=0 AND TO_DAYS(due_date) < TO_DAYS(\''.date('Y-m-d').'\')) GROUP BY member_id');
    $num_overdue = $overdue_q->num_rows;
    if ($num_overdue > 0) {
        $info[] = str_replace('{num_overdue}', $num_overdue, __('There are currently <strong>{num_overdue}</strong> library members having overdue. Please check at <b>Circulation</b> module at <b>Overdues</b> section for more detail')); //mfc
        $overdue_q->free_result();
    }

    return $info;
}

// repair
function setRepair()
{
    global $dbs;

    // check need to be repaired mysql database
    $query_of_tables    = $dbs->query('SHOW TABLES');
    $num_of_tables      = $query_of_tables->num_rows;
    $prevtable          = '';
    $repair             = '';
    $is_repaired        = false;
    $repair_form        = '';

    if ($_SESSION['uid'] === '1') {
        $warnings[] = __('<strong><i>You are logged in as Super User. With great power comes great responsibility.</i></strong>');
        if (isset ($_POST['do_repair'])) {
            if ($_POST['do_repair'] == 1) {
                while ($row = $query_of_tables->fetch_row()) {
                    $sql_of_repair = 'REPAIR TABLE '.$row[0];
                    $query_of_repair = $dbs->query ($sql_of_repair);
                }
            }
        }

        while ($row = $query_of_tables->fetch_row()) {
            $query_of_check = $dbs->query('CHECK TABLE '.$row[0]);
            while ($rowcheck = $query_of_check->fetch_assoc()) {
                if (!(($rowcheck['Msg_type'] == "status") && ($rowcheck['Msg_text'] == "OK"))) {
                    if ($row[0] != $prevtable) {
                    $repair .= '<li>Table '.$row[0].' might need to be repaired.</li>';
                    }
                    $prevtable = $row[0];
                    $is_repaired = true;
                }
            }
        }
        
        if (($is_repaired) && !isset($_POST['do_repair'])) {
            $repair_form  = '<div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">';
            $repair_form .= '<p class="font-bold">Table</p>';
            $repair_form .= '<ul>';
            $repair_form .= $repair;
            $repair_form .= '</ul>';
            $repair_form .= '</div>';
            $repair_form .= ' <form method="POST" style="margin:0 10px;">
                <input type="hidden" name="do_repair" value="1">
                <input type="submit" value="'.__('Click Here To Repair The Tables').'" class="button btn btn-block btn-default">
                </form>';
        }
    }

    return $repair_form;
}

// statistic
function chart($type)
{
        // Take from home.php
        global $dbs;

        if ($type == 'barchart'):
            // generate dashboard content
            $get_date       = '';
            $get_loan       = '';
            $get_return     = '';
            $get_extends    = '';
            $start_date     = date('Y-m-d'); // set date from TODAY
        
            // get date transaction
            $sql_date = 
                    "SELECT 
                        DATE_FORMAT(loan_date,'%d/%m') AS loandate,
                        loan_date
                    FROM 
                        loan
                    WHERE 
                        loan_date BETWEEN DATE_SUB('".$start_date."', INTERVAL 8 DAY) AND '".$start_date."' 
                    GROUP BY 
                        loan_date
                    ORDER BY 
                        loan_date";
        
            // echo $sql_date; //for debug purpose only
            $set_date       = $dbs->query($sql_date);
            if($set_date->num_rows > 0 ) {
                while ($transc_date = $set_date->fetch_object()) {
                    // set transaction date
                    $get_date .= $transc_date->loandate.',';
        
                    // get latest loan
                    $sql_loan = 
                            "SELECT 
                                COUNT(loan_date) AS countloan
                            FROM 
                                loan
                            WHERE 
                                loan_date = '".$transc_date->loan_date."' 
                                AND is_lent = 1 
                                AND renewed = 0
                                AND is_return = 0
                            GROUP BY 
                                loan_date";
        
                    $set_loan       = $dbs->query($sql_loan);
                    if($set_loan->num_rows > 0) {
                        $transc_loan    = $set_loan->fetch_object();
                        $get_loan      .= (int)$transc_loan->countloan.',';            
                    } else {
                        $get_loan       .= '0,';
                    }
        
                    // get latest return
                    $sql_return = 
                            "SELECT 
                                COUNT(loan_date) AS countloan
                            FROM 
                                loan
                            WHERE 
                                loan_date = '".$transc_date->loan_date."' 
                                AND is_lent = 1 
                                AND renewed = 0
                                AND is_return = 1
                            GROUP BY 
                                return_date";
        
                    $set_return       = $dbs->query($sql_return);                     
                    if($set_return->num_rows > 0) {
                        $transc_return    = $set_return->fetch_object();
                        $get_return      .= $transc_return->countloan.',';
                    } else {
                        $get_return       .= '0,';
                    }
        
                    // get latest extends
                    $sql_extends = 
                            "SELECT 
                                COUNT(loan_date) AS countloan
                            FROM 
                                loan
                            WHERE 
                                loan_date = '".$transc_date->loan_date."' 
                                AND is_lent     = 1 
                                AND renewed     = 1
                            GROUP BY 
                                return_date";
                    $set_extends       = $dbs->query($sql_extends);   
                    if($set_extends->num_rows > 0) {              
                        $transc_extends    = $set_extends->fetch_object();
                        $get_extends      .= $transc_extends->countloan.',';
                    } else {
                        $get_extends      .= '0,';
                    }
                }
            }
            // return transaction date
            $default        = null;
            $get_date       = explode(',', trim(substr($get_date,0,-1), ','));
            $get_loan       = explode(',', trim(substr($get_loan,0,-1), ','));
            $get_return     = explode(',', trim(substr($get_return,0,-1), ','));
            $get_extends    = explode(',', trim(substr($get_extends,0,-1), ','));

            return [
                    (count($get_date) == 0)?$default:$get_date,
                    (count($get_loan) == 0)?$default:$get_loan,
                    (count($get_return) == 0)?$default:$get_return,
                    (count($get_extends) == 0)?$default:$get_extends
                   ];
        endif;

        if ($type == 'doughchart'):
            // get loan summary
            $sql_loan_coll = ' SELECT 
                                    COUNT(loan_id) AS total
                                FROM 
                                    loan
                                WHERE
                                    is_lent = 1
                                    AND is_return = 0';
            $total_loan         = $dbs->query($sql_loan_coll);
            $loan               = $total_loan->fetch_object();
            $get_total_loan     = $loan->total;

            // get total summary
            $sql_total_coll = ' SELECT 
                                    COUNT(loan_id) AS total
                                FROM 
                                    loan';
            $total_coll = $dbs->query($sql_total_coll);
            $total      = $total_coll->fetch_object();
            $get_total  = $total->total;
        
            // get return summary
            $sql_return_coll = ' SELECT 
                                    COUNT(loan_id) AS total
                                FROM 
                                    loan
                                WHERE
                                    is_lent = 1
                                    AND is_return = 1';
            $total_return         = $dbs->query($sql_return_coll);
            $return               = $total_return->fetch_object();
            $get_total_return     = $return->total;
        
            // get extends summary
            $sql_extends_coll = ' SELECT 
                                    COUNT(loan_id) AS total
                                FROM 
                                    loan
                                WHERE
                                    is_lent = 1
                                    AND renewed = 1
                                    AND is_return = 0';
            $total_extends         = $dbs->query($sql_extends_coll);
            $renew                 = $total_extends->fetch_object();
            $get_total_extends     = $renew->total;
        
            // get overdue
            $sql_overdue_coll = ' SELECT 
                                    COUNT(fines_id) AS total
                                FROM 
                                    fines';
            $total_overdue         = $dbs->query($sql_overdue_coll);
            $overdue               = $total_overdue->fetch_object();
            $get_total_overdue     = $overdue->total;

            return [$get_total, $get_total_loan, $get_total_return, $get_total_extends, $get_total_overdue];
        endif;

        if ($type == 'num'):
            // get loan summary
            $sql_loan_coll = ' SELECT 
                                    COUNT(loan_id) AS total
                                FROM 
                                    loan
                                WHERE
                                    is_lent = 1
                                    AND is_return = 0';
            $total_loan         = $dbs->query($sql_loan_coll);
            $loan               = $total_loan->fetch_object();
            $get_total_loan     = $loan->total;
            
            // get titles
            $sql_title_coll = ' SELECT 
                                    COUNT(biblio_id) AS total
                                FROM 
                                    biblio';
            $total_title         = $dbs->query($sql_title_coll);
            $title               = $total_title->fetch_object();
            $get_total_title     = $title->total;
        
            // get item
            $sql_item_coll = ' SELECT 
                                    COUNT(item_id) AS total
                                FROM 
                                    item';
            $total_item          = $dbs->query($sql_item_coll);
            $item                = $total_item->fetch_object();
            $get_total_item      = $item->total;
            $get_total_available = $item->total - $get_total_loan;
            $get_total_available = $get_total_available;

            // set out
            return [$get_total_title, $get_total_item, $get_total_loan,$get_total_available];
        endif;
}
