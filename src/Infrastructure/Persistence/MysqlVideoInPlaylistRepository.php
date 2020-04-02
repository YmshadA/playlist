<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Persistence;

use Dailymotion\Domain\Exception\PlaylistNotFoundException;
use Dailymotion\Domain\Video;
use Dailymotion\Domain\VideoCollection;
use Dailymotion\Domain\VideoInPlaylistRepository;
use Dailymotion\Infrastructure\Persistence\Exception\MysqlQueryException;

class MysqlVideoInPlaylistRepository implements VideoInPlaylistRepository
{
    public function getAllVideoForPlaylist(int $playlistId): VideoCollection
    {
        $pdo = $this->getPDO();

        $sql = 'SELECT v.id, v.title, v.thumbnail
                FROM dailymotion.video_playlist vp
                INNER JOIN dailymotion.video v on vp.video_id = v.id
                WHERE vp.playlist_id = :playlist_id
                ORDER BY vp.position';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':playlist_id' => $playlistId,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }

        $videos = $statement->fetchAll();

        $videoCollection = new VideoCollection();
        foreach ($videos as $video) {
            $videoCollection->add(new Video((int)$video['id'], $video['title'], $video['thumbnail']));
        }

        return $videoCollection;
    }

    public function removeVideoFromPlaylist(int $videoId, int $playlistId):void
    {
        $pdo = $this->getPDO();

        $sql = 'DELETE FROM dailymotion.video_playlist 
                WHERE playlist_id = :playlist_id
                AND video_id = :video_id';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':video_id' => $videoId,
            ':playlist_id' => $playlistId,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }
    }

    public function addVideoToPlaylist(int $videoId, int $playlistId): void
    {
        $pdo = $this->getPDO();

        $nextPosition = $this->getNextPositionFor($pdo, $playlistId);

        $sql = 'INSERT INTO dailymotion.video_playlist(video_id, playlist_id, position) 
                VALUES (:video_id, :playlist_id, :position)';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':video_id' => $videoId,
            ':playlist_id' => $playlistId,
            ':position' => $nextPosition,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }
    }

    private function getNextPositionFor(\PDO $pdo, int $playlistId): int
    {
        $sql = 'select
                CASE
                    WHEN max(position) is null THEN 1
                    ELSE max(position) + 1
                END as next_position
                from dailymotion.video_playlist
                where playlist_id = :playlist_id';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':playlist_id' => $playlistId,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }

        $nextPosition = $statement->fetch();

        return (int)$nextPosition['next_position'];
    }

    private function getPDO(): \PDO
    {
        return new \PDO(
            'mysql:host=mysql;dbname=dailymotion',
            'dailymotion',
            'dailymotion'
        );
    }
}
