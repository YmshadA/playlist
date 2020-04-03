<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Controller;

use Dailymotion\Application\Command\AddPlaylistCommand;
use Dailymotion\Application\Command\AddPlaylistCommandHandler;
use Dailymotion\Application\Command\DeletePlaylistCommand;
use Dailymotion\Application\Command\DeletePlaylistCommandHandler;
use Dailymotion\Application\Command\UpdatePlaylistCommand;
use Dailymotion\Application\Command\UpdatePlaylistCommandHandler;
use Dailymotion\Application\Query\GetAllPlaylistsHandler;
use Dailymotion\Domain\Exception\PlaylistNotFoundException;
use Dailymotion\Domain\Playlist;
use Dailymotion\Domain\PlaylistCollection;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;

class PlaylistController
{
    private AddPlaylistCommandHandler $addPlaylistCommandHandler;
    private GetAllPlaylistsHandler $getAllPlaylistsHandler;
    private DeletePlaylistCommandHandler $deletePlaylistCommandHandler;
    private UpdatePlaylistCommandHandler $updatePlaylistCommandHandler;

    public function __construct(
        AddPlaylistCommandHandler $addPlaylistCommandHandler,
        GetAllPlaylistsHandler $getAllPlaylistsHandler,
        DeletePlaylistCommandHandler $deletePlaylistCommandHandler,
        UpdatePlaylistCommandHandler $updatePlaylistCommandHandler
    ) {
        $this->addPlaylistCommandHandler = $addPlaylistCommandHandler;
        $this->getAllPlaylistsHandler = $getAllPlaylistsHandler;
        $this->deletePlaylistCommandHandler = $deletePlaylistCommandHandler;
        $this->updatePlaylistCommandHandler = $updatePlaylistCommandHandler;
    }

    public function createPlaylistAction(Request $request): Response
    {
        $data = json_decode($request->getBody(), true);

        if (!array_key_exists('name', $data)) {
            $error = ['error' => 'One of this field [name] is missing'];
            return new Response(json_encode($error, JSON_THROW_ON_ERROR), Response::STATUS_BAD_REQUEST);
        }

        $playlist = $this->addPlaylistCommandHandler->addPlaylist(new AddPlaylistCommand($data['name']));

        return new Response(
            json_encode([
                'data' => $this->normalizePlaylist($playlist)
            ], JSON_THROW_ON_ERROR),
            Response::STATUS_CREATED
        );
    }

    public function getPlaylistsAction(Request $request): Response
    {
        $playlists = $this->getAllPlaylistsHandler->getAllPlaylists();

        return new Response(
            json_encode([
                'data' => $this->normalizePlaylistCollection($playlists)
            ], JSON_THROW_ON_ERROR),
            Response::STATUS_OK
        );
    }

    public function deletePlaylistAction(Request $request, int $playlistId): Response
    {
        $this->deletePlaylistCommandHandler->deletePlaylist(new DeletePlaylistCommand($playlistId));

        return new Response('', Response::STATUS_NO_CONTENT);
    }

    public function updatePlaylistAction(Request $request, int $playlistId): Response
    {
        $data = json_decode($request->getBody(), true);

        if (!array_key_exists('name', $data)) {
            $error = ['error' => 'One of this field [name] is missing'];
            return new Response(json_encode($error, JSON_THROW_ON_ERROR), Response::STATUS_BAD_REQUEST);
        }

        try {
            $playlist = $this->updatePlaylistCommandHandler->updatePlaylist(new UpdatePlaylistCommand(
                $playlistId,
                $data['name']
            ));
        } catch (PlaylistNotFoundException $e) {
            $error = ['error' => $e->getMessage()];
            return new Response(json_encode($error, JSON_THROW_ON_ERROR), Response::STATUS_NOT_FOUND);
        }

        return new Response(
            json_encode([
                'data' => $this->normalizePlaylist($playlist)
            ], JSON_THROW_ON_ERROR),
            Response::STATUS_OK
        );
    }

    private function normalizePlaylistCollection(PlaylistCollection $playlistCollection): array
    {
        $normalizedPlaylists = [];

        foreach ($playlistCollection as $playlist) {
            $normalizedPlaylists[] = $this->normalizePlaylist($playlist);
        }

        return $normalizedPlaylists;
    }

    private function normalizePlaylist(Playlist $playlist): array
    {
        return [
            'id' => $playlist->getId(),
            'name' => $playlist->getName(),
        ];
    }
}
