<?php

namespace App\Enum;

use ReflectionEnum;

enum ChequeNumberStatus: int
{
    case Used      =   0;
    case Unused    =   1;

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
     * [get case object by value]
     *
     * @return [type]
     *
     */
    public static function getByValue($value){
        foreach(self::cases() as  $item){
            if($item->value == $value){
                $itemValue = $item->name;
                break;
            }
        }
        return $itemValue;
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function toString(){
        return match($this){
            self::Used=>"Used",
            self::Unused=>"Unused",
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
            self::Used=>"success",
            self::Unused=>"warning",
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
