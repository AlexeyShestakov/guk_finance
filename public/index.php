<?php

// ставим хидер с Content-Type по умолчанию для всех клиентов
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';

\OLOG\ConfWrapper::assignConfig(\AppConfig\Config::get());

\OLOG\Router::match('@^/$@', array(\Guk\MainPage\ControllerMainPage::class, 'entryPageAction'), 0);

\OLOG\Router::match('@^/guk$@', array(\Guk\MainPage\ControllerMainPage::class, 'mainPageAction'), 0);

\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormsPageUrl() . '$@', array(\Guk\GukPages\ControllerForms::class, 'finFormsPageAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormAddPageUrl() . '$@', array('\Guk\GukPages\ControllerForms', 'finFormAddAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormRowUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'finFormRowAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormColUrl('(\d+)') . '$@', array(\Guk\GukPages\ControllerForms::class, 'finFormColAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::formUrl('(\d+)') . '$@', array(\Guk\GukPages\ControllerForms::class, 'finFormPageAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormParamsPageUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'finFormParamsAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::getFinFormViewUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'finFormViewAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::docsUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'docsAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::archiveUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'archiveAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerForms::historyUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerForms', 'historyAction'), 0);

\OLOG\Router::match('@^' . \Guk\GukPages\ControllerRequests::getFinRequestsUrl() . '$@', array(\Guk\GukPages\ControllerRequests::class, 'finRequestsPageAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerRequests::getFinRequestUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerRequests', 'finRequestPageAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerRequests::requestPaymentsUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerRequests', 'requestPaymentsAction'), 0);

\OLOG\Router::match('@^' . \Guk\Pages\Payments\Controller::paymentUrl('(\d+)') . '$@', array(\Guk\Pages\Payments\Controller::class, 'paymentAction'), 0);
\OLOG\Router::match('@^' . \Guk\Pages\Payments\Controller::groupUrl('(\d+)') . '$@', array(\Guk\Pages\Payments\Controller::class, 'groupAction'), 0);
\OLOG\Router::match('@^' . \Guk\Pages\Payments\Controller::paymentsUrl() . '$@', array(\Guk\Pages\Payments\Controller::class, 'paymentsAction'), 0);

\OLOG\Router::match('@^' . \Guk\VuzPage\ControllerAjax::appendDetailUrl() . '$@', array('\Guk\VuzPage\ControllerAjax', 'appendDetailAction'), 0);
\OLOG\Router::match('@^' . \Guk\VuzPage\ControllerAjax::saveDetailUrl() . '$@', array(\Guk\VuzPage\ControllerAjax::class, 'saveDetailAction'), 0);

\OLOG\Router::match('@^/guk/report/kbk$@', array(\Guk\GukPages\ControllerForms::class, 'kbkReportAction'), 0);

\OLOG\Router::match('@^' . \Guk\GukPages\ControllerReports::reportsByVuzUrl() . '$@', array(\Guk\GukPages\ControllerReports::class, "reportsByVuzAction"), 0);

\OLOG\Router::match('@^' . \Guk\Pages\Terms\ControllerTerms::vocabulariesUrl() . '$@', array(\Guk\Pages\Terms\ControllerTerms::class, "vocabulariesAction"), 0);
\OLOG\Router::match('@^' . \Guk\Pages\Terms\ControllerTerms::vocabularyUrl('(\d+)') . '$@', array(\Guk\Pages\Terms\ControllerTerms::class, "vocabularyAction"), 0);

\OLOG\Router::match('@^' . \Guk\GukPages\ControllerDFO::dfoUrl() . '$@', array(\Guk\GukPages\ControllerDFO::class, 'dfoAction'), 0);
\OLOG\Router::match('@^' . \Guk\GukPages\ControllerDFO::dfoGenerateUrl() . '$@', array(\Guk\GukPages\ControllerDFO::class, 'dfoGenerateAction'), 0);

\OLOG\Router::match('@^/vuz$@', array(\Guk\VuzPage\ControllerVuz::class, 'vuzPageAction'), 0);
\OLOG\Router::match('@^/vuz/finrequest$@', array(\Guk\VuzPage\ControllerVuz::class, 'finRequestAddAction'), 0);
\OLOG\Router::match('@^/vuz/finrequest/(\d+)$@', array(\Guk\VuzPage\ControllerVuz::class, 'finRequestEditAction'), 0);
\OLOG\Router::match('@^/vuz/finrequest/(\d+)/fill$@', array(\Guk\VuzPage\ControllerVuz::class, 'finRequestFillPageAction'), 0);
\OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestHistoryUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestHistoryAction'), 0);
\OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestPrintUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestPrintAction'), 0);
\OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestUploadUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestUploadAction'), 0);
\OLOG\Router::match('@^' . \Guk\VuzPage\ControllerVuz::requestPaymentsPageUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'requestPaymentsPageAction'), 0);

\OLOG\Router::match('@^' . \Vuz\Pages\Payments\Controller::paymentsPageUrl() . '$@', array(\Vuz\Pages\Payments\Controller::class, 'paymentsPageAction'), 0);
\OLOG\Router::match('@^' . \Vuz\Pages\Payments\Controller::paymentUrl('(\d+)') . '$@', array(\Vuz\Pages\Payments\Controller::class, 'paymentPageAction'), 0);
\OLOG\Router::match('@^' . \Vuz\Pages\Expenses\Controller::expensesUrl() . '$@', array(\Vuz\Pages\Expenses\Controller::class, 'expensesAction'), 0);


// support for local php server (php -S) - tells local server to return static files
if (\OLOG\ConfWrapper::value('return_false_if_no_route', false)) {
    return false;
}


echo '404 Not found';
Cebera\Helpers::exit404();
