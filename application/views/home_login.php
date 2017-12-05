<?php
// +----------------------------------------------------------
// | Aanmelden
// +----------------------------------------------------------
?>

<?php echo javascript("validator.js"); ?>

<div>
    <?php
    $dataOpen = array(
        'id' => 'myform',
        'name'=> 'myform',
        'data-toggle' => 'validator', 
        'role' => 'form');

    echo form_open('home/aanmelden', $dataOpen);

    echo '<div class="form-group">' . "\n";
    echo '<div class="input-group">'. "\n";
    echo '<span class="input-group-addon" ><i class="fa fa-user" style="width:25px" aria-hidden="true"></i></span>'. "\n";
    echo form_input(array(
        'name' => 'gebruikersnaam',
        'id' => 'gebruikersnaam',
        'size' => '30', 
        'class' => 'form-control',
        'placeholder' => 'gebruikersnaam',
        'required' => 'required', 
        'data-error' => 'Vul je gebruikersnaam in aub.')) . "\n";
    echo '</div>' . "\n";
    echo '<div class="help-block with-errors"></div>' . "\n";
    echo '</div>' . "\n";

    echo '<div class="form-group">' . "\n";
    echo '<div class="input-group">'. "\n";
    echo '<span class="input-group-addon"><i class="fa fa-unlock" style="width:25px" aria-hidden="true"></i></span>'. "\n";
    echo form_password(array(
        'name' => 'password', 
        'id' => 'password',  
        'class' => 'form-control',
        'placeholder' => 'paswoord',
        'required' => 'required', 
        'data-error' => 'Vul je paswoord in aub.')) . "\n";
    echo '</div>' . "\n";
    echo '<div class="help-block with-errors"></div>' . "\n";
    echo '</div>' . "\n";

    echo '<div class="form-group">' . "\n";
    $dataSubmit = array(
        'type' => 'submit', 
        'name' => 'mysubmit', 
        'value' => 'Login', 
        'class' => 'btn btn-primary size');
    echo form_submit($dataSubmit) . "\n";
    echo form_close();
    echo '</div>' . "\n";
    ?>
</div>