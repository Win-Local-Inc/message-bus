<?php

namespace WinLocal\MessageBus\Providers;

use Aws\Sns\SnsClient;
use WinLocal\MessageBus\Contracts\MessageClientInterface;
use WinLocal\MessageBus\Contracts\SubjectEnum;

class MessageClient implements MessageClientInterface
{
    protected SnsClient $sns;

    public function __construct(
        protected array $config
    ) {
        $this->sns = new SnsClient($this->config);
    }

    public function publish(SubjectEnum $subject, array $message): void
    {
        $this->sns->publish([
            'TopicArn' => $this->config['topic'],
            'Message' => json_encode($message),
            'Subject' => $subject->value,
        ]);
    }

    public function getSnsClient(): SnsClient
    {
        return $this->sns;
    }
}
