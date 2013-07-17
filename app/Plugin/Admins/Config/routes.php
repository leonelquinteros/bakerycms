<?php
Router::connect('/cms/admins', array('plugin' => 'admins', 'controller' => 'admins_cms', 'action' => 'index'));
Router::connect('/cms/admins/:action/*', array('plugin' => 'admins', 'controller' => 'admins_cms'));
