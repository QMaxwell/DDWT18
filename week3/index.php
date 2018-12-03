<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

/* Require composer autoloader */
require __DIR__ . '/vendor/autoload.php';

/* Include model.php */
include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week3', 'ddwt18', 'ddwt18');

/* Sets credentials */
$cred = set_cred('ddwt18', 'ddwt18');

/* Create Router instance */
$router = new \Bramus\Router\Router();

/* API mount */
$router->mount('/api', function() use ($router, $db, $cred) {
    /* Checks credentials */
    $router->before('GET|POST|PUT|DELETE', '/api/.*', function() use($cred){
        if (check_cred($cred)) {
            return [
                'type' => 'warning',
                'message' => 'You can not enter the database unauthenticated.'
            ];
        };
        exit();
    });
    /* GET for reading all series */
    $router->get('/series', function() use($db) {
        $series = get_series($db);
        http_content_type("application/json");
        echo json_encode($series);
    });
    /* POST for adding a series */
    $router->post('/series', function() use($db) {
        $feedback = add_serie($db, $_POST);
        http_content_type("application/json");
        echo json_encode($feedback);
    });
    /* GET for reading individual series */
    $router->get('/series/(\d+)', function($id) use($db) {
        $serie_info = get_serieinfo($db, $id);
        http_content_type("application/json");
        echo json_encode($serie_info);
    });
    /* POST for removing a series */
    $router->post('/series/(\d+)', function($id) use($db) {
        $feedback = remove_serie($db, $id);
        http_content_type("application/json");
        echo json_encode($feedback);
    });
    /* PUT for updating a series */
    $router->put('/series/(\d+)', function($id) use($db) {
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        $serie_info = $_PUT + ["serie_id" => $id];
        $feedback = update_serie($db, $serie_info);
        http_content_type("application/json");
        echo json_encode($feedback);
    });
    /* Fallback route: Error 404 */
    $router->set404(function() {
        header('HTTP/1.1 404 Not Found');
        echo "Page could not be found (ERROR 404). Please retry, or try again later!";
    });
});

/* Run the router */
$router->run();
