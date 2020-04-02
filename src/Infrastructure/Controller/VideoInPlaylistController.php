<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Controller;

use Dailymotion\Application\Command\AddVideoToPlaylistCommand;
use Dailymotion\Application\Command\AddVideoToPlaylistCommandHandler;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;

class VideoInPlaylistController
{
    private AddVideoToPlaylistCommandHandler $addVideoToPlaylistCommandHandler;

    public function __construct(AddVideoToPlaylistCommandHandler $addVideoToPlaylistCommandHandler)
    {
        $this->addVideoToPlaylistCommandHandler = $addVideoToPlaylistCommandHandler;
    }

    public function addVideoToPlaylistAction(Request $request, int $playlistId, int $videoId)
    {
        $this->addVideoToPlaylistCommandHandler->addVideoToPlaylist(
            new AddVideoToPlaylistCommand($videoId, $playlistId)
        );

        return new Response('', Response::STATUS_CREATED);
    }
}
