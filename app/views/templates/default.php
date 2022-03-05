<?php

use Core\Auth\DatabaseAuth;

$app = App::getInstance();
$auth = new DatabaseAuth($app->getDb());

?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="ESC">
    <title>Album example · Bootstrap v5.0</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/bootstrap/bootstrap-select.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="./css/momooh.css?v=<?= date('His') ?>" rel="stylesheet">

    <!-- Favicons -->
    <!-- <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180"> -->
    <!-- <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png"> -->
    <!-- <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png"> -->
    <!-- <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json"> -->
    <!-- <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3"> -->
    <!-- <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico"> -->

    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
</head>

<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">


    <a class="navbar-brand col-md-3 col-lg-2 me-0 p-0 px-3" href="#">
        <span style="font-size: 32px;">
            <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="ankh" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="fa-icon"><g class="fa-group"><path fill="currentColor" d="M296 256H24a24 24 0 0 0-24 24v32a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24v-32a24 24 0 0 0-24-24z" class="fa-secondary"></path><path fill="currentColor" d="M120 488a24 24 0 0 0 24 24h32a24 24 0 0 0 24-24V336h-80zM160 0C89.31 0 32 55.63 32 144c0 37.65 15.54 78 36.62 112h182.76C272.46 222 288 181.65 288 144 288 55.63 230.69 0 160 0zm0 244.87c-20.86-22.72-48-66.21-48-100.87 0-39.48 18.39-64 48-64s48 24.52 48 64c0 34.66-27.14 78.14-48 100.87z" class="fa-primary"></path></g></svg>
            Mo-Mo-Oh!
        </span>
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu"
             class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= ($view == 'cards.index' ? 'active' : '') ?>" aria-current="page"
                           href="index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-home" aria-hidden="true">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= ($view == 'cards.grid' ? 'active' : '') ?>"
                           href="index.php?p=cards.grid">
                            <svg width="16" height="16" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="dragon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="fa-icon"><g class="fa-group"><path fill="currentColor" d="M320 194.35v42.27A247.35 247.35 0 0 0 334.73 320H112c-14.25 0-21.39-17.23-11.31-27.31L192 224 18.32 255.82C2.36 258.1-6.57 238 5.81 227.68l117.4-116.34a64 64 0 0 1 77.06-4.59z" class="fa-secondary"></path><path fill="currentColor" d="M575.19 289.88l-100.66-50.31A48 48 0 0 1 448 196.65V160h64l28.09 22.63a32 32 0 0 0 22.63 9.37h31a32 32 0 0 0 28.62-17.69l14.31-28.62a32 32 0 0 0-3-33.51l-74.58-99.42A32 32 0 0 0 533.47 0H296a8 8 0 0 0-5.66 13.61L352 64l-59.58 24.8a8 8 0 0 0 0 14.31L352 128v108.58A215.61 215.61 0 0 0 448 416c-195.59 6.81-344.56 41-434.1 60.91A17.78 17.78 0 0 0 17.76 512h499.08c63.29 0 119.61-47.56 123-110.76a116.7 116.7 0 0 0-64.65-111.36zm-86-223.63l45.65 11.41c-2.75 10.91-12.47 18.89-24.13 18.26-12.97-.71-25.86-12.53-21.53-29.67z" class="fa-primary"></path></g></svg>
                            Cards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($view == 'cards.add' ? 'active' : '') ?>"
                           href="index.php?p=cards.add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            Add a new card
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?= $content ?>
        </main>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<script src="./js/bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="./js//bootstrap/bootstrap-select.min.js" crossorigin="anonymous"></script>
<script src="./js/momooh.js" crossorigin="anonymous"></script>





</body>

</html>