<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Laracord\Commands\SlashCommand;

class test extends SlashCommand
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
    protected $description = 'aaaaaa';

    /**
     * The command options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The permissions required to use the command.
     *
     * @var array
     */
    protected $permissions = [];

    /**
     * Indicates whether the command requires admin permissions.
     *
     * @var bool
     */
    protected $admin = true;

    /**
     * Indicates whether the command should be displayed in the commands list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * Handle the slash command.
     *
     * @param  \Discord\Parts\Interactions\Interaction  $interaction
     * @return mixed
     */
    public function handle($interaction)
    {
        $interaction->respondWithMessage(
            $this
              ->message()
              ->title('Test')
              ->content('Hello world!')
              ->button('👋', route: 'wave')
              ->build()
        );
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
