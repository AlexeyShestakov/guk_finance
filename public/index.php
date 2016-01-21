<?php

// ставим хидер с Content-Type по умолчанию для всех клиентов
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';

\Cebera\Router::match('@^/$@', array('\Guk\MainPage\ControllerMainPage', 'entryPageAction'), 0);

\Cebera\Router::match('@^/guk$@', array('\Guk\MainPage\ControllerMainPage', 'mainPageAction'), 0);

\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::getFinFormsPageUrl() . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'finFormsPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::getFinFormAddPageUrl() . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'finFormAddAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::getFinFormRowUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'finFormRowAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::getFinFormColUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'finFormColAction'), 0);
\Cebera\Router::match('@^/finform/(\d+)$@', array('\Guk\GukPages\ControllerFinFormsPage', 'finFormPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::getFinFormParamsPageUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'finFormParamsAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::getFinFormViewUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'finFormViewAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::docsUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'docsAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::archiveUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'archiveAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerFinFormsPage::historyUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerFinFormsPage', 'historyAction'), 0);

\Cebera\Router::match('@^' . \Guk\GukPages\ControllerRequests::getFinRequestsUrl() . '$@', array('\Guk\GukPages\ControllerRequests', 'finRequestsPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerRequests::getFinRequestUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerRequests', 'finRequestPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerRequests::requestPaymentsUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerRequests', 'requestPaymentsAction'), 0);

\Cebera\Router::match('@^' . \Guk\GukPages\ControllerPayments::paymentUrl('(\d+)') . '$@', array('\Guk\GukPages\ControllerPayments', 'paymentAction'), 0);
\Cebera\Router::match('@^' . \Guk\GukPages\ControllerPayments::paymentsUrl() . '$@', array('\Guk\GukPages\ControllerPayments', 'paymentsAction'), 0);

\Cebera\Router::match('@^/guk/report/kbk$@', array('\Guk\GukPages\ControllerFinFormsPage', 'kbkReportAction'), 0);

\Cebera\Router::match('@^/vuz$@', array('\Guk\VuzPage\ControllerVuz', 'vuzPageAction'), 0);
\Cebera\Router::match('@^/vuz/finrequest$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestAddAction'), 0);
\Cebera\Router::match('@^/vuz/finrequest/(\d+)$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestEditAction'), 0);
\Cebera\Router::match('@^/vuz/finrequest/(\d+)/fill$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestFillPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestHistoryUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestHistoryAction'), 0);
\Cebera\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestPrintUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestPrintAction'), 0);
\Cebera\Router::match('@^' . \Guk\VuzPage\ControllerVuz::getFinRequestUploadUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'finRequestUploadAction'), 0);
\Cebera\Router::match('@^' . \Guk\VuzPage\ControllerVuz::requestPaymentsPageUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'requestPaymentsPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\VuzPage\ControllerVuz::paymentsPageUrl() . '$@', array('\Guk\VuzPage\ControllerVuz', 'paymentsPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\VuzPage\ControllerVuz::paymentUrl('(\d+)') . '$@', array('\Guk\VuzPage\ControllerVuz', 'paymentPageAction'), 0);


// support for local php server (php -S) - tells local server to return static files
if (\Cebera\ConfWrapper::value('return_false_if_no_route', false)) {
    return false;
}


echo '404 Not found';
Cebera\Helpers::exit404();
