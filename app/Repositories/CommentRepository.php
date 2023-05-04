<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Collection;

class CommentRepository extends CrudRepository
{
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    public function getCommentByLogId($logId): Collection
    {
        return $this->getQuery()->where("log_id", $logId)->get();
    }
}
