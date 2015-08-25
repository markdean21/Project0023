<?php

class Contact extends Eloquent{
    protected $table = 'contacts';

    public function user(){
        return $this->belongsTo('User');
    }
}