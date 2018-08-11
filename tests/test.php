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

var_dump($request->getRequestMethod());
var_dump($request->getAll()->toArray());
var_dump($request->only(['a','c','d'])->toArray());
var_dump($request->getInput());
