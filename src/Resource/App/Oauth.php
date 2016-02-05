<?php
/**
 * This file is part of the Ryo88c\ChatWorkNotify package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ryo88c\ChatWorkNotify\Resource\App;

use BEAR\Resource\ResourceObject;
use Ryo88c\ChatWorkNotify\Inject\ApiInject;

class Oauth extends ResourceObject
{
    use ApiInject;

    public function onGet()
    {
        $res = $this->smsApi->get->uri('app://self/oauth')->withQuery($this->uri->query)->eager->request();
        $this['result'] = $res->body['result'];
        return $this;
    }
}
