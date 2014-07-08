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

        $group = new Group;
        $group->name = 'Админы';
        $group->rule = '1111';
        $group->save();

        $user = new User;
        $user->email = 'a.1.3@mail.ru';
        $user->username = 'Aleksey Pivkin';
        $user->password = Hash::make('1234');
        $user->active = 1;
        $user->groups_id = 1;
        $user->group_admin = 1;
        $user->save();

		// $this->call('UserTableSeeder');
	}

}
