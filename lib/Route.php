<?php

namespace RAPICache;

class Route {
    
    /**
     * Url to route
     * @var String
     */
    protected $_url;
    
    /**
     * Destination
     * @var String
     */
    protected $_destination;
    
    /**
     * List of arguments to replace
     * @var Array
     */
    protected $_arguments;
    
    /**
     * Default Constructor
     * @param String url Url to route
     * @param String destination url
     * @param Array  $args List of arguments to replace
     */
    public function __construct($url = null, $destination = null, Array $args = array()) {
        $this->_url         = $url;
        $this->_destination = $destination;
        $this->_arguments   = $args;
    }
    
    /**
     * Return TRUE if the $url match with this route.
     * @param string $url The url to compare.
     * @return bool|string False if the url don't match with this route.
     *                     The full url of the destination.
     */
    public function match($url) {
        
        if($this->_url == $url) {
            return $this->replace($this->_destination);
        } // else
        
        $count = $this->parseArguments($url);
        
        return $count > 0 ? $this->replace($this->_destination) : false;
    }
    
    /**
     * Create the regex using the url attribute.
     * If the url in argument don't match with the regex, then
     * 0 will be returned.
     * @param string $url The url to test with the regex.
     * @return int Number of arguments matched.
     */
    protected function parseArguments($url) {
        $count = 0;
        $args  = [];
        
        $url_regex = preg_replace('%{([a-z_A-Z]+)}%', '(?P<$1>[\d\w]+)', $this->_url, -1, $count);
        
        if($count > 0 && $count = preg_match('%' . $url_regex . '%', $url, $args)) {
            foreach($args as $key => $value){
                if(!is_numeric($key)) 
                    $this->_arguments[$key] = $value;
            }
        }
        
        return $count;
    }
    
    /**
     * Remplace les variables présentes dans l'url par les valeurs respectives
     * @param String $url
     * @param Array $args
     * @return String l'url avec les valeurs
     */
    public function replace($url) {
        $keys   = [];
        $values = [];
        
        foreach($this->_arguments as $var => $value) {
            $keys[] = '/{' . $var . '}/';
            $values[] = $value;
        }

        return preg_replace($keys, $values, $url);
    }    
}