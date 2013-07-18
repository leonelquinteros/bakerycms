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
class PagesSchema extends CakeSchema
{
    public $name = 'Pages';

    public function before($event = array()) {
        return true;
    }

    public function after($event = array()) {
    }

    public $pages_page_contents = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'pages_pages_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
        'content_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
        'content' => array('type' => 'longtext', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'PageId' => array('column' => 'pages_pages_id', 'unique' => 0)),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
    );

    public $pages_pages = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
        'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'index'),
        'lang' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3),
        'layout' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'seo_title' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'seo_keywords' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'seo_description' => array('type' => 'string', 'null' => true, 'default' => NULL),
        'publish' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
        'publish_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'URL' => array('column' => 'url', 'unique' => 0), 'PUBLISHED_URL' => array('column' => array('url', 'publish', 'publish_date'), 'unique' => 0)),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
    );
}
