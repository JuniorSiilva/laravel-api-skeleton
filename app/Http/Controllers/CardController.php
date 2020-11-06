<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateCard;
use App\Http\Resources\CardResource;
use App\Http\Requests\DefaultListRequest;
use App\Services\Contracts\CardServiceContract;
use App\Repositories\Contracts\CardRepositoryContract;

class CardController extends Controller
{
    /**
     * @var \App\Repositories\CardRepository
     */
    protected $cardRepository = CardRepositoryContract::class;

    /**
     * @var \App\Services\CardService
     */
    protected $cardService = CardServiceContract::class;

    public function get(DefaultListRequest $request)
    {
        $search = $request->inputOr('search', '');
        $take = $request->inputOr('take', 10);

        $cads = $this->cardRepository->getAll(true, $take, $search);

        return response($cads)->withResource(CardResource::class);
    }

    public function find(int $id)
    {
        $card = $this->cardRepository->findById($id);

        return response($card)->withResource(CardResource::class);
    }

    public function create(CreateCard $request)
    {
        $cardId = $this->cardService->create($request->validated());

        return response(['id' => $cardId], Response::HTTP_CREATED);
    }
}
