<?php

use App\Models\User;
use App\Enums\CardBrand;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 3)->create()->each(function (User $user) {
            $debtorsCount = 8;

            for ($i = 0; $i < $debtorsCount; $i++) {
                DB::table('debtors')->insert(['name' => "Devedor $i|{$user->getKey()}", 'email' => "devedor-$i-{$user->getKey()}@gmail.com", 'owner_id' => $user->getKey()]);
            }

            $cardsCount = 3;

            for ($i = 0; $i < $cardsCount; $i++) {
                DB::table('cards')->insert(['digits' => rand(1000, 9999), 'brand' => CardBrand::getKeys()[rand(0, 5)], 'owner_id' => $user->getKey()]);
            }
        });
    }
}
