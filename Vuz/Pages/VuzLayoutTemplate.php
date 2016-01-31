<?php

namespace Vuz\Pages;

use Cebera\BT;

class VuzLayoutTemplate
{
    const MODAL_SELECT_TERM = 'MODAL_SELECT_TERM';

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
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

    <?php

    echo BT::beginModal(self::MODAL_SELECT_TERM, 'Выбор значения из словаря');
    echo BT::beginModalBody();

    echo '<div id="terms_list"></div>';

    echo BT::endModalBody();
    echo BT::endModal();

    ?>

    <script>
        $('#<?= self::MODAL_SELECT_TERM ?>').on('show.bs.modal', function (event) {
            var original_element = $(event.relatedTarget);
            var modal = $(this);
            var vocabulary_id = original_element.data('vocabulary_id');
            var terms_list = modal.find('#terms_list');
            var ajax_context_obj = {
                'terms_list': terms_list,
                'original_element': original_element
            };

            terms_list.html('');

            $.ajax({
                    method: "GET",
                    url: "/vuz/ajax/vocabulary/" + vocabulary_id + "/terms",
                    context: ajax_context_obj
                })
                .done(function( terms_json ) {
                    for(var i = 0; i < terms_json.length; i++){
                        var term_obj = terms_json[i];

                        var div = $('<div>' + term_obj.title + '</div>');
                        this.terms_list.append(div);

                        div.click({'term_obj': term_obj, 'original_element': this.original_element}, function(event){
                            //alert(event.data.term_obj.id);
                            $('#<?= self::MODAL_SELECT_TERM ?>').modal('hide');
                            event.data.original_element.html(event.data.term_obj.title);

                            var operation_code = event.data.original_element.data('operation_code');
                            var operation_context = event.data.original_element.data('context');

                            $.ajax({
                                    method: "POST",
                                    url: window.location.href,
                                    data: { operation_code: operation_code, term_id: event.data.term_obj.id, context: operation_context }
                                })
                                .done(function() {
                                });

                        });
                    }

                    //$('#' + this.details_table_htmlid).append(new_row_html);
                });


            //modal.find('.modal-body #terms_list').val(button.data('asdfg'));
        })
    </script>

</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>


<?php
    }
}