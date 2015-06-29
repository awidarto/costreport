<?php

class Coa extends Eloquent {

    protected $connection = 'mysql2';
    protected $table = 'j10_acnt';

    public function gl(){
        return $this->belongsTo('Gl','ACNT_CODE', 'ACCNT_CODE');
    }

}