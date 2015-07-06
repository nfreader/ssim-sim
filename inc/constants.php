<?php

define('FUEL_BASE_COST',75);
define('COMMOD_DISTRIBUTION',.3);
define('COMMOD_COST_MODIFIER',500);

date_default_timezone_set('UTC');

define('GAME_VERSION', '0.1');
define('YEAR_OFFSET', 178); //Years to offset date() displays by. Just for fun.
define('GAME_YEAR', date('Y') + YEAR_OFFSET);
define('SSIM_DATE',"H.i.s d.m.".GAME_YEAR);