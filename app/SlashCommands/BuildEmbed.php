<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Command\Option;
use Laracord\Commands\SlashCommand;


use App\Models\Embeds;

class BuildEmbed extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'build_embed';

    /**
     * The guild the command belongs to.
     *
     * @var string
     */

    protected $guild = '905167903224123473';

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

    public function sendStatusMessage ($interaction, $template, $embed)
    {
         $statusMessage =
            $this
                ->message()
                ->content("# Embed editor")
                ->field("Name: ",           $template,                          true)
                ->field("ID: ",             $embed->id,                         true)
                ->field(" ",                " ",                                true)
                ->field("User: ",           $interaction->user->global_name,    true)
                ->field("ID: ",             $interaction->user->id,             true)
                ->field(" ",                " ",                                true)
                ->field("Title: ",          $embed->title,                      true)
                ->field("Link Url: ",       $embed->link_url,                   true)
                ->field(" ",                " ",                                true)
                ->field("Content: ",        $embed->content,                    false)
                ->field("Color: ",          $embed->color,                      false)
                ->field(" ",                " ",                                true)
                ->field(" ",                " ",                                true)
                ->field(" ",                " ",                                true)
                ->field("footerText: ",     $embed->footerText,                 false)
                ->field("footerUrl: ",      $embed->footerUrl,                  true)
                ->field("imageUrl: ",       $embed->image_url,                  false)
                ->field("thumbnailUrl: ",   $embed->thumbnail_url,              false)
                ->button('Collapse',        route: "collapse")
                ->button('Build',           route:"build:$template");

        $interaction->respondWithMessage(
            $statusMessage
                ->build(),
            ephemeral: true
        );
    }

    public function sendEmbed ($interaction, $template)
    {
        $embed = Embeds::where('discord_id', $interaction->user->id)
            ->where('template', $template)
            ->first();

        $embedMessage =
            $this
                ->message();

        if ( is_null ( $embed ) )
        {
            $embedMessage
                ->content('No embed with template name ' . $template . ' found!')
                ->body("<@$interaction->user->id>")
                ->error();
        } else {
            $embedMessage
                ->title     ( $embed->title     )
                ->content   ( $embed->content   )
                ->url       ( $embed->link_url  )
                ->color     ( $embed->color     )
                ->footerText( $embed->footer_content )
                //->footerUrl ( $embed->footer_url )
                ->imageUrl  ( $embed->image_url)
                ->thumbnailUrl( $embed->thumbnail_url);

            if ( $embed->timestamp )
                $embedMessage
                    ->timestamp(now());

            if ( ! is_null ( $embed->body ) )
                $embedMessage
                    ->body( $embed->body );
        }

        $interaction->sendFollowupMessage(
            $embedMessage
                ->build(),
            ephemeral: true
        );

    }

    public function handle($interaction)
    {
        $default = 'default template';
        $template = $this->value('template', $default);

        $embed = Embeds::where('discord_id', $interaction->user->id)
            ->where('template', $template)
            ->first();

        $this->sendStatusMessage($interaction, $template, $embed);
        $this->sendEmbed($interaction, $template, $embed);

    }

    public function interactions(): array
    {
        return [
            'collapse' => fn (Interaction $interaction) => $interaction->acknowledge() && $this->collapse($interaction),
            'build' => fn (Interaction $interaction) => $this->collapse($interaction),
        ];

    }

    protected function collapse (Interaction $interaction) : void
    {
            $this
                ->message('Test')
                ->reply($interaction);
    }
}
