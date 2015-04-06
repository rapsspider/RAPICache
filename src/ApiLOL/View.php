<?php

class View {
    
    public $url;
    
    public $body;
    
    public function __construct($url) {
        $this->url = $url;
    }
    
    public function get() {
        if(!empty($this->url)) {
            $this->body = file_get_contents($this->url);
        }
    }
}