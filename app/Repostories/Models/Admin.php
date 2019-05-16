<?php namespace App\Repostories\Models;
use App\Repostories\Eloquent\AdminModel;
/**
 * auther 刘岩
 *
 * */
class Admin extends AdminModel{
    function model(){
        return 'App\Models\Admin';
    }
}