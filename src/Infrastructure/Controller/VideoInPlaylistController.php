<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Controller;

use Dailymotion\Application\Command\AddVideoToPlaylistCommand;
use Dailymotion\Application\Command\AddVideoToPlaylistCommandHandler;
use Dailymotion\Application\Command\RemoveVideoFromPlaylistCommand;
use Dailymotion\Application\Command\RemoveVideoFromPlaylistCommandHandler;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;

class VideoInPlaylistController
{
    private AddVideoToPlaylistCommandHandler $addVideoToPlaylistCommandHandler;
    private RemoveVideoFromPlaylistCommandHandler $removeVideoFromPlaylistCommandHandler;

    public function __construct(
        AddVideoToPlaylistCommandHandler $addVideoToPlaylistCommandHandler,
        RemoveVideoFromPlaylistCommandHandler $removeVideoFromPlaylistCommandHandler
    ) {
        $this->addVideoToPlaylistCommandHandler = $addVideoToPlaylistCommandHandler;
        $this->removeVideoFromPlaylistCommandHandler = $removeVideoFromPlaylistCommandHandler;
    }

    public function addVideoToPlaylistAction(Request $request, int $playlistId, int $videoId)
    {
        $this->addVideoToPlaylistCommandHandler->addVideoToPlaylist(
            new AddVideoToPlaylistCommand($videoId, $playlistId)
        );

        return new Response('', Response::STATUS_CREATED);
    }

    public function removeVideoToPlaylistAction(Request $request, int $playlistId, int $videoId)
    {
        $this->removeVideoFromPlaylistCommandHandler->removeVideoFromPlaylist(
            new RemoveVideoFromPlaylistCommand($videoId, $playlistId)
        );

        return new Response('', Response::STATUS_NO_CONTENT);
    }
}
