<?php

	namespace App\Khan\Component\Router\Http;
  use \App\Khan\Component\HttpFoundation\Request as RequestFoundation;
  use \App\Khan\Component\Router\Http\Interfaces\Request as RequestInterface;

	/**
	* Request Class and Interface Implement
	*/

	class Request extends RequestFoundation implements RequestInterface{

    private static $data = [];

      public function __construct(Array $reqs = array(), $uri = ''){
        $this->makeRequests();
        parent::__construct($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);
        self::$data = $this->infoFile($reqs);
        $this->current_uri = $uri;
        $this->class_name = __CLASS__;
      }

      public function infoFile($data){
        foreach ($data['files'] as $key => $file) {
          $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
          $data["files"][$key]["ext"] = $ext;
          $data["files"][$key]["newName"] = function($name) use($ext){
             return $name.".".$ext;
          };
        }
        return $data;
      }

      public function makeRequests(){
        if(is_null($_GET)): $_GET = []; endif;
        if(is_null($_POST)): $_POST = []; endif;
        if(isset($_PUT) && is_null($_PUT)): $_PUT = []; endif;
        if(isset($_DELETE) && is_null($_DELETE)): $_DELETE = []; endif;
        if(is_null($_SERVER)): $_SERVER = []; endif;
        if(is_null($_COOKIE)): $_COOKIE = []; endif;
        if(is_null($_FILES)): $_FILES = []; endif;
      }

      public static function getAll(){
          return self::$data;
      }

      public static function make($name = null, $key, $value){
          self::$data[$name][$key] = $value;
      }

      public static function validateValue($type, $value){
        return in_array($value, self::$data[$type]);
      }

      public static function validateType($type, $value){
        $retorno = '';
        if(in_array($type, self::$data)){
          $retorno = Request::validateValue($type, $value);
        }
        return $retorno;
      }

      public static function post($name = null){
        $validate = Request::validateValue("post", $name);
        if($validate && $name !== null){ return false; }
        if($name == null){
          return self::$data["post"];
        }else{
          return self::$data["post"][$name];
        }
        return false;
      }

      public static function query($name = null){
        $validate = Request::validateValue("get", $name);
        if($validate && $name !== null){ return false; }
        if($name == null){
          return self::$data["get"];
        }else{
          return self::$data["get"][$name];
        }
        return false;
      }

      public static function files($name = null){
        $validate = Request::validateValue("files", $name);
        if($validate && $name !== null){ return false; }
        if($name == null){
          return self::$data["files"];
        }else{
          return self::$data["files"][$name];
        }
        return false;
      }

      public static function put($name = null){
        $validate = Request::validateValue("put", $name);
        if($validate && $name !== null){ return false; }
        if($name == null){
          return self::$data["put"];
        }else{
          return self::$data["put"][$name];
        }
        return false;
      }

      public static function delete($name = null){
        $validate = Request::validateValue("delete", $name);
        if($validate && $name !== null){ return false; }
        if($name == null){
          return self::$data["delete"];
        }else{
          return self::$data["delete"][$name];
        }
        return false;
      }

      public static function params($name = null){
        $validate = Request::validateValue("params", $name);
        if($validate && $name !== null){ return false; }
        if($name == null){
          return self::$data["params"];
        }else{
          return self::$data["params"][$name];
        }
        return false;
      }

      public static function session($name = null){
        $validate = Request::validateValue("session", $name);
        if($validate && $name !== null){ return false; }
        if($name == null){
          return self::$data["session"];
        }else{
          return self::$data["session"][$name];
        }
        return false;
      }

	}
