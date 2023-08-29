<?php

class Validate 
{
    public static function validateDate($value){
         if(preg_match('/^20\d{2}(-|\/)((0[1-9])|(1[0-2]))(-|\/)((0[1-9])|([1-2][0-9])|(3[0-1]))(T)(09|(1[0-7])):([0-5][0-9])$/', $value)){
            if (date_create($value)->format('N') > 5) {
                return false;
            }
            return $value;
         }
         return false;
    }

    public static function validateTime($value){
        if(preg_match('/^[0-9]+$/', $value)) {
            return $value;
        }
        return false;
    }
}