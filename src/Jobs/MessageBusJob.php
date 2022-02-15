<?php

namespace WinLocal\MessageBus\Jobs;

use Aws\Laravel\AwsFacade;
use Illuminate\Bus\Queueable;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MessageBusJob implements ShouldQueue
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
            $sns = AwsFacade::createClient('sns');
            $sns->publish([
                'TopicArn' => config('messagebus.awsSnsTopic'),
                'Message' => json_encode($this->message),
                'Subject' => $this->subject
            ]);
        } catch (Exception $exception) {
            Log::error('MessageBusJob '.$exception->getMessage(), [
                'exception' => $exception,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);
        }
    }
}
