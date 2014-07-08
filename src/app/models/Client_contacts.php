<?php

class Client_contacts  extends Eloquent {

    protected $table = 'client_contacts';


   /**
    * Связь с таблицей клиентов
    */
   public function client()
   {
       return $this->hasOne('Client', 'id');
   }

}