<?php

class Task extends Eloquent {
    protected $table = 'tasks';

    public function user(){
        return $this->belongsTo('User');
    }
}