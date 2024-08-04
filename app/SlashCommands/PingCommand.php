<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Laracord\Commands\SlashCommand;

class PingCommand extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'pingcommand';

    protected $guild = '905167903224123473';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'The Ping slash command.';

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
    protected $admin = false;

    /**
     * Indicates whether the command should be displayed in the commands list.
     *
     * @var bool
     */
    protected $hidden = false;

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
              ->title('Ping')
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
