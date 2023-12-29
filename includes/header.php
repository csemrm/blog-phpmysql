<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="css/fonts.css"/>
        <link href="css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>

        <title><?php echo html_escape($title); ?></title>
    </head>
    <body>
        <div class="container-fluid bg-dark">

            <!-- skip links for screen readers -->
            <span class="sr-only">
                <a href="#posts">Go to main content</a>
                <a href="#sidebar">Go to sitebar</a>
            </span>

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="./">
                    <img src="./img/cihuatl.png" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="./">Home <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
                                $sql = "SELECT * FROM `category` WHERE navigation =1";

                                $categories = pdo($pdo, $sql)->fetchAll();

                                foreach ($categories as $key => $category) {
                                    ?>
                                    <li><a class="dropdown-item" href="category.php?catergoty_id=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li> 
                                <?php } ?>
                            </ul>
                        </li>

                    </ul>
                    <div class="form-inline my-2 my-lg-0 text-light">
                        <a href="#" data-toggle="modal" data-target="#searchModal" class="text-light">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-light">
                                    <h5 class="modal-title" id="searchModalLabel">Search</h5>
                                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="my-2">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon2" />
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <header class="container py-5" id="header">
            <h1><a href="index.php">Welcome PHP and MySQL Blog</a></h1>
            <p class="site-description">A life without limits</p>
        </header>

        
