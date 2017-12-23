<?php if ($metingenInfo->aantalMetingen > 0) { ?>
    <br>

    <div>
        <div class="viewList">
            <div class="panel panel-success" style="border-radius: 0px">
                <?php
                $textGemiddelde_metingOfMetingen = $metingenInfo->aantalMetingen . " metingen";
                if ($metingenInfo->aantalMetingen == 1) {
                    $textGemiddelde_metingOfMetingen = $metingenInfo->aantalMetingen . " meting";
                }
                ?>
                <div class="panel-heading" style="border-radius: 0px">Gemiddelde
                    van <?php echo $textGemiddelde_metingOfMetingen; ?></div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <h3>Groep A</h3>
                        <h6> <?php echo $metingenAInfo->aantalMetingenText; ?></h6>
                        <?php
                        $vooruitgangPercentage = ($metingenAInfo->nametingAantalJuist - $metingenAInfo->voormetingAantalJuist) * 10;

                        if ($metingenAInfo->aantalMetingen > 0) {
                            echo '<p><h5 style="color:green">Vooruitgang tussen voor- en nameting is <span style="font-weight: bold;">' . number_format((float)$vooruitgangPercentage, 2) . '%</span></h5></p><br>';

                            $template = array('table_open' => '<table id="resultatenLijstGemiddeldeTableA" class="table table-responsive table-condensed resultatenLijstGemiddeldeTable" border="0" cellpadding="4" cellspacing="0">');
                            $this->table->set_template($template);
                            $this->table->set_heading('Voormeting', '');
                            $this->table->add_row(
                                "Gemiddelde score",
                                number_format((float)$metingenAInfo->voormetingAantalJuist, 1, '.', '') . "/" . $metingenAInfo->voormetingAantalTotaal
                            );
                            $this->table->add_row(
                                "Gemiddelde duur",
                                $metingenAInfo->voormetingDuur
                            );
                            $fouteWoordenSting = "";
                            foreach ($metingenAInfo->voormetingFouteAntwoorden_AssocArray as $woord => $percentage) {
                                $fouteWoordenSting .= $percentage . "% " . $woord . "<br>";
                            }
                            $this->table->add_row(
                                "Voorkomende fouten:",
                                $fouteWoordenSting
                            );
                            echo $this->table->generate();

                            $this->table->clear();
                            $this->table->set_heading('Nameting', '');
                            $this->table->add_row(
                                "Gemiddelde score",
                                number_format((float)$metingenAInfo->nametingAantalJuist, 1, '.', '') . "/" . $metingenAInfo->nametingAantalTotaal
                            );
                            $this->table->add_row(
                                "Gemiddelde duur",
                                $metingenAInfo->nametingDuur
                            );
                            $fouteWoordenSting = "";
                            foreach ($metingenAInfo->nametingFouteAntwoorden_AssocArray as $woord => $percentage) {
                                $fouteWoordenSting .= $percentage . "% " . $woord . "<br>";
                            }
                            $this->table->add_row(
                                "Voorkomende fouten:", $fouteWoordenSting
                            );
                            echo $this->table->generate();
                        }
                        ?>
                        <br>
                    </div>

                    <div class="col-sm-6 gemTableB">
                        <h3>Groep B</h3>
                        <h6> <?php echo $metingenBInfo->aantalMetingenText; ?></h6>
                        <?php
                        $vooruitgangPercentage = ($metingenBInfo->nametingAantalJuist - $metingenBInfo->voormetingAantalJuist) * 10;

                        if ($metingenBInfo->aantalMetingen > 0) {
                            echo '<p><h5 style="color:green">Vooruitgang tussen voor- en nameting is <span style="font-weight: bold;">' . number_format((float)$vooruitgangPercentage, 2) . '%</span></h5></p><br>';

                            $template = array('table_open' => '<table id="resultatenLijstGemiddeldeTableB" class="table table-responsive table-condensed resultatenLijstGemiddeldeTable" border="0" cellpadding="4" cellspacing="0">');
                            $this->table->set_template($template);
                            $this->table->set_heading('Voormeting', '');
                            $this->table->add_row(
                                "Gemiddelde score",
                                number_format((float)$metingenBInfo->voormetingAantalJuist, 1, '.', '') . "/" . $metingenBInfo->voormetingAantalTotaal
                            );
                            $this->table->add_row(
                                "Gemiddelde duur",
                                $metingenBInfo->voormetingDuur
                            );
                            $fouteWoordenSting = "";
                            foreach ($metingenBInfo->nametingFouteAntwoorden_AssocArray as $woord => $percentage) {
                                $fouteWoordenSting .= $percentage . "% " . $woord . "<br>";
                            }
                            $this->table->add_row(
                                "Gemiddelde fouten:", $fouteWoordenSting
                            );
                            echo $this->table->generate();

                            $this->table->clear();
                            $this->table->set_heading('Nameting', '');
                            $this->table->add_row(
                                "Gemiddelde score",
                                number_format((float)$metingenBInfo->nametingAantalJuist, 1, '.', '') . "/" . $metingenBInfo->nametingAantalTotaal
                            );
                            $this->table->add_row(
                                "Gemiddelde duur",
                                $metingenBInfo->nametingDuur
                            );
                            $fouteWoordenSting = "";
                            foreach ($metingenBInfo->nametingFouteAntwoorden_AssocArray as $woord => $percentage) {
                                $fouteWoordenSting .= $percentage . "% " . $woord . "<br>";
                            }
                            $this->table->add_row(
                                "Gemiddelde fouten:", $fouteWoordenSting
                            );
                            echo $this->table->generate();
                        }
                        ?>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<br>

<?php if ($metingenInfo->aantalMetingen > 0) { ?>
    <div class="viewList">
        <div class="panel panel-success" style="border-radius: 0px">
            <?php
            $textGebaseerdOp_metingOfMetingen = "Gebaseerd op deze " . $metingenInfo->aantalMetingen . " metingen";
            if ($metingenInfo->aantalMetingen == 1) {
                $textGebaseerdOp_metingOfMetingen = "Gebaseerd op deze " . $metingenInfo->aantalMetingen . " meting";
            }
            ?>
            <div class="panel-heading" style="border-radius: 0px"><?php echo $textGebaseerdOp_metingOfMetingen; ?></div>
            <div class="panel-body">
                <div class="col-md-6">
                    <h3>Groep A</h3>
                    <h6> <?php echo $metingenAInfo->aantalMetingenText; ?></h6>
                    <br>

                    <?php
                    $template = array('table_open' => '<table id="resultatenLijstTable_A" class="table table-responsive table-condensed resultatenLijstTable" border="0" cellpadding="4" cellspacing="0">');
                    $this->table->set_template($template);
                    $this->table->set_heading('Nr', 'Meting', 'Uur', 'Score', 'Tijd');

                    foreach ($metingenA as $meting) {
                        $cell_metingInfoA = array(
                            'data' => substr($meting->voormetingDatum, 0, 10) . " | Meting door " . ucfirst($meting->naam) . " van " . ucfirst($meting->klas),
//                        'class' => 'myItalic',
                            'colspan' => 4
                        );

                        $this->table->add_row($meting->id,
                            $cell_metingInfoA
                        );

                        $this->table->add_row(
                            "",
                            "<strong>Voormeting</strong>",
                            substr($meting->voormetingDatum, 10, 6) . "u",
                            $meting->voormeting->aantalJuist . "/" . $meting->voormeting->aantalTotaal,
                            str_replace(":", ",", substr($meting->voormeting->duur, 3, strlen(strtotime($meting->voormeting->duur)))) . "min"
                        );
                        $string = "Fout:  ";
                        foreach ($meting->voormetingFouteAntwoorden as $item) {
                            $string .= $item->naam . ", ";
                        }
                        $cell_fouteWoordenA_voormeting = array(
                            'data' => substr($string, 0, -2),
                            'class' => 'myItalic',
                            'colspan' => 4
                        );
                        $this->table->add_row(
                            "",
                            $cell_fouteWoordenA_voormeting
                        );
                        $this->table->add_row(
                            "",
                            "<strong>Nameting</strong>",
                            substr($meting->nametingDatum, 10, 6) . "u",
                            $meting->nameting->aantalJuist . "/" . $meting->nameting->aantalTotaal,
                            str_replace(":", ",", substr($meting->nameting->duur, 3, strlen(strtotime($meting->nameting->duur)))) . "min"
                        );
                        $string = "Fout:  ";
                        foreach ($meting->nametingFouteAntwoorden as $item) {
                            $string .= $item->naam . ", ";
                        }
                        $cell_fouteWoordenA_nameting = array(
                            'data' => substr($string, 0, -2),
                            'class' => 'myItalic',
                            'colspan' => 4
                        );
                        $this->table->add_row(
                            "",
                            $cell_fouteWoordenA_nameting
                        );
                    }
                    if ($metingenAInfo->aantalMetingen > 0) {
                        echo $this->table->generate();
                    } ?>
                </div>
                <div class="col-md-6">
                    <h3>Groep B</h3>
                    <h6> <?php echo $metingenBInfo->aantalMetingenText; ?></h6>
                    <br>
                    <?php
                    $template = array('table_open' => '<table id="resultatenLijstTable_B" class="table table-responsive table-condensed resultatenLijstTable" border="0" cellpadding="4" cellspacing="0">');
                    $this->table->set_template($template);
                    $this->table->set_heading('Nr', 'Meting', 'Uur', 'Score', 'Tijd');

                    foreach ($metingenB as $meting) {
                        $cell_metingInfoB = array(
                            'data' => substr($meting->voormetingDatum, 0, 10) . " | Meting door " . ucfirst($meting->naam) . " van " . ucfirst($meting->klas),
//                        'class' => 'myItalic',
                            'colspan' => 4
                        );
                        $this->table->add_row($meting->id,
                            $cell_metingInfoB
                        );
                        $this->table->add_row(
                            "",
                            "<strong>Voormeting</strong>",
                            substr($meting->voormetingDatum, 10, 6) . "u",
                            $meting->voormeting->aantalJuist . "/" . $meting->voormeting->aantalTotaal,
                            str_replace(":", ",", substr($meting->voormeting->duur, 3, strlen(strtotime($meting->voormeting->duur)))) . "min"
                        );
                        $string = "Fout:  ";
                        foreach ($meting->voormetingFouteAntwoorden as $item) {
                            $string .= $item->naam . ", ";
                        }
                        $cell_fouteWoordenB_voormeting = array(
                            'data' => substr($string, 0, -2),
                            'class' => 'myItalic',
                            'colspan' => 4
                        );
                        $this->table->add_row(
                            "",
                            $cell_fouteWoordenB_voormeting
                        );
                        $this->table->add_row(
                            "",
                            "<strong>Nameting</strong>",
                            substr($meting->nametingDatum, 10, 6) . "u",
                            $meting->nameting->aantalJuist . "/" . $meting->nameting->aantalTotaal,
                            str_replace(":", ",", substr($meting->nameting->duur, 3, strlen(strtotime($meting->nameting->duur)))) . "min"
                        );
                        $string = "Fout:  ";
                        foreach ($meting->nametingFouteAntwoorden as $item) {
                            $string .= $item->naam . ", ";
                        }
                        $cell_fouteWoordenB_nameting = array(
                            'data' => substr($string, 0, -2),
                            'class' => 'MyItalic',
                            'colspan' => 4
                        );
                        $this->table->add_row(
                            "",
                            $cell_fouteWoordenB_nameting
                        );
                    }
                    if ($metingenBInfo->aantalMetingen > 0) {
                        echo $this->table->generate();
                    } ?>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>
<?php } ?>

