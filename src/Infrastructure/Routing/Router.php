<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Routing;

use Dailymotion\Infrastructure\Controller\PlaylistController;
use Dailymotion\Infrastructure\Controller\VideoController;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;

class Router
{
    private VideoController $videosController;
    private PlaylistController $playlistController;

    public function __construct(
        VideoController $videosController,
        PlaylistController $playlistController
    ) {
        $this->videosController = $videosController;
        $this->playlistController = $playlistController;
    }

    public function handle(Request $request): Response
    {
        try {
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

        return $this->respond404();
    }

    private function respond404(): Response
    {
        return new Response(json_encode(['error' => 'No route found'], JSON_THROW_ON_ERROR), 404);
    }
}
