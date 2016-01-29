<?php

namespace Vuz\Pages;

class VuzLayoutTemplate
{
    static public function render($content){
        ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!--<link rel="icon" href="../../favicon.ico">-->

    <title>Navbar Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="navbar.css" rel="stylesheet">-->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<?php

$cccn = \OLOG\Router::getCurrentControllerClassName();

?>

<div class="container">

    <!-- Static navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/vuz">ВУЗ</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li <?php if ($cccn == \Guk\VuzPage\ControllerVuz::class){echo ' class="active" ';} ?> ><a href="/vuz">Заявки</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li <?php if ($cccn == \Vuz\Pages\Payments\Controller::class){echo ' class="active" ';} ?> ><a href="<?= \Vuz\Pages\Payments\Controller::paymentsPageUrl() ?>">Платежи</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li <?php if ($cccn == \Vuz\Pages\Expenses\Controller::class){echo ' class="active" ';} ?> ><a href="<?= \Vuz\Pages\Expenses\Controller::expensesUrl() ?>">Расходы</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><?php

                            $current_operator_user_id = \Guk\User::getCurrentOperatorUserId();
                            $current_operator_user_obj = \Guk\User::factory($current_operator_user_id);
                            echo $current_operator_user_obj->getLogin();

                            $current_vuz_id = \Vuz\Auth::getCurrentOperatorVuzId();
                            $current_vuz_obj = \Guk\Vuz::factory($current_vuz_id);
                            echo ' (' . $current_vuz_obj->getTitle() . ')';

                        ?></a></li>
                    <li><a href="/" title="Выйти"><span class="glyphicon glyphicon-log-out"></span></a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <!-- Main component for a primary marketing message or call to action -->
    <?php echo $content; ?>


</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>


<?php
    }
}