<?php

class ContactPerson extends Eloquent {
    protected $table = 'contactpersons';

    public function user(){
        return $this->belongsTo('User');
    }
}