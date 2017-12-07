<script>
    //    variabelen
    var laatsteView = "lijst";
    var laatsteAjaxFunctie = "";

    var laatsteZoekfunctie = "";
    var laatsteZoekdata = "";

    // ajax functies
    function haal_metingenViaZoekfunctie(zoekfunctie, zoekdata) {
        $.ajax({
            type: "GET",
            url: site_url + "/resultaten/ajax_metingenViaZoekfunctie",
            data: {view: laatsteView, zoekfunctie: zoekfunctie, zoekdata: zoekdata},
            success: function (result) {
                $("#resultaat").html(result);
                laatsteAjaxFunctie = "haal_metingenViaZoekfunctie";
                laatsteZoekfunctie = zoekfunctie;
                laatsteZoekdata = zoekdata;
//                alert(laatsteAjaxFunctie+"\n\n"+ laatsteZoekfunctie +"\n\n"+ laatsteZoekdata +"\n\n");
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + "-- resultaten.php/haal_metingenViaZoekfunctie() --\n\n" + xhr.responseText);
            }
        });
    }

    // klik functies
    $(document).ready(function () {
        $("#toonLaatsteMeting").click(function () {
            $('#datum').val("");
            $('#aantal').val("");
            haal_metingenViaZoekfunctie("opAantal",1);
        });

        $("#toonAlleMetingen").click(function () {
            $('#datum').val("");
            $('#aantal').val("");
            haal_metingenViaZoekfunctie("alleMetingen",1);
        });

        $("#aantal").keyup(function () {
            $('#datum').val("");
            if ($(this).val() == "") {
                $("#resultaat").html("");
            } else {
                haal_metingenViaZoekfunctie("opAantal",$(this).val());
            }
        });

        $("#datum").keyup(function () {
            $('#aantal').val("");
            if ($(this).val() == "") {
                $("#resultaat").html("");
            } else {
                haal_metingenViaZoekfunctie("opDatum",$(this).val());
            }
        });

    });
</script>

<div id="defaultSearch" class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span id="switchViewMenu">
                <i id="switchCover" class="fa fa-th fa-lg switchCover" aria-hidden="true"></i>
                <i id="switchList" class="fa fa-list fa-lg switchList" aria-hidden="true"></i>
            </span>
            <span class="textShadowSmall" style="margin-left: -50px"><?php echo $aantalMetingen ?>
                voltooide metingen</span>
        </div>
        <div class="panel-body">
            <div class="form-group col-sm-6 panelPadding">
                <?php echo form_input(array('name' => 'aantal', 'id' => 'aantal', 'class' => 'form-control', 'placeholder' => 'Metingen op aantal (50)')); ?>
            </div>
            <div class="form-group col-sm-6 panelPadding">
                <?php echo form_button('toonLaatsteMeting', 'Laatste meting', 'id="toonLaatsteMeting" class="form-control btn btn-default"'); ?>
            </div>
            <div class="form-group col-sm-6 panelPadding">
                <?php echo form_input(array('name' => 'datum', 'id' => 'datum', 'class' => 'form-control', 'placeholder' => 'Metingen op datum (2017-12-22)')); ?>
            </div>
            <div class="form-group col-sm-6 panelPadding">
                <?php echo form_button('toonAlleMetingen', 'Alle metingen', 'id="toonAlleMetingen" class="form-control btn btn-primary"'); ?>
            </div>
        </div>
    </div>
</div>

<div class="container ">
    <div id="resultaat"></div>
</div>
