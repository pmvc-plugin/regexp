<?php
namespace PMVC\PlugIn\regexp;
use SelvinOrtiz\Utils\Flux\Flux;
use ReflectionMethod;

// \PMVC\l(__DIR__.'/xxx.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\regexp';

class regexp extends \PMVC\PlugIn
{
    public function gen(...$params)
    {
       $o = Flux::getInstance(); 
       foreach($params as $v){
           $funcName = array_shift($v);
           $func = array($o,$funcName);
           if (is_callable($func)) {
               call_user_func_array($func, $v);
           } else {
               trigger_error($funcName. ' is not acceptable');
           }
       }
       return (string)$o;
    }

    public function checkCommand(...$params)
    {
       $o = Flux::getInstance(); 
       $fail = array();
       if (!is_array($params)) {
            $fail[]=$params;
            return $fail;
       }
       foreach($params as $v){
           if (!is_array($v)) {
                $fail[] = $v;
                continue;
           }
           $funcName = array_shift($v);
           $func = array($o,$funcName);
           if (!is_callable($func)) {
               $fail[] = $funcName;
           } else {
               $reflection = new ReflectionMethod($o, $funcName);
               $parameters = $reflection->getParameters();
               $params = array();
               foreach($parameters as $p){
                   if (!$p->isdefaultvalueavailable()) {
                        $params[] =$p;
                   }
               }
               if ( count($params) > count($v) ) {
                    $fail[] = array($funcName,$v);
               }
           }
        }
        return $fail;
    }
}
