<?php

use App\Models\GameRequest;
use App\Livewire\HomePage;
use App\Livewire\AllGames;
use App\Livewire\GameDetailPage;
use App\Livewire\PopularGames;
use App\Livewire\PS1Games;
use App\Livewire\PS2Games;
use App\Livewire\WindowsGames;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

// Rute Livewire
Route::get('/', HomePage::class);
Route::get('/games', AllGames::class);
Route::get('/games/windows-games', WindowsGames::class);
Route::get('/games/ps1-games', PS1Games::class);
Route::get('/games/ps2-games', PS2Games::class);
Route::get('/games/popular-games', PopularGames::class);
Route::get('/games/{slug}', GameDetailPage::class)->name('game.detail');
Route::post('/req-game', [GameController::class, 'store'])->name('req-game');


// // Rute GameRequest
// Route::post('/game-requests', function (Request $request) {
//     $validated = $request->validate([
//         'game_name' => 'required|string|max:255',
//         'platform_id' => 'required|integer|exists:platforms,id',
//     ]);

//     GameRequest::create($validated);

//     return response()->json(['message' => 'Game request submitted successfully!']);
// });

// Rute Controller
Route::prefix('/manage-games')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('games.index'); 
    Route::post('/', [GameController::class, 'create'])->name('games.create');
});
