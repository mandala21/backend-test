<?php
    namespace App\Helper;


    class ItensValue{
        public static function getValue($item){
            $valueItens = [
                4, //water
                3, //food
                2, //kit med
                1, //ammunition
            ];

            return $valueItens[$item-1];
        }
    } 
    