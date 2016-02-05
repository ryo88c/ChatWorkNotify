<?php
/**
 * This file is part of the Ryo88c\ChatWorkNotify package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Ryo88c\ChatWorkNotify\Resource\App;

use BEAR\Resource\ResourceObject;
use Ryo88c\ChatWorkNotify\Inject\ApiInject;
use BEAR\Resource\Exception\BadRequestException;

class Unread extends ResourceObject
{
    use ApiInject;

    /**
     * @return $this
     */
    public function onGet()
    {
        if (!isset($this->uri->query['subscriber'])) {
            throw new BadRequestException('Parameter: "subscriber" not found.');
        }

        $unReadMessages = $unReadRooms = [];
        $res = $this->chatWorkApi->get->uri('app://self/rooms')->eager->request();
        foreach ($res->body['result'] as $room) {
            if ($room['unread_num'] > 0) {
                $unReadRooms[$room['room_id']] = $room['name'];
            }
        }

        if (empty($unReadRooms)) {
            $res = $this->smsApi->post->uri('app://self/smsmessaging')->withQuery([
                'subscriber' => $this->uri->query['subscriber'],
                'address' => '0' . $this->uri->query['subscriber'],
                'message' => 'Wala po.',
            ])->eager->request();
            $this['result'] = $res->body['result'];
            return $this;
        }

        foreach ($unReadRooms as $roomId => $roomName) {
            $res = $this->chatWorkApi->get->uri(sprintf('app://self/rooms/%d/messages', $roomId))->eager->request();
            $unReadMessages[$roomId] = [];
            foreach ($res->body['result'] as $message) {
                $sent = date('Y-m-d H:i:s', empty($message['update_time']) ? $message['send_time'] : $message['update_time']);
                $unReadMessages[$roomId][$message['message_id']] = sprintf(
                    '%s says: "%s" at %s', $message['account']['name'], $message['body'], $sent
                );
            }
        }

        $messages = [];
        foreach ($unReadMessages as $roomId => $message) {
            if (empty($message)) {
                continue;
            }
            $messages[] = sprintf("In %s\n\n%s", $unReadRooms[$roomId], implode("\n", $message));
        }

        if (empty($messages)) {
            $res = $this->smsApi->post->uri('app://self/smsmessaging')->withQuery([
                'subscriber' => $this->uri->query['subscriber'],
                'address' => '0' . $this->uri->query['subscriber'],
                'message' => 'Wala po.',
            ])->eager->request();
            $this['result'] = $res->body['result'];
            return $this;
        }

        $res = $this->smsApi->post->uri('app://self/smsmessaging')->withQuery([
            'subscriber' => $this->uri->query['subscriber'],
            'address' => '0' . $this->uri->query['subscriber'],
            'message' => implode("\n----\n\n", $messages),
        ])->eager->request();
        $this['result'] = $res->body['result'];
        return $this;
    }
}
