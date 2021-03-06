<?php

$this->router->get('/', function() {
    view('main');
});

$this->router->get('/board', 'BoardController@index');
$this->router->post('/board', 'BoardController@register');
$this->router->get('/board/([0-9]*)', 'BoardController@getBoard');
$this->router->delete('/board/([0-9]*)', 'BoardController@delete');
$this->router->patch('/board/([0-9]*)', 'BoardController@update');


$this->router->get('/board/([0-9]*)/([0-9]*)', 'BoardController@getBoard');




