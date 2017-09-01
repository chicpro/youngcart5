<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './config.php';
require './dbconfig.php';

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    
    $mysqli = new mysqli($db['host'], $db['user'], $db['pass'], $db['dbname']);
    if($mysqli->connect_errno) {
        echo 'Connect Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }

    $mysqli->set_charset("utf8");
    
    return $mysqli;
};

$app->get('/item/{code}', function (Request $request, Response $response) {
    $code = trim($request->getAttribute('code'));

    $_tables = $this->settings['db']['table'];

    $sql = " select it_id, it_name, ca_id, ca_id2, ca_id3, it_explan, it_img1 from `{$_tables['item_table']}` where it_id = ? ";

    $stmt = $this->db->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param('s', $code);
    $stmt->execute();

    $row = array();
    $result = array();
    $meta = $stmt->result_metadata();
 
    while ($field = $meta->fetch_field()) {
        $params[] = &$row[$field->name];
    }
 
    call_user_func_array(array($stmt, 'bind_result'), $params);
 
    while ($stmt->fetch()) {
        foreach($row as $key => $val)
        {
            $c[$key] = $val;
        }

        $result = $c;
    }

    $stmt->close();

    return $response->withJson($result);
});

$app->run();