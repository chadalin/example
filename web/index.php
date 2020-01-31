<?php
//FRONT CONTROLLER
//echo 'this is endex.php be location web/index.php';
require '../vendor/autoload.php';
//use App\Routing\Rout;
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/example/web/', ["App\Controllers\HomeControllers","index"]);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/example/web/user/{id:\d+}', ["App\Controllers\HomeControllers","user"]);
    // The /{title} suffix is optional
    $r->addRoute('GET', '/example/web/articles/{id:\d+}[/{title}]', ["App\Controllers\HomeControllers","articles"]);
    
    $r->addRoute('GET', '/example/web/users', ["App\Controllers\HomeControllers","users"]);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo  "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo  "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func($handler);
        break;
}





