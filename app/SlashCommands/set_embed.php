<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Command\Option;
use Laracord\Commands\SlashCommand;

use App\Models\Embeds;

class set_embed extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'set_embed';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'The Set_embed slash command.';

    /**
     * The command options.
     *
     * @var array
     */
    protected $options = [
        [
            'name' => 'template',
            'description' => 'Name of the template slot',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'title',
            'description' => 'Title of the embed.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'content',
            'description' => 'Embed content.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'body',
            'description' => 'Message body.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'color',
            'description' => 'Embed color',
            'type' => Option::INTEGER,
            'required' => false,
        ],
        [
            'name' => 'link_url',
            'description' => 'Embed title URL.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'timestamp',
            'description' => 'Embed timestamp boolean.',
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
        $userID = $interaction->user->id;
        $userName = $interaction->user->global_name;

        $titleBuffer    = $this->value('title',         $default = null );
        $contentBuffer  = $this->value('content',       $default = null );
        $bodyBuffer     = $this->value('body',          $default = null );
        $color          = $this->value('color',         $default = null );
        $linkBuffer     = $this->value('link_url',      $default = null );
        $timestamp      = $this->value('timestamp',     $default = null );
        $template_name  = $this->value('template', $default = 'default template' );

        $message =
            $this
                ->message();

        $embed = Embeds::where( 'discord_id', $userID )
            ->where('template', $template_name )
            ->first();

        if ( is_null ( $embed ) )
            $embed = Embeds::create([
                'discord_id' => $userID,
            ]);

        $embed->template = $template_name;

        $message
            ->title("$template_name")
            ->content('Edited embed with name ' . $template_name . ' for user ' . $userName . ' with ID ' . $userID . ' !')
            ->body("<@$userID>")
            ->success();

            if ( ! is_null ( $titleBuffer ) )
                $embed->title = $titleBuffer;

            if ( ! is_null ( $contentBuffer ) )
                $embed->content = $contentBuffer;

            if ( ! is_null ( $bodyBuffer ) )
                $embed->body = $bodyBuffer;

            if ( ! is_null ( $color ) )
                $embed->color = $color;

            if ( ! is_null ( $linkBuffer ) )
                $embed->link_url = $linkBuffer;

            if ( ! is_null ( $timestamp ) )
                $embed->timestamp = $timestamp;

            $embed->save();

        $interaction->respondWithMessage(
            $message
                ->build()
        );
    }
}
