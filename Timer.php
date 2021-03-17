<?php
class Timer {
    public $timer;

    function __construct($time){
        $this->timer = set_time_limit($time); 
    }
}