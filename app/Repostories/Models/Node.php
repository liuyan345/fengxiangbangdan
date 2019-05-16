<?php
namespace App\Repostories\Models;
//use App\Repostories\Eloquent\NodeModel;
use App\Repostories\Eloquent\NodeModel;
/**
 * auther 刘岩
 *
 * */
class Node extends NodeModel{
    function model(){
        return 'App\Models\Node';
    }
}