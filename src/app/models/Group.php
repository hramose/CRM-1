<?php


class Group extends Eloquent {

    public $timestamps = false;

    protected $table = 'groups';

   protected $fillable = array('name', 'rule');


   /**
    * Связь с таблицей пользователей
    */
   public function users()
   {
       return $this->hasMany('User', 'group_id'); //, 'group_id');
   }


   /**
    * Связь с таблицей клиентов
    */
   public function clients()
   {
       return $this->hasMany('Client', 'group_id');
   }

}