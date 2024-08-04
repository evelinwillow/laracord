<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Command\Option;
use Laracord\Commands\SlashCommand;

use App\Models\Embeds;

class build_embed extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'build_embed';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'The Build_embed slash command.';

    /**
     * The command options.
     *
     * @var array
     */
    protected $options = [
        [
            'name' => 'template',
            'description' => 'template to print',
            'type' => Option::STRING,
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

        $template = $this->value('template', $default = 'default template');

        $embed = Embeds::where('discord_id', $userID)
            ->where('template', $template)
            ->first();

        $message =
            $this
                ->message();

        if ( is_null ( $embed ) )
        {
            $message
                ->content('No embed with template name ' . $template . ' found!')
                ->body("<@$userID>")
                ->error();
        } else {
            $message
                ->title     ( $embed->title     )
                ->content   ( $embed->content   )
                ->url       ( $embed->link_url  )
                ->color     ( $embed->color     )
                ->footerText( $embed->footer_content )
                //->footerUrl ( $embed->footer_url )
                ->imageUrl  ( $embed->image_url)
                ->thumbnailUrl( $embed->thumbnail_url);

            if ( $embed->timestamp )
                $message
                    ->timestamp(now());

            if ( ! is_null ( $embed->body ) )
                $message
                    ->body( $embed->body );
        }

        $interaction->respondWithMessage(
            $message
                ->build()
        );
    }
}
