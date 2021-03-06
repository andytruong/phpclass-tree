<!DOCTYPE html>
<?php list($title, $output) = include __DIR__ . '/resource.php'; ?>
<html lang="en">
    <head>
        <title><?= $title ?> PHPClassTree</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Andy Truong">

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
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
            li.scope-public { color: green; list-style-type: square; }
            li.scope-protected { color: orange; list-style-type: square; }
            li.scope-private { color: red; list-style-type: square; }
            .method.name { color: #428BCA; }
            .param.hint, .param.hint a { color: brown; }
            .param.name { color: darkgreen; }

            div.namespace { font-size: 0.85em; }
            div.namespace em.class.name { display: none; }
            div.namespace li.list-group-item:hover em.class.name:before { content: 'Return '; }
            div.namespace li.list-group-item:hover em.class.name { display: inline-block; }
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
