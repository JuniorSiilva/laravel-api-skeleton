<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateTag;
use App\Http\Resources\TagResource;
use App\Http\Requests\DefaultListRequest;
use App\Services\Contracts\TagServiceContract;
use App\Repositories\Contracts\TagRepositoryContract;

class TagController extends Controller
{
    /**
     * @var \App\Repositories\TagRepository
     */
    protected $tagRepository = TagRepositoryContract::class;

    /**
     * @var \App\Services\TagService
     */
    protected $tagService = TagServiceContract::class;

    public function get(DefaultListRequest $request)
    {
        $search = $request->inputOr('search', '');

        $cads = $this->tagRepository->getAll(false, 10, $search);

        return response($cads)->withResource(TagResource::class);
    }

    public function create(CreateTag $request)
    {
        $tagId = $this->tagService->create($request->validated());

        return response(['id' => $tagId], Response::HTTP_CREATED);
    }
}
