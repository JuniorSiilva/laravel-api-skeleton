<?php

namespace App\Services;

use App\Models\Card;
use App\Services\Contracts\CardServiceContract;
use App\Repositories\Contracts\CardRepositoryContract;

class CardService extends Service implements CardServiceContract
{
    /**
     * @var \App\Repositories\CardRepository
     */
    protected $cardRepository = CardRepositoryContract::class;

    public function create(array $data) : int
    {
        return $this->save(new Card, $data);
    }

    public function update(array $data, $id) : int
    {
        return $this->save($this->cardRepository->findById($id, false), $data);
    }

    protected function save(Card $card, array $data) : int
    {
        $card->fill($data);

        $card->save();

        return $card->getKey();
    }
}
