<?php

namespace App\Enum;

use ReflectionEnum;

enum TransactionType: int
{
    case Opening      =   1;
    case Deposit      =   2;
    case Withdraw     =   3;
    case Transfer     =   4;
    case Receive      =   5;
    case Payment      =   6;

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
    public static function getFromValue(int $value){
        foreach (Self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        
        return null;
    }

    /**
     * [Description for toString]
     *
     * @return [type]
     *
     */
    public function toString(){
        return match($this){
            self::Opening=>"Opening",
            self::Deposit=>"Deposit",
            self::Withdraw=>"Withdraw",
            self::Transfer=>"Transfer",
            self::Receive=>"Receive",
            self::Payment=>"Payment",
        };
    }


}
