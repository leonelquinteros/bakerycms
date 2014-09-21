<?php
Router::connect('/bakery/products', array('plugin' => 'products', 'controller' => 'products_cms', 'action' => 'index'));
Router::connect('/bakery/products/categories', array('plugin' => 'products', 'controller' => 'categories_cms', 'action' => 'index'));
Router::connect('/bakery/products/categories/:action/*', array('plugin' => 'products', 'controller' => 'categories_cms'));
Router::connect('/bakery/products/:action/*', array('plugin' => 'products', 'controller' => 'products_cms'));

Router::connect('/products', array('plugin' => 'products', 'controller' => 'products', 'action' => 'index'));
Router::connect('/products/*', array('plugin' => 'products', 'controller' => 'products', 'action' => 'view'));
