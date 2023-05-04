<?php

namespace App\ViewModels\Log;

use App\ViewModels\Log\Object\LogCommentsObject;
use App\ViewModels\Log\Object\LogShowObject;
use App\ViewModels\Log\Object\RecommendLogObject;

class LogShowViewModel
{
    public function __construct(
        private readonly LogShowObject $log,
        private readonly array         $recommendLog,
        private readonly array         $comments,
    )
    {
    }

    /**
     * @return LogShowObject
     */
    public function getLog(): LogShowObject
    {
        return $this->log;
    }

    /**
     * @return array
     */
    public function getRecommendLog(): array
    {
        return $this->recommendLog;
    }

    /**
     * @return LogCommentsObject[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }
}
