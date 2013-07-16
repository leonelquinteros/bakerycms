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

class Maintenance
{
    /**
     * chMod()
     * Recursively sets permissions on directory/files
     */
    public static function chmod($path, $mode = 0777)
    {
        @chmod($path, $mode);

        if(is_dir($path))
        {
            $objects = scandir($path);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($path . "/" . $object))
                    {
                        self::chmod($path . "/" . $object, $mode);
                    }
                    else
                    {
                        @chmod( $path . "/" . $object, $mode);
                    }
                }
            }

            reset($objects);
        }
    }

    /**
     * checkCacheDirs()
     * Checks for cache's directories structure to be valid and attemps to create dirs.
     * Also tries to set write permissions on these dirs.
     */
    public static function checkCacheDirs()
    {
        if( !is_dir(ROOT . '/app/tmp/cache') )
        {
            @mkdir(ROOT . '/app/tmp/cache');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/cake') )
        {
            @mkdir(ROOT . '/app/tmp/cache/cake');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/media_gallery') )
        {
            @mkdir(ROOT . '/app/tmp/cache/media_gallery');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/models') )
        {
            @mkdir(ROOT . '/app/tmp/cache/models');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/persistent') )
        {
            @mkdir(ROOT . '/app/tmp/cache/persistent');
        }

        if( !is_dir(ROOT . '/app/tmp/cache/views') )
        {
            @mkdir(ROOT . '/app/tmp/cache/views');
        }

        self::chmod(ROOT . '/app/tmp/');
    }

    /**
     * checkMediaPublicDir()
     * Creates the public media directory.
     */
    public static function checkMediaDir()
    {
        if( !is_dir(ROOT . '/app/webroot/media') )
        {
            @mkdir(ROOT . '/app/webroot/media');
        }

        self::chmod(ROOT . '/app/webroot/media/');
    }


    /**
     * clearCache()
     * Deletes all known cache entries for File engine.
     */
    public static function clearCache()
    {
        // Global cache
        self::clearGlobalCache();

        // Media gallery cache
        self::clearMediaGalleryCache();

        // Models cache
        self::clearModelsCache();

        // Persistent cache
        self::clearPersistentCache();

        // Views cache
        self::clearViewsCache();
    }


    public static function clearGlobalCache()
    {
        $cacheDir = ROOT . DS . APP_DIR . DS . 'tmp/cache/';
        if(is_dir($cacheDir))
        {
            $cacheDirList = scandir( $cacheDir );

            foreach($cacheDirList as $cacheItem)
            {
                if($cacheItem != '.' && $cacheItem != '..' && is_file($cacheDir . $cacheItem) && !is_dir($cacheDir . $cacheItem))
                {
                    unlink($cacheDir . $cacheItem);
                }
            }
        }
    }


    /**
     * clearMediaGalleryCache()
     * Deletes all entries in Media Gallery's cache.
     */
    public static function clearMediaGalleryCache()
    {

        $mediaGalleryCacheDir = ROOT . DS . APP_DIR . DS . 'tmp/cache/media_gallery/';
        if(is_dir($mediaGalleryCacheDir))
        {
            $cacheDirList = scandir( $mediaGalleryCacheDir );

            foreach($cacheDirList as $cacheItem)
            {
                if($cacheItem != '.' && $cacheItem != '..' && is_file($mediaGalleryCacheDir . $cacheItem) && !is_dir($mediaGalleryCacheDir . $cacheItem))
                {
                    unlink($mediaGalleryCacheDir . $cacheItem);
                }
            }
        }
    }


    /**
     * clearModelsCache()
     * Deletes all entries in Models cache.
     */
    public static function clearModelsCache()
    {

        $modelsCacheDir = ROOT . DS . APP_DIR . DS . 'tmp/cache/models/';
        if(is_dir($modelsCacheDir))
        {
            $cacheDirList = scandir( $modelsCacheDir );

            foreach($cacheDirList as $cacheItem)
            {
                if($cacheItem != '.' && $cacheItem != '..' && is_file($modelsCacheDir . $cacheItem) && !is_dir($modelsCacheDir . $cacheItem))
                {
                    unlink($modelsCacheDir . $cacheItem);
                }
            }
        }
    }


    /**
     * clearPersistentCache()
     * Deletes all entries in Persistent cache.
     */
    public static function clearPersistentCache()
    {

        $persistentCacheDir = ROOT . DS . APP_DIR . DS . 'tmp/cache/persistent/';
        if(is_dir($persistentCacheDir))
        {
            $cacheDirList = scandir( $persistentCacheDir );

            foreach($cacheDirList as $cacheItem)
            {
                if($cacheItem != '.' && $cacheItem != '..' && is_file($persistentCacheDir . $cacheItem) && !is_dir($persistentCacheDir . $cacheItem))
                {
                    unlink($persistentCacheDir . $cacheItem);
                }
            }
        }
    }


    /**
     * clearViewsCache()
     * Deletes all entries in Views cache.
     */
    public static function clearViewsCache()
    {

        $viewsCacheDir = ROOT . DS . APP_DIR . DS . 'tmp/cache/views/';
        if(is_dir($viewsCacheDir))
        {
            $cacheDirList = scandir( $viewsCacheDir );

            foreach($cacheDirList as $cacheItem)
            {
                if($cacheItem != '.' && $cacheItem != '..' && is_file($viewsCacheDir . $cacheItem) && !is_dir($viewsCacheDir . $cacheItem))
                {
                    unlink($viewsCacheDir . $cacheItem);
                }
            }
        }
    }
}
