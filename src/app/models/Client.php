<?php

class Client  extends Eloquent {



   /**
    * Связь с таблицей Пользователя
    */
   public function user()
   {
       return $this->hasOne('User');
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
       return $this->hasOne('Client_status');
    }



   /**
    * Связь с таблицей контактов клиента
    */
   public function contacts()
   {
       return $this->belongToMany('Client_contacts', 'client_id');
   }

}