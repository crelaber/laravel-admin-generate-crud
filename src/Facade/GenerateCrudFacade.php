<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/11/4
 * Time: 16:09
 */
namespace App\Generate\Facade;
use Illuminate\Support\Facades\Facade;
class GenerateCrudFacade extends Facade{
    protected static function getFacadeAccessor(){
        return 'GenerateCrudService';
    }
}