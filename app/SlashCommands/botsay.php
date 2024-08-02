<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Command\Option;
use Laracord\Commands\SlashCommand;

class botsay extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'botsay';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'The Botsay slash command.';

    /**
     * The command options.
     *
     * @var array
     */
    protected $options = [
        [
            'name' => 'title',
            'description' => 'Title of the message.',
            'type' => Option::STRING,
            'required' => true,
        ],
        [
            'name' => 'message',
            'description' => 'Message content.',
            'type' => Option::STRING,
            'required' => true,
        ],
    ];

    /**
     * The permissions required to use the command.
     *
     * @var array
     */
    protected $permissions = ['manage_guild'];

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
    protected $hidden = false;

    /**
     * Handle the slash command.
     *
     * @param  \Discord\Parts\Interactions\Interaction  $interaction
     * @return mixed
     */

    public function handle($interaction)
    {
        $titleBuffer = $this->value('title');
        $messageBuffer = $this->value('message', $default = 'message');

        $interaction->respondWithMessage(
            $this
              ->message()
              ->title($titleBuffer)
              ->content($messageBuffer)
              ->build()
        );
    }

}
