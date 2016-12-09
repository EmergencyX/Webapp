<?php
\Route::bind('gameSlug', function($value) {
   return \EmergencyExplorer\Models\Game::where('name', str_replace('-', ' ', $value))->first();
});