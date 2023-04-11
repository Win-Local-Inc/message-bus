<?php

namespace WinLocal\MessageBus\Tests\Feature;

use Aws\History;
use Aws\Middleware;
use Aws\MockHandler;
use Aws\Result;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Finder\SplFileInfo;
use WinLocal\MessageBus\Contracts\HandlerResolverInterface;
use WinLocal\MessageBus\Contracts\MessageClientInterface;
use WinLocal\MessageBus\Enums\Subject;
use WinLocal\MessageBus\Jobs\SqsGetJob;
use WinLocal\MessageBus\Providers\HandlerResolver;
use WinLocal\MessageBus\Tests\TestCase;

class WinLocalEventBusTest extends TestCase
{
    public function testAdvertCreateEventBusSuccess()
    {
        $this->setUpHandlerResolver();
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
        $this->assertEquals(Subject::AdvertCreated->value, $data['Subject']);
        $this->assertEquals($message->data->workspace_id, $workspaceId);
    }

    public function testAudienceCreateEventBusSuccess()
    {
        $this->setUpHandlerResolver();
        $history = $this->mockAws(4);
        $userId = Uuid::uuid4()->toString();
        $workspaceId = Uuid::uuid4()->toString();
        SqsGetJob::dispatch(
            Subject::AudienceCreated->value,
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
        $this->assertEquals(Subject::AudienceCreated->value, $data['Subject']);
        $this->assertEquals($message->data->workspace_id, $workspaceId);
    }

    protected function setUpHandlerResolver(): void
    {
        $resolveMock = new class() extends HandlerResolver
        {
            protected function getAllFiles(string $path): array
            {
                return File::allFiles(__DIR__.'/../'.$path);
            }

            protected function createClassName(SplFileInfo $file): string
            {
                return 'WinLocal\\MessageBus\\Tests\\Data\\Handlers\\'.$file->getFilenameWithoutExtension();
            }
        };

        $this->instance(HandlerResolverInterface::class, $resolveMock);
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
