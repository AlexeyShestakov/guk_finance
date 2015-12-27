<?php

// ставим хидер с Content-Type по умолчанию для всех клиентов
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';


\Cebera\Router::match('@^/$@', array('\Guk\MainPage\ControllerMainPage', 'mainPageAction'), 0);
\Cebera\Router::match('@^/finforms$@', array('\Guk\FormsPage\FormsPageController', 'formsPageAction'), 0);
\Cebera\Router::match('@^/finform/(\d+)$@', array('\Guk\FormsPage\FormsPageController', 'formPageAction'), 0);


// support for local php server (php -S) - tells local server to return static files
if (\Cebera\ConfWrapper::value('return_false_if_no_route', false)) {
    return false;
}


echo '404 Not found';
Cebera\Helpers::exit404();
