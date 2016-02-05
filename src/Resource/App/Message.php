<?php
/**
 * This file is part of the Ryo88c\ChatWorkNotify package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ryo88c\ChatWorkNotify\Resource\App;

use BEAR\Resource\ResourceObject;
use BEAR\Package\Bootstrap;
use BEAR\Sunday\Inject\ResourceInject;

class Message extends ResourceObject
{
    use ResourceInject;

    /**
     * @see https://docs.google.com/document/d/1xQYPFsWSnHY9htIYNL2bENLok8rbAgzxdXsFWbSwE80/pub?embedded=true#h.r4lfyo97cj35
     */
    public function onPost()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $body = $request['inboundSMSMessageList']['inboundSMSMessage'][0];
        $res = $this->resource->get->uri(sprintf('app://self/%s', strtolower($body['message'])))
            ->withQuery(['subscriber' => substr($body['senderAddress'], 7)])->eager->request();
        $this['result'] = $res->body['result'];
        return $this;
    }
}
