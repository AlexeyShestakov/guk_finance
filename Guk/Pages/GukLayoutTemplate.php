<?php

namespace Guk\Pages;

use Guk\Pages\Forms\FormsController;

class GukLayoutTemplate
{
/**
 * @param $content
 * @return string
 */
    static public function render($content){

    $cccn = \OLOG\Router::getCurrentControllerClassName();

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

    <link href="/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">-->

    <!-- Custom styles for this template -->
    <!--<link href="navbar.css" rel="stylesheet">-->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--<script src="../../assets/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>

    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <link href="/bower_components/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js"></script></head>

<body>

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
                <a class="navbar-brand" href="/guk">ГУК</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li <?php if ($cccn == \Guk\GukPages\ControllerForms::class){echo ' class="active" ';} ?> ><?= \Cebera\BT::a(FormsController::formsAction(1), 'Формы') ?></li>
                    <li <?php if ($cccn == Requests\ControllerRequests::class){echo ' class="active" ';} ?> ><?= \Cebera\BT::a(Requests\ControllerRequests::getFinRequestsUrl(), 'Заявки') ?></li>
                    <li <?php if ($cccn == \Guk\Pages\Terms\ControllerTerms::class){echo ' class="active" ';} ?> ><?= \Cebera\BT::a(\Guk\Pages\Terms\ControllerTerms::vocabulariesAction(1), 'Справочники') ?></li>
                    <li <?php if ($cccn == Reports\ControllerReports::class){echo ' class="active" ';} ?> class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Отчеты <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/guk/report/kbk">Для текущей формы по КБК</a></li>
                            <li><a href="/guk/report/current_form_payments">Платежи для текущей формы</a></li>
                            <li><a href="<?= Reports\ControllerReports::reportsByVuzAction(1); ?>">Заявки по ВУЗам для текущей формы</a></li>
                        </ul>
                    </li>
                    <li <?php if ($cccn == \Guk\Pages\Payments\Controller::class){echo ' class="active" ';} ?> ><a href="<?= \Guk\Pages\Payments\Controller::paymentsUrl(); ?>">Платежи</a></li>
                    <li <?php if ($cccn == \Guk\GukPages\ControllerDFO::class){echo ' class="active" ';} ?> ><a href="<?= \Guk\GukPages\ControllerDFO::dfoUrl(); ?>">ДФО</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Логинов Олег</a></li>
                    <li><a href="/">выйти</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <!-- Main component for a primary marketing message or call to action -->
    <!--<div class="jumbotron">-->

        <?= $content ?>

    <!--</div>-->

</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--<script src="/bower_components/bootstrap/dist/assets/js/ie10-viewport-bug-workaround.js"></script>-->
</body>
</html>
<?php

}
}