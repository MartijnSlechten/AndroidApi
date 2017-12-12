<?php
require_once('phpChart/conf.php'); // this must be include in every page that uses phpChart.
?>

    <!--<script>-->
    <!--    sineRenderer = function() {-->
    <!--        var data = [[]];-->
    <!--        for (var i=0; i<13; i+=0.5) {-->
    <!--            data[0].push([i, Math.sin(i)]);-->
    <!--        }-->
    <!--        return data;-->
    <!--    };-->
    <!--</script>-->

    <!--<script>-->
    <!--    var ajaxDataRenderer = function(url, plot)-->
    <!--    {-->
    <!--        var ret = null;-->
    <!--        $.ajax({-->
    <!--            // have to use synchronous here, else returns before data is fetched-->
    <!--            async: false,-->
    <!--            url: site_url(),-->
    <!--            dataType:'json',-->
    <!--            success: function(data) {-->
    <!--                ret = data;-->
    <!--            }-->
    <!--        });-->
    <!--        return ret;-->
    <!--    };-->
    <!--</script>-->

    <div class="text-left" style="padding-left: 20px"><a
                href="<?php echo site_url('/resultaten/vanGrafiekTerugNaarLijst'); ?>">
            <button class="btn btn-default">Terug</button>
        </a></div>
<?php

$min = array(array(2, 0.6), array(2, 4.4));
$maxCount = count($graphDataArray[0]);

$pc2 = new C_PhpChartX($graphDataArray, 'basic_chart');
//$pc2->set_data_renderer("js::sineRenderer");
//$pc2->set_data_renderer("js::ajaxDataRenderer");

//$pc2->set_defaults(array('seriesDefaults'=>array('showLine'=>false)));
//$pc2->set_defaults(array(
//    'seriesDefaults'=>array('rendererOptions'=> array('barPadding'=>6,'barMargin'=>40)),
//    'axesDefaults'=>array('showTickMarks'=>true,'tickOptions'=>array('formatString'=>'%d')),
//    'stackSeries'=>true));
//$pc2->set_series_default(array('rendererOptions'=> array('smooth'=>true)));
$pc2->set_title(array('text' => 'Grafiek van ' . $maxCount . ' metingen'));

$pc2->add_series(array(
    'showMarker' => false,
    'showLine' => true,
    'color' => 'darkred',
    'lineWidth' => 0.5,
    'label' => 'min'));
$pc2->add_series(array(
    'showMarker' => false,
    'showLine' => true,
    'color' => 'darkgreen',
    'lineWidth' => 0.5,
    'label' => 'max'));
$pc2->add_series(array(
    'showMarker' => false,
    'lineWidth' => 2,
    'color' => 'red',
    'label' => 'min'));
$pc2->add_series(array(
    'showMarker' => false,
    'lineWidth' => 2,
    'color' => 'green',
    'label' => 'max'));

$pc2->add_plugins(array('highlighter', 'cursor'));
$pc2->set_highlighter(array(
    'sizeAdjust' => 10,
    'tooltipLocation' => 'n',
    'useAxesFormatters' => false,
    'formatString' => '<div class="jqplot-highlighter"><span>Meting </span>%s: <strong>%s Juist</strong></div>'));
$pc2->set_cursor(array('show' => true, 'zoom' => true));
$pc2->set_axes(array(
    'xaxis' => array('min' => 0, 'numberTicks' => 1),
    'yaxis' => array('min' => 0)
));
$pc2->set_xaxes(array(
    'xaxis' => array(
        'tickInterval' => 1,
        'min' => 0,
        'max' => $maxCount,
        'autoscale' => true,
        'borderWidth' => 2,
        'borderColor' => '#999999',
        'tickOptions' => array('showGridline' => false))
));
$pc2->set_yaxes(array(
    'yaxis' => array(
        'numberTicks' => 11,
        'min' => 0,
        'max' => 10,
        'autoscale' => true,
        'borderWidth' => 2,
        'borderColor' => '#999999')
));
$pc2->set_legend(array(
    'show' => true,
    'location' => 'n',
    'placement' => 'outside',
    'yoffset' => 30,
    'rendererOptions' => array('numberRows' => 2),
    'labels' => array(' Voormeting: Juist', ' Nameting: Juist', ' Voormeting: Gemiddeld', ' Nameting: Gemiddeld')
));
$pc2->set_grid(array(
    'background' => 'lightyellow',
    'borderWidth' => 0,
    'borderColor' => '#000000',
    'shadow' => true,
    'shadowWidth' => 10,
    'shadowOffset' => 3,
    'shadowDepth' => 3,
    'shadowColor' => 'rgba(230, 230, 230, 0.07)'
));
$pc2->draw();
?>