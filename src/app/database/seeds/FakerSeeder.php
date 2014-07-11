<?php

use Faker\Factory as Faker;

/**
*
*/
class FakerSeeder extends Seeder
{

    public function run() {

        $faker = Faker::create();


        $user = new User;
        $user->email = 'a.1.3@mail.ru';
        $user->username = 'Aleksey Pivkin';
        $user->password = Hash::make('123123');
        $user->active = 1;
        $user->groups_id = 1;
        $user->group_admin = 1;
        $user->save();

        $user = new User;
        $user->email = 'avil@vipro.ru';
        $user->username = 'Avil';
        $user->password = Hash::make('123123');
        $user->active = 1;
        $user->groups_id = 1;
        $user->group_admin = 0;
        $user->save();

        $user = new User;
        $user->email = 'a.pivkin@vipro.ru';
        $user->username = 'mr.Alex';
        $user->password = Hash::make('123123');
        $user->active = 1;
        $user->groups_id = 1;
        $user->group_admin = 0;
        $user->save();


        $company_count = 500;

        for ($i=0; $i < $company_count; $i++) {
            Client::create(array(
                    'group_id'     => 1,
                    'user_id'      => rand(1, 3),
                    'status_id'    => rand(1, 4),
                    'see_all'      => 1,
                    'name'         => $faker->name,
                    'company_name' => $faker->company,
                    'url'          => $faker->url,
                    'about'        => $faker->sentence( rand(6, 15) )
                ));
        }

        $position = array('Директор', 'Менеджер', 'Начальник отдела');


        for ($i=0; $i < $company_count + 50; $i++) {
            Client_contacts::create(array(
                    'client_id' => rand(1, $company_count),
                    'name' => $faker->name,
                    'mail' => $faker->email,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'position' => $position[rand(0, 2)]
                ));
        }

    }
}