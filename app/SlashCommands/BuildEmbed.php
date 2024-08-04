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
    protected $name = 'buildembed';

    /**
     * The guild the command belongs to.
     *
     * @var string
     */

//    protected $guild = '905167903224123473';

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

    public function expandStatusMessage ($interaction, $template)
    {
         $embed = Embeds::where('discord_id', $interaction->user->id)
            ->where('template', $template)
            ->first();

        return
            $this
                ->message()
                ->title("Embed editor")
                ->field("Name: ",           $template,                                  true)
                ->field("ID: ",             $embed->id,                                 true)
                ->field(" ",                " ",                                        true)
                ->field("User: ",           $interaction->user->global_name,            true)
                ->field("ID: ",             $interaction->user->id,                     true)
                ->field(" ",                " ",                                        true)
                ->field("Title: ",          $embed->title,                              true)
                ->field("Link Url: ",       $embed->link_url,                           true)
                ->field(" ",                " ",                                        true)
                ->field('Body: ',           str_replace('\n', "\n", $embed->body) ,     false)
                ->field("Content: ",        str_replace('\n', "\n", $embed->content) ,  false)
                ->field("Color: ",          $embed->color,                              false)
                ->field(" ",                " ",                                        true)
                ->field(" ",                " ",                                        true)
                ->field(" ",                " ",                                        true)
                ->field("footerText: ",     $embed->footerText,                         false)
                ->field("footerUrl: ",      $embed->footerUrl,                          true)
                ->field("imageUrl: ",       $embed->image_url,                          false)
                ->field("thumbnailUrl: ",   $embed->thumbnail_url,                      false)
                ->button('Collapse',        route: "collapse:$template")
                ->button('Build',           route: "build:$template")
                ->button('Reload',          route: "reload:$template")
                ->button('Delete',          route: "delete");
    }

    public function collapseStatusMessage ($template)
    {
        return
            $this
                ->message()
                ->title('Embed Builder')
                ->content('Hit \'expand\' for additional information!')
                ->button('Expand',          route: "expand:$template")
                ->button('Build',           route: "build:$template")
                ->button('Delete',          route: "delete");
    }

    public function sendStatusMessage ($interaction, $template)
    {
        $statusMessage = $this->expandStatusMessage($interaction, $template);

        $statusMessage->editOrReply($interaction);
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
                ->authorName($interaction->user->global_name)
                ->authorIcon($interaction->user->avatar)
                ->title     ( $embed->title     )
                ->content   ( str_replace('\n', "\n", $embed->content ) )
                ->url       ( $embed->link_url  )
                ->color     ( $embed->color     )
                ->footerText( $embed->footer_content )
                //->footerUrl ( $embed->footer_url )
                ->imageUrl  ( $embed->image_url)
                ->thumbnailUrl( $embed->thumbnail_url);
                //->button ('Delete', route: "deleteEmbed");

            if ( $embed->timestamp )
                $embedMessage
                    ->timestamp(now());

            if ( ! is_null ( $embed->body ) )
                $embedMessage
                    ->body( str_replace('\n', "\n", $embed->body) );
        }

        $embedMessage->reply($interaction);
    }

    public function handle($interaction)
    {
        $default = 'default template';
        $template = $this->value('template', $default);

        $embed = Embeds::where('discord_id', $interaction->user->id)
            ->where('template', $template)
            ->first();

        $this->sendStatusMessage($interaction, $template, $embed);
    }

    public function interactions(): array
    {
        return [
            'collapse:{template}' => fn (Interaction $interaction, string $template) => $this->collapse($interaction, $template),
            'expand:{template}' => fn (Interaction $interaction, string $template) => $this->expand($interaction, $template),
            'build:{template}' => fn (Interaction $interaction, string $template) => $this->sendEmbed($interaction, $template),
            'reload:{template}' => fn (Interaction $interaction, string $template) => $this->expand($interaction, $template),
            'delete' => fn (Interaction $interaction) => $this->deleteEmbed($interaction),
            'deleteEmbed' => fn (Interaction $interaction) => $this->deleteEmbed($interaction),
        ];

    }

    protected function collapse (Interaction $interaction, string $template) : void
    {
        $this
            ->collapseStatusMessage($template)
            ->editOrReply($interaction);
    }

    protected function deleteEmbed (Interaction $interaction) : void
    {
        $interaction
            ->message->delete();

    }

    protected function expand (Interaction $interaction, string $template) : void
    {
            $this
                ->expandStatusMessage($interaction, $template)
                ->editOrReply($interaction);
    }
}
