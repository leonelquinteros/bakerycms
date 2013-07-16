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
class LanguageHelper extends AppHelper
{
    public $helpers = array('Html', 'Session');

    function name($langCode)
    {
        App::import('Lib', 'Language');

        return Language::name($langCode);
    }

    function flags()
    {
        $langs = explode(',', SUPPORTED_LANGUAGES);

        // Not showing anything if there's no options.
        if(count($langs) < 2)
        {
            return '';
        }

        $aFlags = '';

        foreach($langs as $lang)
        {
            $href = $this->Html->url("/lang/$lang");
            $img = $this->Html->url("/img/flags/$lang.gif");
            $aFlags[] = "<a class='langFlag' href='$href' title='" . $this->name($lang) . "'><img src='$img' alt='$lang' /></a>";
        }

        $out = implode(' ', $aFlags);

        return $out;
    }

    function flagsWithName()
    {
        $langs = explode(',', SUPPORTED_LANGUAGES);

        // Not showing anything if there's no options.
        if(count($langs) < 2)
        {
            return '';
        }

        $aFlags = '';

        foreach($langs as $lang)
        {
            $href = $this->Html->url("/lang/$lang");
            $img = $this->Html->url("/img/flags/$lang.gif");
            $aFlags[] = "<a class='langFlag' href='$href' title='" . $this->name($lang) . "'>" . $this->name($lang) . " &nbsp;&nbsp;&nbsp;<img src='$img' alt='$lang' /></a>";
        }

        $out = implode(' ', $aFlags);

        return $out;
    }

    /**
     * getLanguage()
     * Gets the actual configurated language
     *
     * @return (string) language code
     */
    public function getLanguage()
    {
        $lang = $this->Session->read('Config.language');

        if(!empty($lang))
        {
            return $lang;
        }
        else
        {
            return DEFAULT_SUPPORTED_LANGUAGE;
        }

    }

}
