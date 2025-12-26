<?php

namespace App\Livewire;

use App\Helpers\PlatformHelper;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PopularGames extends Component
{
    public $popularGames;
    public $popularWindowsGames;
    public $popularPS1Games;
    public $popularPS2Games;
    public $recentUploadedGames;
    public $recentUploadedWindowsGames;
    public $recentUploadedPS1Games;
    public $recentUploadedPS2Games;

    public function mount()
    {
        // Ambil data game umum POPULAR (10 game terbaru untuk semua platform)
        $this->popularGames = $this->fetchGames(null, 10, 'popular');

        // Ambil 10 game POPULAR untuk masing-masing platform
        $this->popularWindowsGames = $this->fetchGames(1, 10, 'popular'); // Platform ID: Windows
        $this->popularPS1Games = $this->fetchGames(2, 10, 'popular');     // Platform ID: PS1
        $this->popularPS2Games = $this->fetchGames(3, 10, 'popular');     // Platform ID: PS2

        // Ambil 10 game terbaru umum
        $this->recentUploadedGames = $this->fetchGames(null, 10, 'recent');

        // Ambil 10 game terbaru untuk masing-masing platform
        $this->recentUploadedWindowsGames = $this->fetchGames(1, 10, 'recent'); // Platform ID: Windows
        $this->recentUploadedPS1Games = $this->fetchGames(2, 10, 'recent');     // Platform ID: PS1
        $this->recentUploadedPS2Games = $this->fetchGames(3, 10, 'recent');     // Platform ID: PS2
    }

    /**
     * Fetch games from database with optional platform filter.
     *
     * @param int|null $platformId (optional) Platform ID to filter.
     * @return \Illuminate\Support\Collection
     */
    private function fetchGames(?int $platformId = null, int $limit = 10, string $sortBy = 'recent')
    {
        $query = DB::table('games as g')
            ->select(
                'g.id AS game_id',
                'g.thumbnail AS game_thumbnail',
                'g.name AS game_name',
                'g.summary AS game_summary',
                'g.slug AS game_slug',
                'g.created_at',
                'g.platform_id',
                'g.meta_title',
                'g.meta_description',
                'g.meta_keyword',
                DB::raw('GROUP_CONCAT(gn.name SEPARATOR ", ") AS genre_names')
            )
            ->leftJoin('game_genre as gg', 'g.id', '=', 'gg.game_id')
            ->leftJoin('genres as gn', 'gg.genre_id', '=', 'gn.id')
            ->groupBy('g.id', 'g.thumbnail', 'g.name', 'g.summary', 'g.slug', 'g.created_at', 'g.platform_id','g.meta_title','g.meta_description','g.meta_keyword',)
            ->limit($limit); // Batas jumlah game

        if ($platformId) {
            $query->where('g.platform_id', $platformId); // Filter berdasarkan platform
        }

        // Menentukan urutan berdasarkan parameter $sortBy
        if ($sortBy == 'popular') {
            $query->orderByDesc('g.total_views'); // Urutkan berdasarkan popularitas (total_views)
        } else {
            $query->orderByDesc('g.created_at'); // Urutkan berdasarkan tanggal terbaru (created_at)
        }

        return $query->get();
    }

    public function render()
    {
        return view('livewire.popular-games')
        ->layout('components.layouts.app', [
            'title' => 'Popular Games - Tomss14 - Free Games for You!',
            'meta_description' => 'Free Games for You!',
            'meta_keyword' => 'free games, ps1, ps2, windows games, popular games',
        ]);
    }
}
