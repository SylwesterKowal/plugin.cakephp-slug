<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Slug',
    ['path' => '/slug'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
