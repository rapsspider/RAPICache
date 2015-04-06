<?php

namespace ApiLOL;

class Cache {
    
    /**
     * Retourne le nom du fichier de cache.
     * @param View $view
     * @return String Le nom du fichier de cache
     */
    public static function getCacheFileName(View &$view) {
        return __APP_ROOT__ . Config::$cache_dir . '/' . md5($view->url) . '.cache';
    }

    /**
     * Retourne true si la vue exist en cache et que le
     * temps de cache n'est pas écoulé.
     * @param $view la vue à utiliser.
     * @return Boolean
     */
    public static function exist(View &$view, $time = -1) {
        if($time < 0) $time = Config::$cache_time;
        
        $file = Cache::getCacheFileName($view);
        return file_exists($file)
               && time() - filemtime($file) < $time;
    }
    
    /**
     * Met en cache la vue pendant un temps donnée
     * @param View $view La vue à mettre en cache
     * @param Integer $time Temps en secondes de la mise en cache
     * @return void
     */
    public static function save(View &$view) {
        $file = Cache::getCacheFileName($view);
        $f = fopen($file, 'x');
        fwrite($f, $view->body);
        fclose($f);
    }
    
    /**
     * Setter sur le contenu de la vue
     * @param View $view La vue à utiliser
     */
    public static function setBody(View &$view) {
        if(self::exist($view)) {
            $view->body = self::getCache($view);
        }
    }
    
    /**
     * Retourne le cache correspondant à la vue.
     * @param View $view La vue à utiliser
     * @return void
     */
    public static function getCache(View &$view) {
        return file_get_contents(Cache::getCacheFileName($view));
    }
    
}