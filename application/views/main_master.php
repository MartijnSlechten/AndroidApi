<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fonologisch Verkennen - Manon">
    <meta name="author" content="Axel Pauwels & Martijn Slechten">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/ic_boek.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/master/devicon.min.css">
    <!--    <link rel="stylesheet"-->
    <!--          href="https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css">-->

    <title>Fonologisch Verkennen</title>

    <!-- Bootstrap Core CSS -->
    <?php echo stylesheet("bootstrap.css"); ?>
    <!-- Custom CSS -->
    <?php echo stylesheet("heroic-features.css"); ?>
    <!-- Buttons CSS -->
    <?php echo stylesheet("buttons.css"); ?>
    <!-- my CSS -->
    <?php echo stylesheet("my.css"); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo javascript("jquery-3.1.0.min.js"); ?>
    <?php echo javascript("bootstrap.js"); ?>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.9.1/jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url() ?>"><i class="fa fa-home fa-lg" aria-hidden="true"></i></a>
        </div>

        <?php
        if (!$user == null) {
            switch ($user->level) {
                case 1:
                    //  USER LEVEL 1
                    break;
                case 5:
                    //  USER LEVEL 5
                    ?>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <a data-toggle="tooltip" title="Klassen" data-placement="bottom"
                                   href="<?php echo site_url('/home/klassen') ?>"> <?php echo '<i class="fa fa-graduation-cap" aria-hidden="true"></i> ' ?>
                                    Klassen toevoegen</a>
                            </li>
                            <li>
                                <a data-toggle="tooltip" title="Resultaten" data-placement="bottom"
                                   href="<?php echo site_url('/home/resultaten') ?>"> <?php echo '<i class="fa fa-bar-chart" aria-hidden="true"></i> ' ?>
                                    Resultaten bekijken</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a class="notClickable"
                                   href="<?php echo site_url('/home/profile') ?>"><?php echo '<i class="fa fa-user-circle-o" aria-hidden="true"></i> ' . ucfirst($user->voornaam) . " " . ucfirst($user->achternaam) ?></a>
                            </li>
                            <li>
                                <a data-toggle="tooltip" title="Logout" data-placement="bottom"
                                   href="<?php echo site_url('/home/afmelden') ?>"> <?php echo '<i class="fa fa-sign-out" aria-hidden="true"></i> ' ?></a>
                            </li>
                        </ul>

                    </div>
                    <?php
                    break;
            }
        }
        else {
            ?>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a data-toggle="tooltip" title="Login" data-placement="bottom"
                           href="<?php echo site_url('/home/login') ?>">  <?php echo '<i class="fa fa-sign-in" aria-hidden="true"></i> ' ?> </a>
                    </li>
                </ul>
            </div>
            <?php
        }
        ?>


    </div>
    <!-- /.container -->
</nav>
<!-- /Navigation -->

<!-- Page Content -->
<div class="container" style="padding-top: 75px">

    <div class="row">
        <div class="col-lg-12">
            <h3><?php echo $title; ?></h3>
        </div>
    </div>

    <!-- Page Features -->
    <?php if (isset($nobox)) { ?>
        <div class="row text-center">
            <?php echo $content; ?>
        </div>
    <?php }
    else { ?>
        <div class="row">
            <div class="col-lg-12 hero-feature">
                <div class="thumbnail" style="padding: 20px">
                    <div class="caption">
                        <p>
                            <?php echo $content; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- /.row -->
</div>
<div class="footer navbar-fixed-bottom"
     style="padding-top:10px; border-top:1px solid darkgray;background-color:lightgrey">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <p class="text-xs-center" style="font-size:12px">&copy; Copyright 2018 - Manon Franck. All rights
                    reserved.</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>
