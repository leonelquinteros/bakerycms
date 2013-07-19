<?php
Router::connect('/bakery/admins', array('plugin' => 'admins', 'controller' => 'admins_cms', 'action' => 'index'));
Router::connect('/bakery/admins/:action/*', array('plugin' => 'admins', 'controller' => 'admins_cms'));
