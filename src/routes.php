<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/',  \ToDo\Controllers\SiteController::class . ':index');
$app->get('/active',  \ToDo\Controllers\SiteController::class . ':active');
$app->get('/login',  \ToDo\Controllers\SiteController::class . ':login');
$app->get('/completed',  \ToDo\Controllers\SiteController::class . ':completed');

$app->post('/api/addItem/{name}', 'ToDo\Controllers\AjaxController:addItem');
$app->post('/api/updateItem/{itemid}', 'ToDo\Controllers\AjaxController:updateItem');
$app->post('/api/updateList', 'ToDo\Controllers\AjaxController:updateList');
$app->delete('/api/deleteItem/{itemid}', 'ToDo\Controllers\AjaxController:deleteItem');
$app->delete('/api/deleteComplite', 'ToDo\Controllers\AjaxController:deleteComplite');

$app->get('/api/all', 'ToDo\Controllers\AjaxController:all');
$app->get('/api/active', 'ToDo\Controllers\AjaxController:active');
$app->get('/api/completed', 'ToDo\Controllers\AjaxController:completed');
//login-reg
$app->post('/api/registration/{login}/{passwd}/{confirm}', 'ToDo\Controllers\AjaxController:registration');
$app->post('/api/login/{login}/{passwd}', 'ToDo\Controllers\AjaxController:login');
$app->get('/api/namelogin', 'ToDo\Controllers\AjaxController:namelogin');
$app->post('/api/logout', 'ToDo\Controllers\AjaxController:logout');

