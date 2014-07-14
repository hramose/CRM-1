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
        Client::truncate();

        $group = new Group;
        $group->name = 'Администратор';
        $group->rule = '11111';
        $group->save();

        $group = new Group;
        $group->name = 'Отдел продаж';
        $group->rule = '01110';
        $group->save();


        // заполняем таблицу статусов
        $status = array('Входящий', 'Клиент', 'Архив', 'Отказ');

        foreach ($status as $v) {
            $c_stat = new Client_status;
            $c_stat->name = $v;
            $c_stat->save();
        }


		$this->call('FakerSeeder');
	}

}
