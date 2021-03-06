Bakery CMS
==========

Setup Apache
------------

- Enable Apache mod_rewrite
- Create a Virtual Host pointing to the repository root:

```
<VirtualHost *:80>
	ServerName bakerycms.local

	DocumentRoot "/path/to/bakerycms/"

	<Directory /path/to/bakerycms/>
	    Options FollowSymLinks
	    AllowOverride All
        Require all granted
	</Directory>
</VirtualHost>

```


Setup CMS
---------

- Clone or download into your web server's document root.
- Inside app/Config, copy *.php.default to *.php
- Step on 'app' dir:
```
$ cd path/to/bakerycms/app
```

- Run setup shell:

```
$ Console/cake setup all
```

- Follow the instructions and provide the necessary information.
- Done! Check your web browser.

Contribute
----------

- Use and test the CMS and/or libraries included.
- Implement new web applications based on Bakery CMS.
- Report issues/bugs/comments/suggestions on Github
- Fork and send me your pull requests with descriptions of modifications/new features



License
-------

BSD License

```
Copyright (c) 2013 Leonel Quinteros.
All rights reserved.


 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions are
 met:

 * Redistributions of source code must retain the above copyright
   notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above
   copyright notice, this list of conditions and the following disclaimer
   in the documentation and/or other materials provided with the
   distribution.
 * Neither the name of the  nor the names of its
   contributors may be used to endorse or promote products derived from
   this software without specific prior written permission.

 THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

```
