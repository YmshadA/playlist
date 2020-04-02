<?php

namespace Dailymotion\Infrastructure\Normalizer;

use Dailymotion\Domain\Video;

trait VideoNormalizer
{
    private function normalizeVideo(Video $video): array
    {
        return [
            'id' => $video->getId(),
            'title' => $video->getTitle(),
            'thumbnail' => $video->getThumbnail(),
        ];
    }
}
