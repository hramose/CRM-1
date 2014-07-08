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
       return $this->belongToMany('User', 'group_is');
   }


   /**
    * Связь с таблицей клиентов
    */
   public function clients()
   {
       return $this->belongToMany('Client', 'group_id');
   }

}