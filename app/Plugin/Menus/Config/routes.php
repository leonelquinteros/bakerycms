<?php
Router::connect('/bakery/menus', array('plugin' => 'menus', 'controller' => 'menus_cms', 'action' => 'index'));
Router::connect('/bakery/menus/:action/*', array('plugin' => 'menus', 'controller' => 'menus_cms'));
Router::connect('/bakery/menusajax/:action', array('plugin' => 'menus', 'controller' => 'menus_ajax'));
