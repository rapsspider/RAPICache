<?php

namespace ApiLOL;

class View {
    
    /**
     * Url de la vue
     * @var String
     */
    public $url;
    
    /**
     * Corp de la vue
     * @var String
     */
    public $body;
    
    /**
     * Constructeur par défaut
     * @param String $url Url de la vue
     */
    public function __construct($url) {
        $this->url = $url;
    }
    
    /**
     * Récupère le contenu de la vue en faisant appel à l'url
     */
    public function get() {
        if(!empty($this->url)) {
            $this->body = file_get_contents($this->url);
        }
    }
}