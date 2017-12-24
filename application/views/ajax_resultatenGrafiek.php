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
<div clas="container">
    <?php

    $min = array(array(2, 0.6), array(2, 4.4));
    $maxCount = $graphDataInfoA->aantalMetingen;
    if($graphDataInfoB->aantalMetingen > $maxCount){
        $maxCount = $graphDataInfoB->aantalMetingen;
    }

    $pc = new C_PhpChartX($graphDataArray, 'basic_chart');
    //$pc->set_data_renderer("js::sineRenderer");
    //$pc->set_data_renderer("js::ajaxDataRenderer");

    //$pc->set_defaults(array('seriesDefaults'=>array('showLine'=>false)));
    //$pc->set_defaults(array(
    //    'seriesDefaults'=>array('rendererOptions'=> array('barPadding'=>6,'barMargin'=>40)),
    //    'axesDefaults'=>array('showTickMarks'=>true,'tickOptions'=>array('formatString'=>'%d')),
    //    'stackSeries'=>true));
    //$pc->set_series_default(array('rendererOptions'=> array('smooth'=>true)));
    $grafiekTitel = 'Aantal juiste antwoorden <br><span style="font-size: 12px">Groep A - ' . $graphDataInfoA->aantalMetingen . ' metingen</span><br><span style="font-size: 12px">Groep B - ' . $graphDataInfoB->aantalMetingen . ' metingen</span>';
    $pc->set_title(array('text' => $grafiekTitel));

    $pc->add_series(array(
        'showMarker' => true,
        'showLine' => true,
        'color' => '#33cc33 ',
        'lineWidth' => 1,
        'label' => 'min'));
    $pc->add_series(array(
        'showMarker' => true,
        'showLine' => true,
        'color' => '#1f7a1f ',
        'lineWidth' => 1,
        'label' => 'max'));
    $pc->add_series(array(
        'showMarker' => true,
        'lineWidth' => 1,
        'color' => '#FF0000',
        'label' => 'min'));
    $pc->add_series(array(
        'showMarker' => true,
        'lineWidth' => 1,
        'color' => '#880000 ',
        'label' => 'max'));

    $pc->add_plugins(array('highlighter', 'cursor'));
    $pc->set_highlighter(array(
        'sizeAdjust' => 10,
        'tooltipLocation' => 'n',
        'useAxesFormatters' => false,
        'formatString' => '<div class="jqplot-highlighter"><span>Meting </span>%s: <strong>%s Juist</strong></div>'));
    $pc->set_cursor(array('show' => true, 'zoom' => true));
    $pc->set_axes(array(
        'xaxis' => array('min' => 0, 'numberTicks' => 1),
        'yaxis' => array('min' => 0)
    ));
    $pc->set_xaxes(array(
        'xaxis' => array(
            'tickInterval' => 1,
            'min' => 0,
            'max' => $maxCount,
            'autoscale' => true,
            'borderWidth' => 2,
            'borderColor' => '#999999',
            'tickOptions' => array('showGridline' => false))
    ));
    $pc->set_yaxes(array(
        'yaxis' => array(
            'numberTicks' => 11,
            'min' => 0,
            'max' => 10,
            'autoscale' => true,
            'borderWidth' => 2,
            'borderColor' => '#999999')
    ));
    $pc->set_legend(array(
        'show' => true,
        'location' => 'n',
        'placement' => 'outside',
        'yoffset' => 30,
        'rendererOptions' => array('numberRows' => 2),
        'labels' => array(' Groep A - Voormeting', ' Groep A - Nameting', ' Groep B - Voormeting', ' Groep B - Nameting')
    ));
    $pc->set_grid(array(
        'background' => 'lightyellow',
        'borderWidth' => 0,
        'borderColor' => '#000000',
        'shadow' => true,
        'shadowWidth' => 10,
        'shadowOffset' => 3,
        'shadowDepth' => 3,
        'shadowColor' => 'rgba(230, 230, 230, 0.07)'
    ));
    $pc->draw();

    ?>
</div>
<br>
<br>