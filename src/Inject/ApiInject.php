<?php
/**
 * This file is part of the Ryo88c\ChatWorkNotify package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ryo88c\ChatWorkNotify\Inject;

use BEAR\Package\Bootstrap;
use BEAR\Resource\ResourceInterface;

trait ApiInject
{
    private $chatWorkApi;

    private $smsApi;

    /**
     * @Ray\Di\Di\Inject
     */
    public function setClient(ResourceInterface $resource)
    {
        $this->chatWorkApi = (new Bootstrap)->getApp('Ryo88c\ChatWorkApiClient', 'prod-hal-api-app')->resource;
        $this->smsApi = (new Bootstrap)->getApp('Ryo88c\GlobeApiClient', 'prod-hal-api-app')->resource;
    }
}
