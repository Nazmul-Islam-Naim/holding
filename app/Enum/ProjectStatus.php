<?php

namespace App\Enum;

use ReflectionEnum;

enum ProjectStatus: int
{
    case Running      =   1;
    case Stop    =   2;
    case Complete    =   3;

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
            self::Runnig=>"Runnig",
            self::Stop=>"Stop",
            self::Complete=>"Complete",
            
        };
    }


}
