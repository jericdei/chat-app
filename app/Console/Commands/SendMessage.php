<?php

namespace App\Console\Commands;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to Echo.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        $senderId = select('Select the sender', $users->pluck('name', 'id'));
        $receiverId = select('Select the receiver', $users->pluck('name', 'id'));
        $value = text('Enter the message');

        $message = Message::create([
            'from' => $users->first(fn ($user) => $user->id === $senderId),
            'to' => $users->first(fn ($user) => $user->id === $receiverId),
            'value' => $value
        ]);

        MessageSent::dispatch($message);

        info('Message sent.');
    }
}
