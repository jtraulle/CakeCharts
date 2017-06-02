<?php
/**
 * Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2017, Jean Traullé <jtraulle@users.noreply.github.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 */

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'CakeCharts',
    ['path' => '/cake-charts'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
