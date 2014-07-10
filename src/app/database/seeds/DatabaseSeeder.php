<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        Group::truncate();
        User::truncate();
        Client_status::truncate();

        $group = new Group;
        $group->name = 'Админы';
        $group->rule = '1111';
        $group->save();

        $user = new User;
        $user->email = 'a.1.3@mail.ru';
        $user->username = 'Aleksey Pivkin';
        $user->password = Hash::make('123123');
        $user->active = 1;
        $user->groups_id = 1;
        $user->group_admin = 1;
        $user->save();


        // заполняем таблицу статусов
        $status = array('Входящий', 'Клиент', 'Архив', 'Отказ', 'Корзина');

        foreach ($status as $v) {
            $c_stat = new Client_status;
            $c_stat->name = $v;
            $c_stat->save();
        }


		// $this->call('UserTableSeeder');
	}

}
