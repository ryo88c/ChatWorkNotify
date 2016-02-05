<?php

namespace Ryo88c\ChatWorkNotify\Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * Class Logger
 * @Annotation
 * @Target("METHOD")
 * @package Ryo88c\ChatWorkNotify\Interceptor
 */
class Logger implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        $result = $invocation->proceed();
        file_put_contents(
            sprintf('%s/var/log/resource.%d.log', dirname(dirname(__DIR__)), date('Ymd')),
            sprintf("[%s]\n%s\n\n", date('H:i:s'), var_export([
                'resource' => (array)$invocation->getThis()->uri,
                'result' => $result,
                'body' => file_get_contents('php://input'),
                'server' => $_SERVER,
                'get' => $_GET,
                'post' => $_POST,
            ], true)),
            FILE_APPEND
        );
        return $result;
    }
}
