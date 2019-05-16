<?php namespace App\Repostories\Models;
use App\Repostories\Eloquent\RoleModel;
/**
 * auther 刘岩
 *
 * */
class Role extends RoleModel{
    function model(){
        return 'App\Models\Role';
    }
}