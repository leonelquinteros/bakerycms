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
class MenusAjaxController extends MenusAppController
{
    public $name = 'MenusAjax';
    public $uses = array('Menus.MenusMenu');
    public $components = array('BakeryLogin');


    public function beforeFilter()
    {
        // Checks login
        $this->BakeryLogin->checkAdminLogin();

        $this->layout = false;
        $this->autoRender = false;
    }

    public function addMenuItem()
    {
        $data = $this->MenusMenu->create();

        $data['MenusMenu']['position'] = 9999;
        $data['MenusMenu']['name'] = $_POST['name'];
        $data['MenusMenu']['lang'] = $_POST['lang'];
        $data['MenusMenu']['title'] = $_POST['title'];
        $data['MenusMenu']['link'] = $_POST['link'];
        $data['MenusMenu']['parent_id'] = $_POST['parent_id'];

        $this->MenusMenu->save($data);
    }

    public function order() {
        foreach($_POST['items'] as $order => $id)
        {
            $menuData = $this->MenusMenu->findById($id);
            $menuData['MenusMenu']['position'] = $order;

            // Using find and save instead of a UPDATE query to run the callback method MenusMenu::afterSave()
            $this->MenusMenu->save($menuData);
        }
    }
}
