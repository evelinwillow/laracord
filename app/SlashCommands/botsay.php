<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Command\Option;
use Laracord\Commands\SlashCommand;

use App\Models\Embed;

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
            'required' => false,
        ],
        [
            'name' => 'message',
            'description' => 'Message content.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'body',
            'description' => 'The message body.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'color',
            'description' => 'The embed color',
            'type' => Option::INTEGER,
            'required' => false,
        ],
        [
            'name' => 'url',
            'description' => 'Title link',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'timestamp',
            'description' => 'Include timestamp?',
            'type' => Option::BOOLEAN,
            'required' => false,
        ],
    ];

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
        $titleBuffer =
            $this
                ->value('title');
        $messageBuffer =
            $this
                ->value('message');
        $bodyBuffer =
            $this
                ->value('body', $default = null);
        $color =
            $this
                ->value( 'color', $default = 16760025);
        $url =
            $this
                ->value( 'url', $default = 'https://evelin.website');
        $authorIcon =
            $interaction
                ->user->avatar;
        $authorName =
            $interaction
                ->user->global_name;
        $doTimestamp =
            $this
                ->value('timestamp', $default = false);

        $message =
            $this
                ->message()
                ->title($titleBuffer)
                ->content($messageBuffer)
                ->color($color)
                ->url($url)
                ->authorIcon($authorIcon)
                ->authorName($authorName);

        if ( $doTimestamp )
            $message
                ->timestamp(now());

        if ( ! is_null ( $bodyBuffer ) )
            $message
                ->body($bodyBuffer);

        $interaction -> respondWithMessage(
            $message
                -> build()
        );
    }
}
