<?php
declare(strict_types=1);

namespace Dailymotion\Application\Query;

use Dailymotion\Domain\PlaylistCollection;
use Dailymotion\Domain\PlaylistRepository;

class GetAllPlaylistsHandler
{
    /** @var PlaylistRepository */
    private $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepository)
    {
        $this->playlistRepository = $playlistRepository;
    }

    public function getAllPlaylists(): PlaylistCollection
    {
        return $this->playlistRepository->getAllPlaylist();
    }
}
