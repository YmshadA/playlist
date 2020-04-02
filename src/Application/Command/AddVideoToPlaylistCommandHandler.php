<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

use Dailymotion\Domain\PlaylistRepository;
use Dailymotion\Domain\VideoInPlaylistRepository;
use Dailymotion\Domain\VideoRepository;

class AddVideoToPlaylistCommandHandler
{
    private PlaylistRepository $playlistRepository;
    private VideoRepository $videoRepository;
    private VideoInPlaylistRepository $videoInPlaylistRepository;

    public function __construct(
        PlaylistRepository $playlistRepository,
        VideoRepository $videoRepository,
        VideoInPlaylistRepository $videoInPlaylistRepository
    ) {
        $this->playlistRepository = $playlistRepository;
        $this->videoRepository = $videoRepository;
        $this->videoInPlaylistRepository = $videoInPlaylistRepository;
    }

    public function addVideoToPlaylist(AddVideoToPlaylistCommand $addVideoToPlaylistCommand): void
    {
        $video = $this->videoRepository->getVideo($addVideoToPlaylistCommand->getVideoId());
        $playlist = $this->playlistRepository->getPlaylist($addVideoToPlaylistCommand->getPlaylistId());

        $this->videoInPlaylistRepository->addVideoToPlaylist(
            $video->getId(),
            $playlist->getId()
        );
    }
}
