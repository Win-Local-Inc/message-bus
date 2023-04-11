<?php

namespace WinLocal\MessageBus\Tests\Feature;

use Aws\History;
use Aws\Middleware;
use Aws\MockHandler;
use Aws\Result;
use Ramsey\Uuid\Uuid;
use WinLocal\MessageBus\Contracts\MessageClientInterface;
use WinLocal\MessageBus\Enums\Subject;
use WinLocal\MessageBus\Jobs\SqsGetJob;
use WinLocal\MessageBus\Tests\TestCase;

class WinLocalEventBusTest extends TestCase
{
    public function testAdvertCreateEventBusSuccess()
    {
        $history = $this->mockAws(4);
        $userId = Uuid::uuid4()->toString();
        $workspaceId = Uuid::uuid4()->toString();
        SqsGetJob::dispatch(
            Subject::AdvertCreated->value,
            [
                'context_id' => $userId,
                'context' => ['type' => 'Advert'],
                'user_id' => $userId,
                'workspace_id' => $workspaceId,
                'data' => [
                    'user_id' => $userId,
                    'workspace_id' => $workspaceId,
                ],
            ]
        );

        $data = $history->getLastCommand()->toArray();
        $message = json_decode($data['Message']);
        $this->assertEquals(Subject::AdvertUpdated->value, $data['Subject']);
        $this->assertEquals($message->data->workspace_id, $workspaceId);
    }

    protected function mockAws(int $times = 1): History
    {
        $messageClient = resolve(MessageClientInterface::class);
        $handlerList = $messageClient->getSnsClient()->getHandlerList();

        $mock = new MockHandler();
        while ($times-- > 0) {
            $mock->append(new Result(['message' => 'success']));
        }
        $handlerList->setHandler($mock);

        $history = new History();
        $handlerList->appendSign(Middleware::history($history));

        $this->instance(MessageClientInterface::class, $messageClient);

        return $history;
    }
}
