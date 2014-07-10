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
       return $this->belongsToMany('User', 'group_is');
   }


   /**
    * Связь с таблицей клиентов
    */
   public function clients()
   {
       return $this->belongsToMany('Client', 'group_id');
   }

}