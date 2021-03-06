<?php
Router::connect('/bakery/pages', array('plugin' => 'pages', 'controller' => 'pages_cms', 'action' => 'index'));
Router::connect('/bakery/pages/:action/*', array('plugin' => 'pages', 'controller' => 'pages_cms'));
Router::connect('/bakery/pagesajax/:action/*', array('plugin' => 'pages', 'controller' => 'pages_ajax'));

//Router::connect('/pages/*', array('plugin' => 'pages', 'controller' => 'pages_page', 'action' => 'page'));
Router::connect('/not-found', array('plugin' => 'pages', 'controller' => 'pages_page', 'action' => 'notFound'));

/**
 * Put the following line at the end of /app/config/routes.php to do the magic work.
 */
// Router::connect('/*', array('plugin' => 'pages', 'controller' => 'pages_page', 'action' => 'page'));
