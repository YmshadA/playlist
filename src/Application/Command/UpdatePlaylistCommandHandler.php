<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

use Dailymotion\Domain\Playlist;
use Dailymotion\Domain\PlaylistRepository;

class UpdatePlaylistCommandHandler
{
    private PlaylistRepository $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepository)
    {
        $this->playlistRepository = $playlistRepository;
    }

    public function updatePlaylist(UpdatePlaylistCommand $updatePlaylistCommand): void
    {
        $this->playlistRepository->getPlaylist($updatePlaylistCommand->getPlaylistId());

        $this->playlistRepository->updatePlaylist(
            $updatePlaylistCommand->getPlaylistId(),
            $updatePlaylistCommand->getName()
        );
    }
}
