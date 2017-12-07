<script>
    //    variabelen
    var view = "lijst";
    var laatsteActie = "";
    var laatsteVariabele = "";

    // ajax functies
    function haal_laatsteMetingen(aantal) {
        $.ajax({
            type: "GET",
            url: site_url + "/resultaten/ajax_laatsteMetingen",
            data: {view: view, aantal: aantal},
            success: function (result) {
                $("#resultaat").html(result);
                laatsteActie = "haal_laatsteMetingen";
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + "-- resultaten.php/haal_laatsteMetingen() --\n\n" + xhr.responseText);
            }
        });
    }

    function haal_metingenOpDatum(datum) {
        $.ajax({
            type: "GET",
            url: site_url + "/resultaten/ajax_metingenOpDatum",
            data: {view: view, zoekstring: datum},
            success: function (result) {
                $("#resultaat").html(result);
                laatsteActie = "haal_metingenOpDatum";
                laatsteVariabele = datum;
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + "-- resultaten.php/haal_metingenOpDatum() --\n\n" + xhr.responseText);
            }
        });
    }

    //    klik functies
    $(document).ready(function () {
        $("#toonLaatsteMeting").click(function () {
            $('#datum').val("");
            haal_laatsteMetingen(1);
        });

        $("#datum").keyup(function () {
            if ($(this).val() == "") {
                $("#resultaat").html("");
            } else {
                haal_metingenOpDatum($(this).val());
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
            <span class="textShadowSmall" style="margin-left: -50px"><?php echo $aantalMetingen ?> voltooide metingen</span>
        </div>
        <div class="panel-body">
            <div class="form-group col-sm-4 panelPadding">
                <?php echo form_button('toonMeestPopulair', '<i class="fa fa-star-half-o" aria-hidden="true"></i> Populair', 'id="toonMeestPopulair" class="form-control btn btn-default"'); ?>
            </div>
            <div class="form-group col-sm-4 panelPadding">
                <?php echo form_button('toonMeestGedownload', '<i class="fa fa-download" aria-hidden="true"></i> Gedownload', 'id="toonMeestGedownload" class="form-control btn btn-default"'); ?>
            </div>
            <div class="form-group col-sm-4 panelPadding">
                <?php echo form_button('toonLaatsteMeting', '<i class="fa fa-file-video-o" aria-hidden="true"></i> Laatste meting', 'id="toonLaatsteMeting" class="form-control btn btn-default"'); ?>
            </div>

            <div class="form-group col-sm-4 panelPadding">
                <?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control', 'placeholder' => '- Zoek op titel -')); ?>
            </div>
            <div class="form-group col-sm-4 panelPadding">
                <?php echo form_input(array('name' => 'datum', 'id' => 'datum', 'class' => 'form-control', 'placeholder' => '- Zoek op datum -')); ?>
            </div>
            <div class="form-group col-sm-4 panelPadding">
                <?php echo form_button('toonAlles', 'Toon Alles', 'id="toonAlles" class="form-control btn btn-primary"'); ?>
            </div>
        </div>
    </div>
</div>

<div class="container ">
    <div id="resultaat"></div>
</div>
