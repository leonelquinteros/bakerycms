<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

// Custom robots.txt route
Router::connect('/robots.txt', array('controller' => 'app', 'action' => 'robots_txt'));

// CMS basic routes.
Router::connect('/cms', array('controller' => 'cms', 'action' => 'index'));
Router::connect('/cms/configure', array('controller' => 'cms', 'action' => 'configure'));
Router::connect('/cms/login', array('controller' => 'cms', 'action' => 'login'));
Router::connect('/cms/logout', array('controller' => 'cms', 'action' => 'logout'));

// Language route.
Router::connect('/lang/*', array('controller' => 'lang', 'action' => 'change'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 *
 * When you creates a app/plugin/config/routes.php file and define routes in there, please follow this conventions:
 * - All CMS routes should start with /cms/[pluginName]/
 * - All other plugin routes should start with /[pluginName]/, so we can avoid routes collisions.
 * - Magic routes should be defined at the end of this section for each application.
 */
CakePlugin::routes();

// Pages 'magic' routes. Only at last.
Router::connect('/*', array('plugin' => 'Pages', 'controller' => 'pages_page', 'action' => 'page'));
