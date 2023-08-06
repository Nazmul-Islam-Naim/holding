<?php

namespace App\Enum;

use ReflectionEnum;

enum Status: int
{
    case Active      =   1;
    case Inactive    =   2;
    case Suspended   =   3;
    case Pending     =   4;

    /**
     * [Will return cases name list]
     *
     * @return [array]
     *
     */
    public static function getCases(){
        return array_column(self::cases(), 'name');
    }

   /**
     * [return cases list with description]
     *
     * @return [array]
     *
     */
    public static function get(){
        foreach(array_column(self::cases(), 'name') as $item){
            $arr[$item]=self::getFromName($item)->toString();
        }
        return $arr;
    }

     /**
     * [get case object by name]
     *
     * @return [type]
     *
     */
    public static function getFromName($name){
        $reflection = new ReflectionEnum(self::class);
        return $reflection->getCase($name)->getValue();
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function toString(){
        return match($this){
            self::Active=>"Active",
            self::Inactive=>"Inactive",
            self::Pending=>"Pending",
            self::Suspended=>"Suspended",
        };
    }


    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function color(){
        return match($this){
            self::Active=>"success",
            self::Inactive=>"warning",
            self::Pending=>"info",
            self::Suspended=>"secondary",
        };
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function getRes(){
        return [
            "color"=>self::color(),
            "string"=>self::toString()
        ];
    }


}
