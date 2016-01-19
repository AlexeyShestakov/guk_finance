<?php

// ставим хидер с Content-Type по умолчанию для всех клиентов
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';

\Cebera\Router::match('@^/$@', array('\Guk\MainPage\ControllerMainPage', 'entryPageAction'), 0);

\Cebera\Router::match('@^/guk$@', array('\Guk\MainPage\ControllerMainPage', 'mainPageAction'), 0);

\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormsPageUrl() . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finFormsPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormAddPageUrl() . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finFormAddAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormRowUrl('(\d+)') . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finFormRowAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormColUrl('(\d+)') . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finFormColAction'), 0);
\Cebera\Router::match('@^/finform/(\d+)$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finFormPageAction'), 0);
\Cebera\Router::match('@^/guk/requests$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finRequestsPageAction'), 0);
\Cebera\Router::match('@^/guk/finrequest/(\d+)$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finRequestPageAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormParamsPageUrl('(\d+)') . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finFormParamsAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::getFinFormViewUrl('(\d+)') . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'finFormViewAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::requestPaymentsUrl('(\d+)') . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'requestPaymentsAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::paymentUrl('(\d+)') . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'paymentAction'), 0);
\Cebera\Router::match('@^' . \Guk\FinFormsPage\ControllerFinFormsPage::paymentsUrl() . '$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'paymentsAction'), 0);

\Cebera\Router::match('@^/guk/report/kbk$@', array('\Guk\FinFormsPage\ControllerFinFormsPage', 'kbkReportAction'), 0);

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
