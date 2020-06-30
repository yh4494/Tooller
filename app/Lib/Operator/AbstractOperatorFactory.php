<?php


namespace App\Lib\Operator;


use App\Lib\BrowersOperator;

abstract class AbstractOperatorFactory
{
    const BROWERS_OPRATOR = 'browers';

    /**
     * 获取operator实例
     *
     * @param $data
     * @return BrowersOperator|null
     */
    public static function getFactory($data)
    {
        switch ($data) {
            case 'browers':
                return new BrowersOperator();
        }
        return null;
    }
}
