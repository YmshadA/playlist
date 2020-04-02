<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Controller;

use Dailymotion\Application\Command\AddVideoToPlaylistCommand;
use Dailymotion\Application\Command\AddVideoToPlaylistCommandHandler;
use Dailymotion\Application\Command\RemoveVideoFromPlaylistCommand;
use Dailymotion\Application\Command\RemoveVideoFromPlaylistCommandHandler;
use Dailymotion\Application\Query\GetAllVideosOrderedByPositionForPlaylistHandler;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;
use Dailymotion\Infrastructure\Normalizer\VideoCollectionNormalizer;

class VideoInPlaylistController
{
    use VideoCollectionNormalizer;

    private AddVideoToPlaylistCommandHandler $addVideoToPlaylistCommandHandler;
    private RemoveVideoFromPlaylistCommandHandler $removeVideoFromPlaylistCommandHandler;
    private GetAllVideosOrderedByPositionForPlaylistHandler $getAllVideosForPlaylist;

    public function __construct(
        AddVideoToPlaylistCommandHandler $addVideoToPlaylistCommandHandler,
        RemoveVideoFromPlaylistCommandHandler $removeVideoFromPlaylistCommandHandler,
        GetAllVideosOrderedByPositionForPlaylistHandler $getAllVideosForPlaylist
    ) {
        $this->addVideoToPlaylistCommandHandler = $addVideoToPlaylistCommandHandler;
        $this->removeVideoFromPlaylistCommandHandler = $removeVideoFromPlaylistCommandHandler;
        $this->getAllVideosForPlaylist = $getAllVideosForPlaylist;
    }

    public function addVideoToPlaylistAction(Request $request, int $playlistId, int $videoId): Response
    {
        $this->addVideoToPlaylistCommandHandler->addVideoToPlaylist(
            new AddVideoToPlaylistCommand($videoId, $playlistId)
        );

        return new Response('', Response::STATUS_CREATED);
    }

    public function removeVideoToPlaylistAction(Request $request, int $playlistId, int $videoId): Response
    {
        $this->removeVideoFromPlaylistCommandHandler->removeVideoFromPlaylist(
            new RemoveVideoFromPlaylistCommand($videoId, $playlistId)
        );

        return new Response('', Response::STATUS_NO_CONTENT);
    }

    public function getAllVideosForPlaylist(Request $request, int $playlistId): Response
    {
        $videoCollection = $this->getAllVideosForPlaylist->getAll($playlistId);

        $normalizedVideos = $this->normalizeVideoCollection($videoCollection);

        return new Response(
            json_encode(['data' => $normalizedVideos], JSON_THROW_ON_ERROR, 512),
            Response::STATUS_OK
        );
    }
}
