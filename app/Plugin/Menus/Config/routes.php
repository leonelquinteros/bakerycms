<?php
Router::connect('/cms/menus', array('plugin' => 'menus', 'controller' => 'menus_cms', 'action' => 'index'));
Router::connect('/cms/menus/:action/*', array('plugin' => 'menus', 'controller' => 'menus_cms'));
Router::connect('/cms/menusajax/:action', array('plugin' => 'menus', 'controller' => 'menus_ajax'));
