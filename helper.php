<?php

if (!function_exists('view')) {
    function view($_content_path, $params = []) {
        extract($params);
        require __DIR__ . '/app/view/layout.php';
    }
}