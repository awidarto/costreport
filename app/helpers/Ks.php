<?php

class Ks {

    public static function normalphone($number){
        $numbers = explode('/',$number);
        if(is_array($numbers)){
            $nums = array();
            foreach($numbers as $number){

                $number = str_replace(array('-',' ','(',')','[',']','{','}'), '', $number);

                if(preg_match('/^\+/', $number)){
                    if( preg_match('/^\+62/', $number)){
                        $number = preg_replace('/^\+62|^620/', '62', $number);
                    }else{
                        $number = preg_replace('/^\+/', '', $number);
                    }
                }else if(preg_match('/^62/', $number)){
                    $number = preg_replace('/^620/', '62', $number);
                }else if(preg_match('/^0/', $number)){
                    $number = preg_replace('/^0/', '62', $number);
                }

                $nums[] = $number;
            }
            $number = implode('/',$nums);
        }else{

            $number = str_replace(array('-',' ','(',')'), '', $number);

            if(preg_match('/^\+/', $number)){
                if( preg_match('/^\+62/', $number)){
                    $number = preg_replace('/^\+62|^620/', '62', $number);
                }else{
                    $number = preg_replace('/^\+/', '', $number);
                }
            }else if(preg_match('/^62/', $number)){
                $number = preg_replace('/^620/', '62', $number);
            }else if(preg_match('/^0/', $number)){
                $number = preg_replace('/^0/', '62', $number);
            }
        }

        return $number;
    }

    public static function dec2($in){
        return number_format((double) $in,2,',','.');
    }

    public static function idr($in){
        return number_format((double) $in,2,',','.');
    }

    public static function usd($in){
        return number_format((double) $in,0,'.',',');
    }

    public static function roi($prop){
        $roi = ((12*$prop['monthlyRental']) - $prop['tax'] - $prop['insurance'] - ( (12*$prop['monthlyRental']) / 10 )) / $prop['listingPrice'];
        return number_format( $roi * 100, 1,'.',',');
    }

    public static function can($action, $entity){
        $roleid = Auth::user()->roleId;
        $role = Role::find($roleid);
        if($role){
            if($role->{$entity.'_'.$action} == 'on'){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
}

