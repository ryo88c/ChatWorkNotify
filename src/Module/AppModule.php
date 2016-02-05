<?php

namespace Ryo88c\ChatWorkNotify\Module;

use BEAR\Package\PackageModule;
use Ray\Di\AbstractModule;
use josegonzalez\Dotenv\Loader as Dotenv;
use Ryo88c\ChatWorkNotify\Interceptor\Logger;
use BEAR\Resource\ResourceObject;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $dotEnvPath = dirname(dirname(__DIR__)) . '/.env';
        if (file_exists($dotEnvPath) && is_readable($dotEnvPath)) {
            Dotenv::load([
                'filepath' => $dotEnvPath,
                'toEnv' => true
            ]);
        }
        $this->install(new PackageModule);
        $this->bindInterceptor(
            $this->matcher->SubclassesOf(ResourceObject::class),
            $this->matcher->any(),
            [Logger::class]
        );
    }
}
