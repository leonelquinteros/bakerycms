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
 * maintenanceShell
 * Shell class to run maintenance tasks. Most functionality will be in Maintenance Lib.
 *
 */
class MaintenanceShell extends AppShell
{
    /**
     * main()
     *
     * Main method for the shell.
     */
    public function main()
    {
        $this->out("\n");
        $this->hr();
        $this->out("This is the Bakery CMS maintenance shell");
        $this->hr();
        $this->out("Usage: \n> Console/cake maintenance all\nWill run all installed tasks.");
        $this->out("\n> Console/cake maintenance cache \nWill delete all known cache entries.");
        $this->hr(true);
    }

    /**
     * all()
     * Run all tasks.
     */
    public function all()
    {
        // Clear cache.
        $this->cache();
    }


    public function cache()
    {
        App::import('Lib', 'maintenance');

        $this->out('Deleting cache entries...');
        Maintenance::clearCache();

        $this->out('Done!');
        $this->hr(true);
    }

}
