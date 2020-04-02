<?php

namespace Dailymotion\Infrastructure\Normalizer;

use Dailymotion\Domain\VideoCollection;

trait VideoCollectionNormalizer
{
    use VideoNormalizer;

    private function normalizeVideoCollection(VideoCollection $videoCollection): array
    {
        $normalizedVideos = [];

        foreach ($videoCollection as $video) {
            $normalizedVideos[] = $this->normalizeVideo($video);
        }

        return $normalizedVideos;
    }
}