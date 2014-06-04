<?php
/**
 * Bakery CMS
 *
 * @author: Leonel Quinteros <leonel.quinteros@gmail.com>, http://leonelquinteros.github.io
 * @copyright: Copyright (c) 2013, Leonel Quinteros. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 * the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name "Bakery CMS" nor the names of its contributors may be used to endorse or promote
 * products derived from this software without specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/**
 * setupShell
 * Shell class to do setup tasks.
 *
 */
class SetupShell extends AppShell
{
    /**
     * rmDir()
     * Recursively deletes a directory
     */
    public function rmDir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                    {
                        $this->rmDir($dir . "/" . $object);
                    }
                    else
                    {
                        unlink( $dir . "/" . $object);
                    }
                }
            }

            reset($objects);
            rmdir($dir);
        }
    }

    /**
     * chMod()
     * Recursively sets permissions on directory/files
     */
    public function chMod($path, $mode = 0777)
    {
        chmod($path, $mode);

        if(is_dir($path))
        {
            $objects = scandir($path);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($path . "/" . $object))
                    {
                        $this->chMod($path . "/" . $object, $mode);
                    }
                    else
                    {
                        chmod( $path . "/" . $object, $mode);
                    }
                }
            }

            reset($objects);
        }
    }

    /**
     * main()
     *
     * Main method for the shell.
     */
    public function main()
    {
        $this->out("\n");
        $this->hr();
        $this->out("This is the Bakery CMS setup shell");
        $this->hr();
        $this->out("Usage: \n> Console/cake setup all\nWill run all setup tasks.\n");
        $this->out("\n> Console/cake setup checkCacheDirs\nWill check and create all cache directories needed.\n");
        $this->out("\n> Console/cake setup checkMediaPublicDir\nWill check and create the public media upload directory.\n");
        $this->out("\n> Console/cake setup setWritePermissions\nWill set all needed permissions on dirs.\n");
        $this->out("\n> Console/cake setup coreConfig\nCreates core.php and bootstrap.php config files with starter configuration ready to work.\n");
        $this->out("\n> Console/cake setup setupDatabase\nWill set database configuration and creates the database if not exists.\n");
        $this->out("\n> Console/cake setup createSchema\nWill run the schema shell to create the schemas for each plugin installed.\n");
        $this->out("\n> Console/cake setup insertData\nWill create the basic setup data for yhe CMS website.\n");
        $this->hr(true);
    }

    /**
     * all()
     * Run all tasks.
     */
    public function all()
    {
        $this->checkCacheDirs();
        $this->checkMediaPublicDir();
        $this->setWritePermissions();
        $this->coreConfig();
        $this->setupDatabase();
        $this->createSchema();
        $this->insertData();
    }

    /**
     * setWritePermissions()
     * Attemps to set 777 permissions on writable directories.
     */
    public function setWritePermissions()
    {
        if( is_dir(ROOT . '/app/tmp') )
        {
            $this->out('Setting permissions on ROOT/app/tmp ...');
            $this->chMod(ROOT . '/app/tmp/');
        }

        if( is_dir(ROOT . '/app/webroot/media') )
        {
            $this->out('Setting permissions on ROOT/app/webroot/media ...');
            $this->chMod(ROOT . '/app/webroot/media/');
        }
    }

    /**
     * checkCacheDirs()
     * Checks for cache's directories structure to be valid and attemps to create dirs.
     */
    public function checkCacheDirs()
    {
        if( !is_dir(ROOT . '/app/tmp/cache') )
        {
            $this->out('Creating cache dir ...');
            mkdir(ROOT . '/app/tmp/cache');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/cake') )
        {
            $this->out('Creating cache/cake dir ...');
            mkdir(ROOT . '/app/tmp/cache/cake');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/persistent') )
        {
            $this->out('Creating cache/persistent dir ...');
            mkdir(ROOT . '/app/tmp/cache/persistent');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/models') )
        {
            $this->out('Creating cache/models dir ...');
            mkdir(ROOT . '/app/tmp/cache/models');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/views') )
        {
            $this->out('Creating cache/views dir ...');
            mkdir(ROOT . '/app/tmp/cache/views');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/media_gallery') )
        {
            $this->out('Creating cache/media_gallery dir ...');
            mkdir(ROOT . '/app/tmp/cache/media_gallery');
        }
    }

    /**
     * checkMediaPublicDir()
     * Creates the public media directory.
     */
    public function checkMediaPublicDir()
    {
        if( !is_dir(ROOT . '/app/webroot/media') )
        {
            $this->out('Creating media public dir ...');
            mkdir(ROOT . '/app/webroot/media');
        }
    }


    /**
     * coreConfig()
     * Dummy method to create core.php and bootstrap.php config files from template without modifications.
     */
    public function coreConfig()
    {
        $core = file_get_contents(ROOT . '/app/Config/core.php.default');
        file_put_contents(ROOT . '/app/Config/core.php', $core);

        $bootstrap = file_get_contents(ROOT . '/app/Config/bootstrap.php.default');
        file_put_contents(ROOT . '/app/Config/bootstrap.php', $bootstrap);
    }


    /**
     *  setupDatabase()
     *  Attemps to write database connection configuration and to create the database.
     */
    public function setupDatabase()
    {
        $this->out('Database setup');
        $this->hr();

        $dbHost = $this->in('DB Host: ');
        $dbName = $this->in('DB Name: ');
        $dbUser = $this->in('DB User: ');
        $dbPass = $this->in('DB Pass: ');

        $this->out('Attempting to create the database...');

        mysql_connect($dbHost, $dbUser, $dbPass);
        mysql_query('CREATE DATABASE IF NOT EXISTS ' . $dbName);
        mysql_query('CREATE DATABASE IF NOT EXISTS ' . $dbName . '_test');
        mysql_close();

        $this->out('Setting DB options in app/config/database.php');

        $tpl = file_get_contents(ROOT . '/app/Config/database.php.default');
        $tpl = str_replace('{dbHost}', $dbHost, $tpl);
        $tpl = str_replace('{dbName}', $dbName, $tpl);
        $tpl = str_replace('{dbUser}', $dbUser, $tpl);
        $tpl = str_replace('{dbPass}', $dbPass, $tpl);

        file_put_contents(ROOT . '/app/Config/database.php', $tpl);
    }

    /**
     * createSchema()
     * Runs all plugin schemas.
     */
    public function createSchema()
    {
        $this->out('Creating schemas ...');

        $installedPlugins = CakePlugin::loaded();

        foreach($installedPlugins as $pluginName)
        {
            if(is_file(CakePlugin::path($pluginName) . '/Config/Schema/schema.php'))
            {
                system('Console/cake schema create ' . $pluginName . '.' . $pluginName);
            }
        }
    }

    public function insertData()
    {
        $this->out('Configure CMS...');

        CakePlugin::loadAll();

        $this->out('Creating administrator user account');

        App::uses('AdminsAppModel', 'Admins.Model');
        App::uses('AdminsAdmin', 'Admins.Model');
        $admin = new AdminsAdmin();
        $adminData = $admin->create();

        $adminData['AdminsAdmin']['login'] = $this->in('Username: ');
        $adminData['AdminsAdmin']['pass'] = $this->in('Password: ');
        $adminData['AdminsAdmin']['name'] = $this->in('Full name: ');
        $adminData['AdminsAdmin']['email'] = $this->in('E-mail address for notifications: ');
        $adminData['AdminsAdmin']['super_admin'] = '1';

        $admin->save($adminData);


        $this->out('Creating (empty) home page');

        App::uses('PagesAppModel', 'Pages.Model');
        App::uses('PagesPage', 'Pages.Model');
        $page = new PagesPage();
        $pageData = $page->create();

        $pageData['PagesPage']['title'] = 'Home';
        $pageData['PagesPage']['url'] = 'home';
        $pageData['PagesPage']['layout'] = 'home';
        $pageData['PagesPage']['lang'] = DEFAULT_SUPPORTED_LANGUAGE;

        $page->save($pageData);
    }
}
