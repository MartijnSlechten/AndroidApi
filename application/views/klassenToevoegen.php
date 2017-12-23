<?php echo javascript("validator.js"); ?>
<div class="container" style="text-align: left">
    <div class="col-sm-6">
        <h4>Bestaande klassen</h4>
        <br>
        <?php
        foreach ($klassen as $klas) {
            echo '<p style="text-align: left">' . $klas->naam . '</p>' . "\n";
        }
        ?>
        <br>
    </div>
    <div class="col-sm-6">
        <h4>Klas toevoegen</h4>
        <br>
        <?php
        $dataOpen = array(
            'id' => 'myform',
            'name' => 'myform',
            'data-toggle' => 'validator',
            'role' => 'form');

        echo form_open('home/klasOpslaan', $dataOpen);

        echo '<div class="input-group">' . "\n";
        echo form_input(array(
                'name' => 'klasNaam',
                'id' => 'klasNaam',
                'size' => '30',
                'class' => 'form-control',
                'placeholder' => 'klasnaam',
                'required' => 'required',
                'data-error' => 'Vul een klasnaam in aub.')) . "\n";
        echo '<div class="help-block with-errors"></div>' . "\n";

        echo '<span class="input-group-btn">' . "\n";
        $dataSubmit = array(
            'type' => 'submit',
            'name' => 'mysubmit',
            'value' => 'Opslaan',
            'class' => 'btn btn-primary size');
        echo form_submit($dataSubmit) . "\n";
        echo '</span>' . "\n";
        echo '</div>' . "\n";

        echo form_close();
        ?>
    </div>


</div>