<?php
declare(strict_types=1);

namespace Dailymotion\Domain;

class VideoCollection implements \IteratorAggregate
{
    /** @var Video[] */
    private array $videos = [];

    public function add(Video $video)
    {
        $this->videos[] = $video;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->videos);
    }
}
