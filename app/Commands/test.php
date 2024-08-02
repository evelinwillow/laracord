<?php

namespace App\Commands;

use Discord\Parts\Interactions\Interaction;
use Laracord\Commands\Command;

class test extends Command
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'test';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'sudo rm -rf /';

    /**
     * Determines whether the command requires admin permissions.
     *
     * @var bool
     */
    protected $admin = true;

    /**
     * Determines whether the command should be displayed in the commands list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * Handle the command.
     *
     * @param  \Discord\Parts\Channel\Message  $message
     * @param  array  $args
     * @return void
     */
    public function handle($message, $args)
    {
        return $this
            ->message()
            ->title('Test')
            ->content('Hello world!')
            ->button('👋', route: 'wave')
            ->send($message);
    }

    /**
     * The command interaction routes.
     */
    public function interactions(): array
    {
        return [
            'wave' => fn (Interaction $interaction) => $this->message('👋')->reply($interaction),
        ];
    }
}
