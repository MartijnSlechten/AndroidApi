<br>

<div class="viewList">
    <div class="panel panel-success">
        <div class="panel-heading">Gemiddelde van de <?php echo $metingenInfo->aantalMetingen; ?> gevonden metingen</div>
        <div class="panel-body">
            <?php
            $template = array('table_open' => '<table id="resultatenLijstGemiddeldeTable" class="table table-striped table-hover " border="0" cellpadding="4" cellspacing="0">');
            $this->table->set_template($template);
            $this->table->set_heading('Voormeting', 'Juist', 'Fout', 'Duur', 'Nameting', 'Juist', 'Fout', 'Duur');

            //    foreach ($metingenInfo as $meting) {

            //    $detailKnop= "<a href=''" . ' class="coverlink" data-id="' . $movie->id . '">' . '<i class="fa fa-info-circle fa-lg" aria-hidden="true" style="text-shadow: 0.5px 0.5px black"></i>' . '</a>' . "\n";
            //    if ($movie->download == 1) {
            //        $downloadLogo = '<i value="Download"><i class="fa fa-download fa-1x downloadActief" aria-hidden="true" style="text-shadow: 0.5px 0.5px black"></i>';
            //        $downloadNaam = $movie->naam . " (" . $movie->jaar . ").mp4";
            //        $downloadKnop = '<a class="downloadCount downloadCountEpisodes" data-id="'.$movie->id.'" href="ftp://ftpuser:ftpuser@movieserver.hopto.org/exthd/ftp/mp4/films/' . $downloadNaam . '">' . $downloadLogo . '</a>'. "\n";
            //    }else{
            //        $downloadKnop = '<a data-id="'.$movie->id.'" value="requestCount" class="requestCount requestCountEpisodes"><i class="fa fa-download fa-1x downloadInactief" aria-hidden="true" style="text-shadow: 0.5px 0.5px black"></i></a>';
            //    }

            //    $this->table->add_row($movie->naam, $movie->jaar, $detailKnop, $downloadKnop);
            $this->table->add_row(

                "",
                number_format((float)$metingenInfo->voormetingAantalJuist, 1, '.', ''),
                number_format((float)$metingenInfo->voormetingAantalFout, 1, '.', ''),

            $metingenInfo->voormetingDuur,
//                "x",
                "",
                number_format((float)$metingenInfo->nametingAantalJuist, 1, '.', ''),
                number_format((float)$metingenInfo->nametingAantalFout, 1, '.', ''),
                "x"
            //            $metingenInfo->nametingDuur,


            );
            //    }
            echo $this->table->generate();
            ?>
        </div>
    </div>
</div>

<br>

<div class="viewList">
    <div class="panel panel-success">
        <div class="panel-heading">Gevonden metingen</div>
        <div class="panel-body">
            <?php
            $template = array('table_open' => '<table id="resultatenLijstTable" class="table table-striped table-hover " border="0" cellpadding="4" cellspacing="0">');
            $this->table->set_template($template);
            $this->table->set_heading('Meting', 'Datum', 'Voormeting', 'Juist', 'Fout', 'Totaal', 'Tijd', 'Nameting', 'Juist', 'Fout', 'Totaal', 'Tijd');

            foreach ($metingen as $meting) {

//    $detailKnop= "<a href=''" . ' class="coverlink" data-id="' . $movie->id . '">' . '<i class="fa fa-info-circle fa-lg" aria-hidden="true" style="text-shadow: 0.5px 0.5px black"></i>' . '</a>' . "\n";
//    if ($movie->download == 1) {
//        $downloadLogo = '<i value="Download"><i class="fa fa-download fa-1x downloadActief" aria-hidden="true" style="text-shadow: 0.5px 0.5px black"></i>';
//        $downloadNaam = $movie->naam . " (" . $movie->jaar . ").mp4";
//        $downloadKnop = '<a class="downloadCount downloadCountEpisodes" data-id="'.$movie->id.'" href="ftp://ftpuser:ftpuser@movieserver.hopto.org/exthd/ftp/mp4/films/' . $downloadNaam . '">' . $downloadLogo . '</a>'. "\n";
//    }else{
//        $downloadKnop = '<a data-id="'.$movie->id.'" value="requestCount" class="requestCount requestCountEpisodes"><i class="fa fa-download fa-1x downloadInactief" aria-hidden="true" style="text-shadow: 0.5px 0.5px black"></i></a>';
//    }

//    $this->table->add_row($movie->naam, $movie->jaar, $detailKnop, $downloadKnop);
                $this->table->add_row($meting->id,
                    substr($meting->voormetingDatum, 0, 10),
                    substr($meting->voormetingDatum, 10, 6) . "u",

                    $meting->voormeting->aantalJuist,
                    $meting->voormeting->aantalFout,
                    $meting->voormeting->aantalTotaal,
                    $meting->voormeting->duur,

                    substr($meting->nametingDatum, 10, 6) . "u",
                    $meting->nameting->aantalJuist,
                    $meting->nameting->aantalFout,
                    $meting->nameting->aantalTotaal,
                    $meting->nameting->duur
                );
            }
            echo $this->table->generate();
            ?>
        </div>
    </div>
</div>
<!--<script>-->
<!--$(function(){-->
<!--  $("#resultatenLijstTable").tablesorter();-->
<!--});-->
<!--</script>-->