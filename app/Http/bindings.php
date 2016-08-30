<?php
\Route::bind('gameSlug', function($value) {
   return \EmergencyExplorer\Game::where('name', str_replace('-', ' ', $value))->first();
});