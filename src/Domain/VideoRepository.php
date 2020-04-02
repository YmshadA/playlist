<?php

namespace Dailymotion\Domain;

use Dailymotion\Domain\Exception\VideoNotFoundException;

interface VideoRepository
{
    /**
     * @param string $title
     * @param string $thumbnail
     *
     * @return Video
     */
    public function addVideo(string $title, string $thumbnail): Video;

    /**
     * @return VideoCollection
     */
    public function getAllVideos(): VideoCollection;

    /**
     * @param int $videoId
     *
     * @return Video
     *
     * @throws VideoNotFoundException
     */
    public function getVideo(int $videoId): Video;

    /**
     * @param int $videoId
     */
    public function deleteVideo(int $videoId): void;
}
