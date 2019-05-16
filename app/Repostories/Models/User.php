<?php namespace App\Repostories\Models;
use App\Repostories\Eloquent\UserModel;
/**
 * auther 刘岩
 *
 * */
class User extends UserModel{
    function model(){
        return 'App\Models\User';
    }
}