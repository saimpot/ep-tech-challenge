<?php

use App\User;
use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
         $user = User::first() ?? factory(User::class)->create();

         $numberOfClients = mt_rand(10, 30);

         factory(Client::class, $numberOfClients)->create([
             'user_id' => $user->id,
         ]);
    }
}
