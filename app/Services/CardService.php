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
        $card = $this->save(new Card, $data);

        return $card->getKey();
    }

    public function update(array $data, $id) : int
    {
        $card = $this->save($this->cardRepository->findById($id, false), $data);

        return $card->getKey();
    }

    protected function save(Card $card, array $data) : Card
    {
        $card->fill($data);

        $card->save();

        return $card;
    }
}
