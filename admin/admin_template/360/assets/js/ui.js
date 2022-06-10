/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2020-08-21 23:56:48
 * @modify date 2020-08-21 23:56:48
 * @desc javascript ui
 */

'use strict';

// Open menu
$('.open-menu').click(function(){

    if ($('.show-menu').length == 0)
    {
        $('.left-menu').removeClass('hidden').addClass('show-menu');
    }
    else
    {
        $('.left-menu').removeClass('show-menu').addClass('hidden');
    }
});

// Open Alert
$('.open-alert').click(function(){

    if ($('.show-alert').length == 0)
    {
        $('.right-alert').removeClass('hidden').addClass('show-alert');
    }
    else
    {
        $('.right-alert').removeClass('show-alert').addClass('hidden');
    }
});

// Open ask
$('.ask').click(function(){
    if ($('.alert-open').length == 0)
    {
        if(localStorage.getItem('path') != null)
        {
            $('.right-ask').removeClass('hidden').addClass('alert-open');
            $('.ask-content').html("");
            $.get(localStorage.getItem('path'), function(res){
                $('.ask-content').html(res);
            })
        }
    }
    else
    {
        localStorage.removeItem('path');
        $('.right-ask').removeClass('alert-open').addClass('hidden'); 
    }
});

// Load view
$('.load').click(function(){
    $('.dashboard').hide();
    if ($('.show-menu').length == 1)
    {
        $('.left-menu').removeClass('show-menu').addClass('hidden');
    }
    $('#sidpan').attr('style', 'height: '+(parseInt($(window).height())-50)+'px');
    $('#submenu').simbioAJAX('./index.php?loadMenu='+$(this).data('path'));
    $('#mainContent').simbioAJAX($(this).data('href'));
});

// Load submenu
$('.submenu').on('click', '.load-child', function(){
    // Took from default setting by Eddie Subratha
    let get_url       = $(this).data('href');
    let path_array    = get_url.split('/');
    let clean_path    = path_array[path_array.length-1].split('.');
    let new_pathname  = awb+'help.php?url='+path_array[path_array.length-2]+'/'+clean_path[0]+'.md';

    localStorage.setItem('path', new_pathname);

    // load main content
    $('#mainContent').simbioAJAX($(this).data('href'));
});

// Counter
$('.count').each(function () {
    let obj = $(this);
    let idx = obj.data('src');
    $.getJSON(awb+'?chart=num', function(res){
        obj.prop('Counter',0).animate({
            Counter: res[idx]
        }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
                let num = Number(now);
                $(this).text(num.toFixed(0).replace('.', '.').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'));
            }
        }); 

        setTimeout(() => {
            console.info('Tunggu 3 detik, biar gak lama');
        }, 3000);
    })
});

// user pict
$('.userpict').click(function(e){
    e.preventDefault();
    if ($('.open-profile-menu').length == 0)
    {
        $('.profile-menu').removeClass('hidden').addClass('open-profile-menu');
    }
    else
    {
        $('.profile-menu').addClass('hidden').removeClass('open-profile-menu');
    }
});

// profile
$('.profile').click(function(e){
    e.preventDefault();
    $('.profile-menu').addClass('hidden').removeClass('open-profile-menu');
    $('.dashboard').hide();
    if ($('.show-menu').length == 1)
    {
        $('.left-menu').removeClass('show-menu').addClass('hidden');
    }
    $('#sidpan').attr('style', 'height: '+(parseInt($(window).height())-50)+'px');
    $('#submenu').simbioAJAX('./index.php?loadMenu=system');
    $('#mainContent').simbioAJAX(awb+'modules/system/app_user.php?changecurrent=true&action=detail');
})

// chart 1 : bar
function c1(widthdiv, prop)
{
    $.getJSON(awb+'?chart=barchart', (res) => {

	let loan = [];
        res[1].forEach(val => {
            loan.push(parseInt(val));
        });

	let retrn = [];
	res[2].forEach(val => {
	    retrn.push(parseInt(val));
	});

	let extd = [];
	res[3].forEach(val => {
	    extd.push(parseInt(val));
	});
	
	let maxnum = 0;
	let loan_total = loan.reduce((a, b) => a + b, 0);
	let retrn_total = retrn.reduce((a, b) => a + b, 0);
	let extd_total = extd.reduce((a, b) => a + b, 0);
	
	maxnum = Number(loan_total) + Number(retrn_total) + Number(extd_total);
	
        var container = document.getElementById('chart-c1');
        var data = {
            categories: res[0],
            series: [
                {
                    name: prop[1],
                    data: res[1]
                },
                {
                    name: prop[2],
                    data: res[2]
                },
                {
                    name: prop[3],
                    data: res[0]
                },
            ]
        };
        var options = {
            chart: {
                width: widthdiv,
                height: 450,
                title: prop[0],
                format: '1,000'
            },
            yAxis: {
                title: 'Jumlah',
            },
            xAxis: {
                title: 'Tanggal'
            },
            legend: {
                align: 'top'
            }
        };
        var theme = {
            series: {
                colors: [
                    '#83b14e', '#458a3f', '#295ba0', '#2a4175', '#289399',
                    '#289399', '#617178', '#8a9a9a', '#516f7d', '#dddddd'
                ]
            }
        };
        // For apply theme
        // tui.chart.registerTheme('myTheme', theme);
        // options.theme = 'myTheme';
        tui.chart.columnChart(container, data, options);
    });
}

// chart 2 : pie
function c2(widthdiv, prop)
{
    $.getJSON(awb+'?chart=doughchart', (res) => {
        var container = document.getElementById('chart-c2');
        var data = {
            categories: [],
            series: [
                {
                    name: prop[1],
                    data: res[0]
                },
                {
                    name: prop[2],
                    data: res[1]
                },
                {
                    name: prop[3],
                    data: res[2]
                },
                {
                    name: prop[4],
                    data: res[3]
                },
                {
                    name: prop[5],
                    data: res[4]
                }
            ]
        };
        var options = {
            chart: {
                width: widthdiv,
                height: widthdiv,
                title: prop[0],
                format: function(value, chartType, areaType, valuetype, legendName) {
                    return value;
                }
            },
            series: {
                radiusRange: ['20%', '100%'],
                showLabel: true,
                borderWidth: 5
            },
            tooltip: {
                suffix: ''
            },
            legend: {
                align: 'bottom'
            }
        };
        var theme = {
            series: {
                series: {
                    colors: [
                        '#83b14e', '#458a3f', '#295ba0', '#2a4175', '#289399',
                        '#289399', '#617178', '#8a9a9a', '#516f7d', '#dddddd'
                    ]
                },
                label: {
                    color: '#fff',
                    fontFamily: 'arial'
                }
            }
        };

        // For apply theme

        tui.chart.registerTheme('myTheme', theme);
        options.theme = 'myTheme';

        tui.chart.pieChart(container, data, options);
    });
}

// call function after document is ready
$(document).ready(function(){
    c1($('.c1')[0].offsetWidth, barchart);
    c2($('.c2')[0].offsetWidth, doughchart);
});
