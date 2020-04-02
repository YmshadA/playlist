<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

use Dailymotion\Domain\VideoInPlaylistRepository;

class RemoveVideoFromPlaylistCommandHandler
{
    private VideoInPlaylistRepository $videoInPlaylistRepository;

    public function __construct(VideoInPlaylistRepository $videoInPlaylistRepository)
    {
        $this->videoInPlaylistRepository = $videoInPlaylistRepository;
    }

    public function removeVideoFromPlaylist(RemoveVideoFromPlaylistCommand $removeVideoFromPlaylistCommand): void
    {
        $this->videoInPlaylistRepository->removeVideoFromPlaylist(
            $removeVideoFromPlaylistCommand->getVideoId(),
            $removeVideoFromPlaylistCommand->getPlaylistId()
        );
    }
}
