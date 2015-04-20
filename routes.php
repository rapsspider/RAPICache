<?php

use ApiLOL\Router;

// http://localhost/
Router::addRoute('/', 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?api_key={key}');

// http://localhost/api/euw/summoner/by-name/bluday
Router::addRoute(
    '/{region}/summoner_by_name/{summonerNames}', 
    'https://euw.api.pvp.net/api/lol/{region}/v1.4/summoner/by-name/{summonerNames}?api_key={key}'
);