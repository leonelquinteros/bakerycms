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
 * Language
 * Library to work with language codes.
 */
class Language
{
    public static $codeConversionTable = array(
                                        'en' => 'eng',
                                        'es' => 'esp',
    );

    /**
     * convertLanguage()
     * Returns the 3 digits ISO 639-2 code for the given 2 digits ISO 639-1 code.
     *
     * @param (string) $browserLang 2 digits ISO 639-1 code
     * @return (string) 3 digits ISO 639-2 code
     */
    public static function convertLanguage($browserLang)
    {
        if(!empty(self::$codeConversionTable[$browserLang]))
        {
            return self::$codeConversionTable[$browserLang];
        }
        else
        {
            return $browserLang;
        }
    }


    /**
     * name()
     * Gets and translates the name of the language given by ISO 639-2 language code.
     *
     * @param $langCode
     * @return (string) Translated language name
     */
    public static function name($langCode) {
        switch($langCode) {
            case 'eng':
                return 'English';

            case 'esp':
                return 'Español';
        }

        return $langCode;
    }


    /**
     * getLanguages()
     * Returns an associative array with language codes as keys and language names as values.
     *
     * @return (array)
     */
    public static function getLanguages()
    {
        $languages = explode(',', SUPPORTED_LANGUAGES);

        $aLang = array();
        foreach($languages as $lang)
        {
            $aLang[$lang] = self::name($lang);
        }

        return $aLang;
    }

    /**
     * isSupported()
     * Returns TRUE if the language specified is supported. Otherwise returns FALSE.
     * @param (string) $lang Language code.
     */
    public function isSupported($lang)
    {
        if(strlen($lang) == 2)
        {
            $lang = self::convertLanguage($lang);
        }

        $langs = self::getLanguages();

        foreach($langs as $code => $name)
        {
            if($code == $lang)
            {
                return true;
            }
        }

        return false;
    }
}
