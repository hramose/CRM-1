<?php

class Client_status  extends Eloquent {

    public $timestamps = false;

    protected $table = 'client_status';

    protected $fillable = array('name');

   /**
    * Связь с таблицей клиентов
    */
   public function contacts()
   {
       return $this->belongsToMany('Client', 'client_id');
   }

}