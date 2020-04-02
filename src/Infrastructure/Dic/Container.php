<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Dic;

use Dailymotion\Application\Command\AddPlaylistCommandHandler;
use Dailymotion\Application\Command\AddVideoCommandHandler;
use Dailymotion\Application\Command\DeletePlaylistCommandHandler;
use Dailymotion\Application\Command\DeleteVideoCommandHandler;
use Dailymotion\Application\Query\GetAllPlaylistsHandler;
use Dailymotion\Application\Query\GetAllVideosHandler;
use Dailymotion\Infrastructure\Controller\PlaylistController;
use Dailymotion\Infrastructure\Controller\VideoController;
use Dailymotion\Infrastructure\Persistence\MysqlPlaylistRepository;
use Dailymotion\Infrastructure\Persistence\MysqlVideoRepository;

class Container
{
    public static function createContainer(): array
    {
        $videosController = new VideoController(
            new AddVideoCommandHandler(
                new MysqlVideoRepository()
            ),
            new GetAllVideosHandler(
                new MysqlVideoRepository()
            ),
            new DeleteVideoCommandHandler(
                new MysqlVideoRepository()
            )
        );

        $playlistController = new PlaylistController(
            new AddPlaylistCommandHandler(
                new MysqlPlaylistRepository()
            ),
            new GetAllPlaylistsHandler(
                new MysqlPlaylistRepository()
            ),
            new DeletePlaylistCommandHandler(
                new MysqlPlaylistRepository()
            )
        );

        return [
            VideoController::class => $videosController,
            PlaylistController::class => $playlistController
        ];
    }
}
