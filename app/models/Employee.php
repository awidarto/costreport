<?php
use Jenssegers\Mongodb\Model as Eloquent;

class Employee extends Eloquent {

    protected $collection = 'employees';

}