<?php
Router::connect('/bakery/products', array('plugin' => 'products', 'controller' => 'products_cms', 'action' => 'index'));
Router::connect('/bakery/products/:action/*', array('plugin' => 'products', 'controller' => 'products_cms'));
