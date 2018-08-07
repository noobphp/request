<?php
require ("../vendor/autoload.php");

use Noob\Http\Request;

/**
 * Created by PhpStorm.
 * User: pxb
 * Date: 2018/8/7
 * Time: 下午8:46
 */

$request = new Request();

var_dump($request->getAll());
var_dump($request->getRequestMethod());
