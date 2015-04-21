<?php

namespace RAPICache;

class Config {
    /**
     * Clef de l'API de lol
     * @var String
     */
    public static $key = null;
    
    /**
     * Temps de mise en cache des vues
     * @var Integer temps en seconde
     */
    public static $cache_time = 28800; // 8 heures
    
    /**
     * Repertoire où sont stockés les caches
     * @var String
     */
    public static $cache_dir = '/cache';
}