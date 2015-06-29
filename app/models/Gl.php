<?php

class Gl extends Eloquent {
    use \SleepingOwl\WithJoin\WithJoinTrait;

    protected $connection = 'mysql2';
    protected $table = 'j10_a_salfldg';

    public function coa(){
        return $this->hasOne('Coa', 'ACNT_CODE', 'ACCNT_CODE');
    }

}