<?php

class Client_history  extends Eloquent {

    protected $table = 'client_historys';

    protected $fillable = array('client_id', 'event');


   /**
    * Связь с таблицей клиентов
    */
   public function client()
   {
       return $this->belongsTo('Client', 'client_id');
   }

}