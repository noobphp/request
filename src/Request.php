<?php
namespace Noob\Http;

use Noob\Http\Lib\RequestDataParse;
/**
 * Created by PhpStorm.
 * User: pxb
 * Date: 2018-06-27
 * Time: 10:56
 */


class Request
{
    protected $all = [];
    protected $input = "";

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function isPost()
    {
        return $this->getRequestMethod() === 'POST';
    }

    public function isGet()
    {
        return $this->getRequestMethod() === 'GET';
    }

    public function isPut()
    {
        return $this->getRequestMethod() === 'PUT';
    }

    public function isDelete()
    {
        return $this->getRequestMethod() === 'DELETE';
    }

    public function getInput()
    {
        if (empty($this->input)) {
            $this->input = file_get_contents('php://input');
        }
        return $this->input;
    }

    public function getAllArray()
    {
        if (empty($this->all)) {
            $input = json_decode($this->getInput(), true) ?: [];
            $this->all = array_merge($_REQUEST, $input);
            //如果是空字符串设置值为null
            foreach ($this->all as $key => $value) {
                if ($value === '') {
                    $this->all[$key] = null;
                }
            }
        }
        return $this->all;
    }

    public function getAll()
    {
        return new RequestDataParse($this->getAllArray());
    }

    public function only(array $filter)
    {
        $data = $this->getAllArray();
        $data = array_filter($data, function ($key) use ($filter) {
            return in_array($key, $filter);
        }, ARRAY_FILTER_USE_KEY);
        return new RequestDataParse($data);
    }

    public function isWeiXinClient()
    {
        return (false !== strpos($this->getUserAgent(), 'MicroMessenger'));
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        $all = $this->getAllArray();
        return isset($all[$name]) ? $all[$name] : null;
    }

    /**
     * 添加此魔术方法原因是在某些情况下需要判断属性是否为空或者存在
     * 而isset() or empty()会触发的是此__isset魔术方法并不会触发__get
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        // TODO: Implement __isset() method.
        return isset($this->getAllArray()[$name]);
    }
}
