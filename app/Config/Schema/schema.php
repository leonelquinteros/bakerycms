<?php
class AppSchema extends CakeSchema {
    public $name = 'App';

    public function before($event = array()) {
        return true;
    }

    public function after($event = array()) {
    }

}
