<?php if ($metingenInfo->aantalMetingen > 0) { ?>
    <br>
    <div class="viewList">
        <div class="panel panel-success">
            <div class="panel-heading">Gemiddelde van <?php echo $metingenInfo->aantalMetingen; ?> metingen</div>
            <div class="panel-body">
                <?php
                $template = array('table_open' => '<table id="resultatenLijstGemiddeldeTable" class="table table-striped table-hover table-responsive " border="0" cellpadding="4" cellspacing="0">');
                $this->table->set_template($template);
                $this->table->set_heading('', 'Juist', 'Fout', 'Duur', '', 'Juist', 'Fout', 'Duur');
                $this->table->add_row(

                    "<strong>Voormeting</strong>",
                    number_format((float)$metingenInfo->voormetingAantalJuist, 1, '.', ''),
                    number_format((float)$metingenInfo->voormetingAantalFout, 1, '.', ''),
                    $metingenInfo->voormetingDuur,

                    "<strong>Nameting</strong>",
                    number_format((float)$metingenInfo->nametingAantalJuist, 1, '.', ''),
                    number_format((float)$metingenInfo->nametingAantalFout, 1, '.', ''),
                    $metingenInfo->nametingDuur
                );
                echo $this->table->generate();
                ?>
            </div>
        </div>
    </div>
<?php } ?>

<br>
<div class="viewList">
    <div class="panel panel-success">
        <div class="panel-heading"><?php echo $metingenInfo->aantalMetingen; ?> gevonden metingen</div>
        <div class="panel-body">
            <?php
            $template = array('table_open' => '<table id="resultatenLijstTable" class="table table-striped table-hover table-responsive" border="0" cellpadding="4" cellspacing="0">');
            $this->table->set_template($template);
            $this->table->set_heading('Meting', 'Datum', 'Voormeting', 'Juist', 'Fout', 'Totaal', 'Tijd', 'Nameting', 'Juist', 'Fout', 'Totaal', 'Tijd');

            foreach ($metingen as $meting) {
                $this->table->add_row($meting->id,
                    substr($meting->voormetingDatum, 0, 10),
                    substr($meting->voormetingDatum, 10, 6) . "u",

                    $meting->voormeting->aantalJuist,
                    $meting->voormeting->aantalFout,
                    $meting->voormeting->aantalTotaal,
                    str_replace(":",",",substr($meting->voormeting->duur, 3, strlen(strtotime($meting->voormeting->duur)))) . "min",

                    substr($meting->nametingDatum, 10, 6) . "u",
                    $meting->nameting->aantalJuist,
                    $meting->nameting->aantalFout,
                    $meting->nameting->aantalTotaal,
                    str_replace(":",",",substr($meting->nameting->duur, 3, strlen(strtotime($meting->nameting->duur)))) . "min"
                );
            }
            echo $this->table->generate();
            ?>
        </div>
    </div>
</div>