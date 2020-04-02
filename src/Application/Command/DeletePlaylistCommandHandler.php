<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

use Dailymotion\Domain\PlaylistRepository;

class DeletePlaylistCommandHandler
{
    private PlaylistRepository $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepository)
    {
        $this->playlistRepository = $playlistRepository;
    }

    public function deletePlaylist(DeletePlaylistCommand $deletePlaylistCommand): void
    {
        $this->playlistRepository->deletePlaylist($deletePlaylistCommand->getPlaylistId());
    }
}
