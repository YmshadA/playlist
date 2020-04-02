<?php
declare(strict_types=1);

namespace Dailymotion\Application\Query;

use Dailymotion\Domain\PlaylistRepository;
use Dailymotion\Domain\VideoCollection;
use Dailymotion\Domain\VideoInPlaylistRepository;

class GetAllVideosOrderedByPositionForPlaylistHandler
{
    private PlaylistRepository $playlistRepository;
    private VideoInPlaylistRepository $videoInPlaylistRepository;

    public function __construct(
        PlaylistRepository $playlistRepository,
        VideoInPlaylistRepository $videoInPlaylistRepository
    ) {
        $this->playlistRepository = $playlistRepository;
        $this->videoInPlaylistRepository = $videoInPlaylistRepository;
    }

    public function getAll(int $playlistId): VideoCollection
    {
        $this->playlistRepository->getPlaylist($playlistId);

        return $this->videoInPlaylistRepository->getAllVideoForPlaylist($playlistId);
    }
}
