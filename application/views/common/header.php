<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page d'acceuil</title>

    <link rel="stylesheet" href="<?=base_url('/assets/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('/assets/css/fontawesome.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('/assets/css/bootstrap-theme.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('/assets/css/acceuil.css')?>">
    <link rel="stylesheet" href="<?=base_url('/assets/css/navbar.css')?>">
    <link rel="stylesheet" href="<?=base_url('/assets/css/tour_securite_codir.css')?>">
    <link rel="stylesheet" href="<?=base_url('/assets/css/datatables.min.css')?>">

    <script src="<?=base_url('/assets/js/jquery.min.js')?>"></script>
    <script src="<?=base_url('/assets/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('/assets/js/navbar_script.js') ?>"></script>
    <script src="<?=base_url('/assets/js/fontawesome.min.js') ?>"></script>
    <script src="<?=base_url('/assets/js/datatables.min.js') ?>"></script>
    <script src="<?=base_url('/assets/js/jquery.validate.min.js') ?>"></script>


    

</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
               <img src="<?=base_url('/assets/images/logo.png')?>" alt="logo" >
            </div>
           
            <div class="collapse navbar-collapse" id="main-menu" style="margin-bottom: 0px;">
                <ul class="nav navbar-nav">
                    <?php
                    $session=$this->session->userdata("id","email");
                    if (isset($session)):
                    ?>
                        <li><?=anchor("site/acceuil","Acceuil")?></li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" href="#">Fiche de visite <b class="caret"></b></a>
                            <ul class="dropdown-menu jqueryfadeIn">
                                <li class="dropdown-header"><h5>Tour de sécurité CODIR</h5></li>
                                <li><?=anchor("site/station_service","Station service")?></li>
                                <li><?=anchor("site/depot_aviation","Dépôt aviation")?></li>
                                <li><?=anchor("site/centre_emplisseur","Centre emplisseur")?></li>
                                <li class="dropdown-header"><h6>---------------------------------</h6> </li>
                                <li><a href="#">HSE chantier</a></li>
                                <li><a href="#">STL Bouteilles</a></li>
                                <li><a href="#">STL camion opéré</a></li>
                                <li><a href="#">Contrôle camion</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <?php redirect('authentification/login') ?>
                    <?php endif; ?> 
                </ul>    
                <ul class="nav navbar-nav navbar-right">
                    <li><?=anchor('authentification/logout',"Se déconnecter")?></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>