<?php

namespace Dailymotion\Domain;

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
     */
    public function deleteVideo(int $videoId): void;
}
