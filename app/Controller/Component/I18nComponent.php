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
class I18nComponent extends Component {
    public $components = array('Session', 'Cookie');
    public $supportedLanguages = array();

    /**
     * initialize()
     * Start function. Allways called at the begining of the request.
     */
    public function initialize(Controller $controller)
    {
        $this->supportedLanguages = explode(',', SUPPORTED_LANGUAGES);
        $this->setLanguage();
    }

    /**
     * setLanguage()
     * Detect and set the user language.
     * If there is not a language detected, will use the constant DEFAULT_SUPPORTED_LANGUAGE defined in app/config/bootstrap.php
     */
    public function setLanguage()
    {
        $lang = $this->Session->read('Config.language');
        if (empty($lang))
        {
            $cookieLang = $this->Cookie->read('lang');
            if( !empty($cookieLang) && in_array($cookieLang, $this->supportedLanguages) )
            {
                return $this->change($cookieLang);
            }

            $browserLang = $this->getBrowserLanguage();
            if( !empty($browserLang) && in_array($browserLang, $this->supportedLanguages) )
            {
                return $this->change($browserLang);
            }

            return $this->change(DEFAULT_SUPPORTED_LANGUAGE);
        }
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


    /**
     * getBrowserLanguage()
     * Gets the HTTP_ACCEPT_LANGUAGE browser language.
     *
     * @return (string) Browser language
     */
    public function getBrowserLanguage()
    {
        App::import('Lib', 'Language');

        if( !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) )
        {
            $browserLangs = split(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] );

            // Removes q=...
            $browserLang = split(';', $browserLangs[0]);

            // Removes _xx from ISO 639-1 codes
            $browserLang = split('-', $browserLang[0]);
            $browserLang = $browserLang[0];

            if( strlen($browserLang) == 2 )
            {
                // Converts to ISO 639-2 B code
                $browserLang = Language::convertLanguage($browserLang);
            }

            if( !empty($browserLang) )
            {
                return $browserLang;
            }
        }

        return false;
    }


    /**
     * change()
     * Used to set a new language for the application.
     *
     * @param (string) $lang
     */
    public function change($lang = '')
    {
        if ( !empty($lang) && in_array($lang, $this->supportedLanguages) ) {
            $lang = trim($lang);

            Configure::write('Config.language', $lang);
            $this->Session->write('Config.language', $lang);

            @$this->Cookie->write('lang', $lang, null, '+350 day');
            setlocale(LC_ALL, $lang);

        }
    }

}
