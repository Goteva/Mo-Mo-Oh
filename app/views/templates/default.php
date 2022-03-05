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
                </ul>

                <hr/>

                <?php if ($auth->logged()) { ?>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link  <?= ($view == 'admin.cards.list' ? 'active' : '') ?> px-3"
                               href="index.php?p=admin.escs.list">
                                <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="tasks-alt"
                                     role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                     class="feather">
                                    <g class="fa-group">
                                        <path fill="currentColor"
                                              d="M488.12 352H23.94A23.94 23.94 0 0 0 0 375.88V456a23.94 23.94 0 0 0 23.88 24h464.18A23.94 23.94 0 0 0 512 456.12V376a23.94 23.94 0 0 0-23.88-24zM464 432H48v-32h416zm24.12-240H23.94A23.94 23.94 0 0 0 0 215.88V296a23.94 23.94 0 0 0 23.88 24h464.18A23.94 23.94 0 0 0 512 296.12V216a23.94 23.94 0 0 0-23.88-24zM464 272H48v-32h416zm24.12-240H23.94A23.94 23.94 0 0 0 0 55.88V136a23.94 23.94 0 0 0 23.88 24h464.18A23.94 23.94 0 0 0 512 136.12V56a23.94 23.94 0 0 0-23.88-24zM464 112H48V80h416z"
                                              class="fa-secondary"></path>
                                        <path fill="currentColor"
                                              d="M48 80v32h304V80zm112 160H48v32h112zM48 432h240v-32H48z"
                                              class="fa-primary"></path>
                                    </g>
                                </svg>
                                Manages Animes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?= ($view == 'admin.categories.list' ? 'active' : '') ?> px-3"
                               href="index.php?p=admin.categories.list">
                                <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="th-list"
                                     role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                     class="feather">
                                    <g class="fa-group">
                                        <path fill="currentColor"
                                              d="M488 352H205.33a24 24 0 0 0-24 24v80a24 24 0 0 0 24 24H488a24 24 0 0 0 24-24v-80a24 24 0 0 0-24-24zm0-320H205.33a24 24 0 0 0-24 24v80a24 24 0 0 0 24 24H488a24 24 0 0 0 24-24V56a24 24 0 0 0-24-24zm0 160H205.33a24 24 0 0 0-24 24v80a24 24 0 0 0 24 24H488a24 24 0 0 0 24-24v-80a24 24 0 0 0-24-24z"
                                              class="fa-secondary"></path>
                                        <path fill="currentColor"
                                              d="M125.33 192H24a24 24 0 0 0-24 24v80a24 24 0 0 0 24 24h101.33a24 24 0 0 0 24-24v-80a24 24 0 0 0-24-24zm0-160H24A24 24 0 0 0 0 56v80a24 24 0 0 0 24 24h101.33a24 24 0 0 0 24-24V56a24 24 0 0 0-24-24zm0 320H24a24 24 0 0 0-24 24v80a24 24 0 0 0 24 24h101.33a24 24 0 0 0 24-24v-80a24 24 0 0 0-24-24z"
                                              class="fa-primary"></path>
                                    </g>
                                </svg>
                                Manages Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  <?= ($view == 'admin.statutes.list' ? 'active' : '') ?> px-3"
                               href="index.php?p=admin.statutes.list">
                                <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="badge" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="feather">
                                    <g class="fa-group">
                                        <path fill="currentColor"
                                              d="M512 256a88 88 0 0 0-57.09-82.41 88 88 0 0 0-116.5-116.5 88 88 0 0 0-164.82 0 88 88 0 0 0-116.5 116.5 88 88 0 0 0 0 164.82 88 88 0 0 0 116.5 116.5 88 88 0 0 0 164.82 0 88 88 0 0 0 116.5-116.5A88 88 0 0 0 512 256zm-122.23 55.42a55.67 55.67 0 0 1-78.36 78.37 55.68 55.68 0 0 1-110.82 0 55.68 55.68 0 0 1-78.36-78.37 55.69 55.69 0 0 1 0-110.84 55.68 55.68 0 0 1 78.36-78.37 55.68 55.68 0 0 1 110.82 0 55.68 55.68 0 0 1 78.36 78.37 55.69 55.69 0 0 1 0 110.84z"
                                              class="fa-secondary"></path>
                                        <path fill="currentColor"
                                              d="M389.77 311.42a55.67 55.67 0 0 1-78.36 78.37 55.68 55.68 0 0 1-110.82 0 55.68 55.68 0 0 1-78.36-78.37 55.69 55.69 0 0 1 0-110.84 55.68 55.68 0 0 1 78.36-78.37 55.68 55.68 0 0 1 110.82 0 55.68 55.68 0 0 1 78.36 78.37 55.69 55.69 0 0 1 0 110.84z"
                                              class="fa-primary"></path>
                                    </g>
                                </svg>
                                Manages Statutes
                            </a>
                        </li>
                    </ul>

                    <hr/>

                    <a class="nav-link px-3" href="index.php?p=users.logout">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="sign-out-alt" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="feather">
                            <path fill="currentColor"
                                  d="M160 217.1c0-8.8 7.2-16 16-16h144v-93.9c0-7.1 8.6-10.7 13.6-5.7l141.6 143.1c6.3 6.3 6.3 16.4 0 22.7L333.6 410.4c-5 5-13.6 1.5-13.6-5.7v-93.9H176c-8.8 0-16-7.2-16-16v-77.7m-32 0v77.7c0 26.5 21.5 48 48 48h112v61.9c0 35.5 43 53.5 68.2 28.3l141.7-143c18.8-18.8 18.8-49.2 0-68L356.2 78.9c-25.1-25.1-68.2-7.3-68.2 28.3v61.9H176c-26.5 0-48 21.6-48 48zM0 112v288c0 26.5 21.5 48 48 48h132c6.6 0 12-5.4 12-12v-8c0-6.6-5.4-12-12-12H48c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16h132c6.6 0 12-5.4 12-12v-8c0-6.6-5.4-12-12-12H48C21.5 64 0 85.5 0 112z"
                                  class=""></path>
                        </svg>
                        Logout
                    </a>

                <?php } else { ?>
                    <a class="nav-link <?= ($view == 'users.login' ? 'active' : '') ?> px-3"
                       href="index.php?p=users.login">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="sign-in-alt" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="feather">
                            <path fill="currentColor"
                                  d="M32 217.1c0-8.8 7.2-16 16-16h144v-93.9c0-7.1 8.6-10.7 13.6-5.7l141.6 143.1c6.3 6.3 6.3 16.4 0 22.7L205.6 410.4c-5 5-13.6 1.5-13.6-5.7v-93.9H48c-8.8 0-16-7.2-16-16v-77.7m-32 0v77.7c0 26.5 21.5 48 48 48h112v61.9c0 35.5 43 53.5 68.2 28.3l141.7-143c18.8-18.8 18.8-49.2 0-68L228.2 78.9c-25.1-25.1-68.2-7.3-68.2 28.3v61.9H48c-26.5 0-48 21.6-48 48zM512 400V112c0-26.5-21.5-48-48-48H332c-6.6 0-12 5.4-12 12v8c0 6.6 5.4 12 12 12h132c8.8 0 16 7.2 16 16v288c0 8.8-7.2 16-16 16H332c-6.6 0-12 5.4-12 12v8c0 6.6 5.4 12 12 12h132c26.5 0 48-21.5 48-48z"
                                  class=""></path>
                        </svg>
                        Login
                    </a>
                <?php } ?>
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