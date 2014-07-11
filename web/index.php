<!DOCTYPE html>
<html lang="en">
    <head>
        <title>PHPClassTree</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Andy Truong">

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./jstree/dist/themes/default/style.min.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- <script src="./jstree/dist/jstree.min.js"></script> -->

        <style>
            .class.file { color: grey; }
            .class.shortname, .class.name { color: red; }
            .class.name, .class.name a { color: #999; }
            .method.scope { color: blue; }
            .method.name { color: #428BCA; }
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
                <h3 class="text-muted">PHPClassTree</h3>
            </div>

            <div class="row marketing">
                <div class="col-lg-12" id="info-div">
                    <?php require_once __DIR__ . '/resource.php' ?>
                </div>
            </div>
        </div> <!-- /container -->
    </body>
</html>
