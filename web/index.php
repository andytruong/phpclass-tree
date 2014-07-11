<!DOCTYPE html>
<?php list($title, $output) = include __DIR__ . '/resource.php'; ?>
<html lang="en">
    <head>
        <title><?= $title ?> PHPClassTree</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Andy Truong">

        <link href="http://bootswatch.com/slate/bootstrap.css" rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- <script src="./jstree/dist/jstree.min.js"></script> -->
        <!-- <link rel="stylesheet" href="./jstree/dist/themes/default/style.min.css" /> -->

        <style>
            .class.file { color: grey; }
            .class.shortname, .class.shortname a, .class.name { color: darkgreen; }
            .class.shortname { font-weight: bold; }
            .class.name, .class.name a { color: #999; }
            .method.scope { color: #ccc; }
            .method.name { color: #428BCA; }
            .param.hint, .param.hint a { color: brown; }
            .param.name { color: darkgreen; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <ul class="nav nav-pills pull-right">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <h3 class="text-muted"><?= $title ?></h3>
            </div>

            <div class="row marketing">
                <div class="col-lg-12" id="info-div">
                    <?= $output ?>
                </div>
            </div>
        </div> <!-- /container -->
    </body>
</html>
