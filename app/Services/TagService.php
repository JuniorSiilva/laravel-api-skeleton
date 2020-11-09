<?php

namespace App\Services;

use App\Models\Tag;
use App\Services\Contracts\TagServiceContract;
use App\Repositories\Contracts\TagRepositoryContract;

class TagService extends Service implements TagServiceContract
{
    /**
     * @var \App\Repositories\TagRepository
     */
    protected $cardRepository = TagRepositoryContract::class;

    public function create(array $data) : int
    {
        $card = new Tag($data);
        $card->save();

        return $card->getKey();
    }
}
