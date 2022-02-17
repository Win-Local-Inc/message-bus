<?php

namespace WinLocal\MessageBus\Jobs;

use Aws\Sdk;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SnsSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $subject;
    protected array $message;

    public function __construct(string $subject, array $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    public function handle()
    {
        try {
            $config = $this->getConfig();
            $sns = (new Sdk($config))->createClient('sns');
            $sns->publish([
                'TopicArn' => $config['topic'],
                'Message' => json_encode($this->message),
                'Subject' => $this->subject
            ]);
        } catch (Exception $exception) {
            Log::error('SnsSendJob '.$exception->getMessage(), [
                'exception' => $exception,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);
        }
    }

    protected function getConfig(): array
    {
        $config = config('queue.connections.sqs-sns');
        $config += [
            'credentials'=> Arr::only($config, ['key', 'secret']),
        ];
        return $config;
    }
}
