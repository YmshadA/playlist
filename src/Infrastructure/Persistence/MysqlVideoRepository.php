<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Persistence;

use Dailymotion\Domain\Exception\VideoNotFoundException;
use Dailymotion\Domain\Video;
use Dailymotion\Domain\VideoCollection;
use Dailymotion\Domain\VideoRepository;
use Dailymotion\Infrastructure\Persistence\Exception\MysqlQueryException;

class MysqlVideoRepository implements VideoRepository
{
    private MysqlConnection $mysqlConnection;

    public function __construct(MysqlConnection $mysqlConnection)
    {
        $this->mysqlConnection = $mysqlConnection;
    }

    public function addVideo(string $title, string $thumbnail): Video
    {
        $pdo = $this->mysqlConnection->getPDO();

        $sql = 'INSERT INTO dailymotion.video(title, thumbnail) VALUES (:title, :thumbnail)';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':title' => $title,
            ':thumbnail' => $thumbnail
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }

        $videoId = (int)$pdo->lastInsertId();

        return new Video($videoId, $title, $thumbnail);
    }

    public function getAllVideos(): VideoCollection
    {
        $pdo = $this->mysqlConnection->getPDO();

        $sql = 'SELECT id, title, thumbnail FROM dailymotion.video';

        $statement = $pdo->query($sql);
        $videos = $statement->fetchAll();

        $videoCollection = new VideoCollection();
        foreach ($videos as $video) {
            $videoCollection->add(new Video((int)$video['id'], $video['title'], $video['thumbnail']));
        }

        return $videoCollection;
    }

    public function getVideo(int $videoId): Video
    {
        $pdo = $this->mysqlConnection->getPDO();

        $sql = 'SELECT id, title, thumbnail FROM dailymotion.video where id = :id';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':id' => $videoId
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }

        $video = $statement->fetch();

        if (false === $video) {
            throw new VideoNotFoundException($videoId);
        }

        return new Video((int)$video['id'], $video['title'], $video['thumbnail']);
    }

    public function deleteVideo(int $videoId):void
    {
        $pdo = $this->mysqlConnection->getPDO();

        $sql = 'DELETE FROM dailymotion.video WHERE id = :id';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':id' => $videoId
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }
    }
}
