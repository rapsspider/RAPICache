<?php

class Router {
    
    protected static $_routes = [];
    
    /**
     * Route la requete de façon a retourner la vue
     * à utiliser
     * @param String $url L'url à router.
     * @return la vue à afficher
     */
    public static function route($url) {
        $view = self::getView($url);
        
        // TBImproved
        if($view == null) return json_encode(['Code' => '404']);
        
        if(Cache::exist($view)) {
            Cache::setBody($view);
        } else {
            $view->get();
            Cache::save($view, Config::$cache_time);
        }
        
        return $view;
    }
    
    /**
     * Retourne l'url distante
     *
     * @param String $url
     * @return String $url
     */
    public static function getRoutedUrl($url) {
        $route = [
            'url' => false,
            'args' => []
        ];
        $matches = null;
        
        foreach(self::$_routes as $urlLocal => $urlDistant) {

            if($urlLocal == $url) {
                $route['url'] = $urlDistant;
                break;
            }
                
            $url_regex = preg_replace('%{([a-z_A-Z]+)}%', '(?P<$1>[\d\w]+)', $urlLocal, -1, $count);
            if($count > 0 && preg_match('%' . $url_regex . '%', $url, $matches)) {
                foreach($matches as $key => $value){
                    if(is_numeric($key)) 
                        unset($matches[$key]);
                }
                
                $route['url'] = $urlDistant;
                $route['args'] = $matches;
                break;
            }
        }
        
        return $route['url'] ? self::replace($route['url'], $route['args']) : null;
    }
    
    /**
     * Remplace les variables présentes dans l'url par les valeurs respectives
     * @param String $url
     * @param Array $args
     * @return String l'url avec les valeurs
     */
    public static function replace($url, $args) {
        $keys = ['/{key}/'];
        $values = [Config::$key];
        foreach($args as $var => $value) {
            $keys[] = '/{' . $var . '}/';
            $values[] = $value;
        }
        
        return preg_replace($keys, $values, $url);
    }
    
    /**
     * Retourne la vue associé à l'url demandé
     * @param String $url
     * @return View
     */
    public static function getView($url) {
        $url = self::getRoutedUrl($url);
        
        return new View($url);
    }
    
    /**
     * Renvoie le contenu de la page situé à l'adresse $urlDistant
     * correspondant à l'url utilisé $urlLocal.
     * @param String $urlLocal
     * @param String $urlDistant
     */
    public static function addRoute($urlLocal, $urlDistant) {
        self::$_routes[$urlLocal] = $urlDistant;
    }
    
}