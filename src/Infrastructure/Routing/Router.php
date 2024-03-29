<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Routing;

use Dailymotion\Infrastructure\Controller\PlaylistController;
use Dailymotion\Infrastructure\Controller\VideoController;
use Dailymotion\Infrastructure\Controller\VideoInPlaylistController;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;

class Router
{
    private VideoController $videosController;
    private PlaylistController $playlistController;
    private VideoInPlaylistController $videoInPlaylistController;

    public function __construct(
        VideoController $videosController,
        PlaylistController $playlistController,
        VideoInPlaylistController $videoInPlaylistController
    ) {
        $this->videosController = $videosController;
        $this->playlistController = $playlistController;
        $this->videoInPlaylistController = $videoInPlaylistController;
    }

    public function handle(Request $request): Response
    {
        try {
            if (preg_match(
                '/^\/playlists\/(?<playlist_id>\d+)\/videos$/',
                $request->getUri(),
                $matches
            )) {
                return $this->routeToReadVideoInPlaylistController(
                    $request,
                    (int)$matches['playlist_id']
                );
            }

            if (preg_match(
                '/^\/playlists\/(?<playlist_id>\d+)\/videos\/(?<video_id>\d+)$/',
                $request->getUri(),
                $matches
            )) {
                return $this->routeToWriteVideoInPlaylistController(
                    $request,
                    (int)$matches['playlist_id'],
                    (int)$matches['video_id']
                );
            }

            if (preg_match('/^\/videos/', $request->getUri())) {
                return $this->routeToVideosController($request);
            }
            if (preg_match('/^\/playlists/', $request->getUri())) {
                return $this->routeToPlaylistController($request);
            }
        } catch (\Exception $e) {
            $error = ['error' => get_class($e).' '.$e->getCode().' - '.$e->getMessage()];
            return new Response(json_encode($error, JSON_THROW_ON_ERROR), 500);
        }

        return $this->respond404();
    }

    private function routeToVideosController(Request $request): Response
    {
        if ($request->getUri() === '/videos' && $request->getHttpMethod() === Request::HTTP_VERB_POST) {
            return $this->videosController->createVideoAction($request);
        }

        if ($request->getUri() === '/videos' && $request->getHttpMethod() === Request::HTTP_VERB_GET) {
            return $this->videosController->getVideosAction($request);
        }

        if ($request->getHttpMethod() === Request::HTTP_VERB_DELETE
            && preg_match('/^\/videos\/(?<videoId>\d+)$/', $request->getUri(), $matches)
        ) {
            return $this->videosController->deleteVideoAction($request, (int)$matches['videoId']);
        }

        return $this->respond404();
    }

    private function routeToWriteVideoInPlaylistController(Request $request, int $playlistId, int $videoId): Response
    {
        if ($request->getHttpMethod() === Request::HTTP_VERB_PUT) {
            return $this->videoInPlaylistController->addVideoToPlaylistAction($request, $playlistId, $videoId);
        }

        if ($request->getHttpMethod() === Request::HTTP_VERB_DELETE) {
            return $this->videoInPlaylistController->removeVideoToPlaylistAction($request, $playlistId, $videoId);
        }

        return $this->respond404();
    }

    private function routeToReadVideoInPlaylistController(Request $request, int $playlistId): Response
    {
        if ($request->getHttpMethod() === Request::HTTP_VERB_GET) {
            return $this->videoInPlaylistController->getAllVideosForPlaylist($request, $playlistId);
        }

        return $this->respond404();
    }

    private function routeToPlaylistController(Request $request): Response
    {
        if ($request->getUri() === '/playlists' && $request->getHttpMethod() === Request::HTTP_VERB_POST) {
            return $this->playlistController->createPlaylistAction($request);
        }

        if ($request->getUri() === '/playlists' && $request->getHttpMethod() === Request::HTTP_VERB_GET) {
            return $this->playlistController->getPlaylistsAction($request);
        }

        if ($request->getHttpMethod() === Request::HTTP_VERB_DELETE
            && preg_match('/^\/playlists\/(?<playlistId>\d+)$/', $request->getUri(), $matches)
        ) {
            return $this->playlistController->deletePlaylistAction($request, (int)$matches['playlistId']);
        }

        if ($request->getHttpMethod() === Request::HTTP_VERB_PATCH
            && preg_match('/^\/playlists\/(?<playlistId>\d+)$/', $request->getUri(), $matches)
        ) {
            return $this->playlistController->updatePlaylistAction($request, (int)$matches['playlistId']);
        }

        return $this->respond404();
    }

    private function respond404(): Response
    {
        return new Response(json_encode(['error' => 'No route found'], JSON_THROW_ON_ERROR), 404);
    }
}
