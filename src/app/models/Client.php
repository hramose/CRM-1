<?php

class Client  extends Eloquent {

    protected $fillable = array('group_id', 'user_id', 'status_id', 'see_all', 'name', 'company_name', 'url', 'about');


    /**
    * Связь с таблицей Пользователя
    */
    public function user()
    {
       return $this->hasOne('User', 'id');
    }


    /**
    * Связь с таблицей группы
    */
    public function group()
    {
       return $this->hasOne('Group', 'id');
    }



    /**
    * Связь с таблицей Пользователя
    */
    public function status()
    {
       return $this->hasOne('Client_status', 'id');
    }



    /**
    * Связь с таблицей контактов клиента
    */
    public function contacts()
    {
       return $this->hasMany('Client_contacts', 'client_id')
                   ->select(array(
                        'address',
                        'client_id',
                        'mail',
                        'name',
                        'phone',
                        'position'
                    ));
    }

}