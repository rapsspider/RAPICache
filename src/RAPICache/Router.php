<?php

namespace RAPICache;

class Router {
    
    /**
     * Contient la liste des routes disponibles
     * Une route représente une url entrante et une url
     * de sortie
     * @var Array
     */
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
        $found       = false;
        $destination = null;
        
        for($i = 0; $i < count(self::$_routes) && !$found; $i++) {
            $destination = self::$_routes[$i]->match($url);
            if($destination != null) {
                $found = true;
            }
        }
        if($found) return $destination;
        
        return null;
    }
    
    /**
     * Retourne la vue associé à l'url demandé
     * @param string $url
     * @return View
     */
    public static function getView($url) {
        $url = self::getRoutedUrl($url);
        
        return new View($url);
    }
    
    /**
     * Renvoie le contenu de la page situé à l'adresse $urlDistant
     * correspondant à l'url utilisé $urlLocal.
     * @param string $urlLocal
     * @param string $urlDistant
     * @param array $args Arguments to set on the url.
     */
    public static function addRoute($urlLocal, $urlDistant, Array $args = array()) {
        self::$_routes[] = new Route($urlLocal,$urlDistant, $args) ;
    }
    
}