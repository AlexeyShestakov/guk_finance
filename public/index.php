<?php

session_start();

use Guk\Pages\Forms\FormsController;
use Vuz\Pages\Requests\RequestsController;

header('Content-Type: text/html; charset=utf-8'); // ставим хидер с Content-Type по умолчанию для всех клиентов

require_once __DIR__ . '/../vendor/autoload.php';

\OLOG\ConfWrapper::assignConfig(\AppConfig\Config::get());

try {
    \OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormColUrl('(\d+)') . '$@', array(\Guk\GukPages\ControllerForms::class, 'finFormColAction'), 0);
    \OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormParamsPageUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'finFormParamsAction'), 0);
    \OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormViewUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'finFormViewAction'), 0);

    \OLOG\Router::match2(\Guk\MainPage\ControllerMainPage::mainPageAction(2), 0);

    \OLOG\Router::match2(\Auth\Pages\ControllerAuth::authAction(2), 0);

    \OLOG\Router::match2(\Admin\Pages\Admin\ControllerAdmin::adminAction(2), 0);
    \OLOG\Router::match2(\Admin\Pages\Users\ControllerUsers::usersAction(2), 0);
    \OLOG\Router::match2(\Admin\Pages\Users\ControllerUsers::userAction(2, '(\d+)'), 0);
    \OLOG\Router::match2(\Admin\Pages\Vuzes\ControllerVuzes::vuzesAction(2), 0);

    \OLOG\Router::match2(\Guk\MainPage\ControllerMainPage::entryPageAction(2), 0);

    \OLOG\Router::match2(\Guk\Pages\ControllerAjax::ajaxAction(2, '(\w+)'), 0);

    \OLOG\Router::match2(FormsController::formsAction(2), 0);
    \OLOG\Router::match2(FormsController::formAction(2, '(\d+)'), 0);
    \OLOG\Router::match2(FormsController::finFormRowAction(2, '(\d+)'), 0);

//\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::docsUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'docsAction'), 0);
    \OLOG\Router::match2(FormsController::docsAction(2, '(\d+)'), 0);

    \OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::archiveUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'archiveAction'), 0);
    \OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::historyUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'historyAction'), 0);

    \OLOG\Router::match('@^' . \Guk\Pages\Requests\ControllerRequests::getFinRequestsUrl() . '$@', array(\Guk\Pages\Requests\ControllerRequests::class, 'finRequestsPageAction'), 0);
    \OLOG\Router::match('@^' . \Guk\Pages\Requests\ControllerRequests::getFinRequestUrl('(\d+)') . '$@', array('\Guk\Pages\Requests\ControllerRequests', 'finRequestPageAction'), 0);
    \OLOG\Router::match('@^' . \Guk\Pages\Requests\ControllerRequests::requestPaymentsUrl('(\d+)') . '$@', array('\Guk\Pages\Requests\ControllerRequests', 'requestPaymentsAction'), 0);

    \OLOG\Router::match('@^' . \Guk\Pages\Payments\Controller::paymentUrl('(\d+)') . '$@', array(\Guk\Pages\Payments\Controller::class, 'paymentAction'), 0);
    \OLOG\Router::match('@^' . \Guk\Pages\Payments\Controller::groupUrl('(\d+)') . '$@', array(\Guk\Pages\Payments\Controller::class, 'groupAction'), 0);
    \OLOG\Router::match('@^' . \Guk\Pages\Payments\Controller::paymentsUrl() . '$@', array(\Guk\Pages\Payments\Controller::class, 'paymentsAction'), 0);

    \OLOG\Router::match('@^' . \Guk\VuzPage\ControllerAjax::appendDetailUrl() . '$@', array('\Guk\VuzPage\ControllerAjax', 'appendDetailAction'), 0);
    \OLOG\Router::match('@^' . \Guk\VuzPage\ControllerAjax::saveDetailUrl() . '$@', array(\Guk\VuzPage\ControllerAjax::class, 'saveDetailAction'), 0);

    \OLOG\Router::match('@^/guk/report/kbk$@', array(\Guk\GukPages\ControllerForms::class, 'kbkReportAction'), 0);

    //\OLOG\Router::match('@^' . \Guk\Pages\Reports\ControllerReports::reportsByVuzUrl() . '$@', array(\Guk\Pages\Reports\ControllerReports::class, "reportsByVuzAction"), 0);
    \OLOG\Router::match2(\Guk\Pages\Reports\ControllerReports::reportsByVuzAction(2), 0);
    \OLOG\Router::match2(\Guk\Pages\Reports\ControllerReports::detailsForRequestAndFormRowAction(2, '(\d+)', '(\d+)'), 0);

    \OLOG\Router::match2(\Guk\Pages\Terms\ControllerTerms::vocabulariesAction(2), 0);
    \OLOG\Router::match('@^' . \Guk\Pages\Terms\ControllerTerms::vocabularyUrl('(\d+)') . '$@', array(\Guk\Pages\Terms\ControllerTerms::class, "vocabularyAction"), 0);

    \OLOG\Router::match('@^' . \Guk\GukPages\ControllerDFO::dfoUrl() . '$@', array(\Guk\GukPages\ControllerDFO::class, 'dfoAction'), 0);
    \OLOG\Router::match('@^' . \Guk\GukPages\ControllerDFO::dfoGenerateUrl() . '$@', array(\Guk\GukPages\ControllerDFO::class, 'dfoGenerateAction'), 0);

    \OLOG\Router::match2(\Vuz\Pages\Requests\RequestsController::requestsAction(2));

    \OLOG\Router::match('@^/vuz/finrequest/(\d+)$@', array(\Guk\VuzPage\ControllerVuz::class, 'finRequestEditAction'), 0);
    \OLOG\Router::match2(RequestsController::finRequestFillPageAction(2, '(\d+)'), 0);
    \OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestHistoryUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestHistoryAction'), 0);
    \OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestPrintUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestPrintAction'), 0);
    \OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestUploadUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestUploadAction'), 0);
    \OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::requestPaymentsPageUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'requestPaymentsPageAction'), 0);

    \OLOG\Router::match('@^' . \Vuz\Pages\Payments\Controller::paymentsPageUrl() . '$@', array(\Vuz\Pages\Payments\Controller::class, 'paymentsPageAction'), 0);
    \OLOG\Router::match('@^' . \Vuz\Pages\Payments\Controller::paymentUrl('(\d+)') . '$@', array(\Vuz\Pages\Payments\Controller::class, 'paymentPageAction'), 0);
    \OLOG\Router::match('@^' . \Vuz\Pages\Expenses\Controller::expensesUrl() . '$@', array(\Vuz\Pages\Expenses\Controller::class, 'expensesAction'), 0);

    \OLOG\Router::match2(\Vuz\Pages\ControllerAjax::vocabularyTermsAction(2, '(\d+)'), 0);

} catch (\Exception $exception) {
    error_log($exception->getMessage() . "\n" . $exception->getTraceAsString());
    $content_html = '';
    $content_html .= '<h1>Ошибка</h1>';
    $content_html .= '<p>' . $exception->getMessage() . '</p>';
    $content_html .= '<div style="margin:30px 0; font-size:18px;"><a href="#" onclick="history.back(); return false;"><span class="glyphicon glyphicon-arrow-left" style="font-size:16px;"></span> Назад</a></div>';
    $content_html .= '<pre>'. $exception->getTraceAsString() . '</pre>';

    \Auth\Pages\EntryTemplate::render($content_html);

    exit;
}

// support for local php server (php -S) - tells local server to return static files
if (\OLOG\ConfWrapper::value('return_false_if_no_route', false)) {
    return false;
}

echo '404 Not found';
Cebera\Helpers::exit404();
