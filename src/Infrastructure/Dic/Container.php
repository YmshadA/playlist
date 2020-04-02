<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Dic;

use Dailymotion\Application\Command\AddPlaylistCommandHandler;
use Dailymotion\Application\Command\AddVideoCommandHandler;
use Dailymotion\Application\Command\AddVideoToPlaylistCommandHandler;
use Dailymotion\Application\Command\DeletePlaylistCommandHandler;
use Dailymotion\Application\Command\DeleteVideoCommandHandler;
use Dailymotion\Application\Command\RemoveVideoFromPlaylistCommandHandler;
use Dailymotion\Application\Command\UpdatePlaylistCommandHandler;
use Dailymotion\Application\Query\GetAllPlaylistsHandler;
use Dailymotion\Application\Query\GetAllVideosHandler;
use Dailymotion\Application\Query\GetAllVideosOrderedByPositionForPlaylistHandler;
use Dailymotion\Infrastructure\Controller\PlaylistController;
use Dailymotion\Infrastructure\Controller\VideoController;
use Dailymotion\Infrastructure\Controller\VideoInPlaylistController;
use Dailymotion\Infrastructure\Persistence\MysqlPlaylistRepository;
use Dailymotion\Infrastructure\Persistence\MysqlVideoInPlaylistRepository;
use Dailymotion\Infrastructure\Persistence\MysqlVideoRepository;

class Container
{
    public static function createContainer(): array
    {
        $mysqlVideoRepository = new MysqlVideoRepository();
        $mysqlPlaylistRepository = new MysqlPlaylistRepository();
        $mysqlVideoInPlaylistRepository = new MysqlVideoInPlaylistRepository();

        $videosController = new VideoController(
            new AddVideoCommandHandler($mysqlVideoRepository),
            new GetAllVideosHandler($mysqlVideoRepository),
            new DeleteVideoCommandHandler($mysqlVideoRepository)
        );

        $playlistController = new PlaylistController(
            new AddPlaylistCommandHandler($mysqlPlaylistRepository),
            new GetAllPlaylistsHandler($mysqlPlaylistRepository),
            new DeletePlaylistCommandHandler($mysqlPlaylistRepository),
            new UpdatePlaylistCommandHandler($mysqlPlaylistRepository)
        );

        $videoInPlaylistController = new VideoInPlaylistController(
            new AddVideoToPlaylistCommandHandler(
                $mysqlPlaylistRepository,
                $mysqlVideoRepository,
                $mysqlVideoInPlaylistRepository
            ),
            new RemoveVideoFromPlaylistCommandHandler(
                $mysqlVideoInPlaylistRepository
            ),
            new GetAllVideosOrderedByPositionForPlaylistHandler(
                $mysqlPlaylistRepository,
                $mysqlVideoInPlaylistRepository
            )
        );

        return [
            VideoController::class => $videosController,
            PlaylistController::class => $playlistController,
            VideoInPlaylistController::class => $videoInPlaylistController,
        ];
    }
}
