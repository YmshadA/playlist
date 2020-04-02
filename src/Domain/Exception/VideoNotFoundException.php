<?php
declare(strict_types=1);

namespace Dailymotion\Domain\Exception;

class VideoNotFoundException extends \RuntimeException
{
    public function __construct(int $videoId)
    {
        parent::__construct("Video $videoId not found");
    }
}
