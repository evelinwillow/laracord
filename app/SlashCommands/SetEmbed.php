<?php

namespace App\SlashCommands;

use Illuminate\Support\Str;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Command\Option;

use Laracord\Commands\SlashCommand;

use App\Models\Embeds;

class SetEmbed extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'setembed';

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
            'name' => 'linkurl',
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
        [
            'name' => 'imageurl',
            'description' => 'Url for embedded image',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'thumbnailurl',
            'description' => 'Url for thumbnail image.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'footercontent',
            'description' => 'Content of the footer.',
            'type' => Option::STRING,
            'required' => false,
        ],
        [
            'name' => 'footerurl',
            'description' => 'Url of the footer link',
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

//    protected $guild = '905167903224123473';
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

        $default = null;

        $titleBuffer        = $this->value('title',         $default );
        $contentBuffer      = $this->value('content',       $default );
        $bodyBuffer         = $this->value('body',          $default );
        $color              = $this->value('color',         $default );
        $linkBuffer         = $this->value('linkurl',      $default );
        $timestamp          = $this->value('timestamp',     $default );
        $imageUrlBuffer     = $this->value('imageurl',     $default );
        $thumbnailUrlBuffer = $this->value('thumbnailurl', $default );
        $footerContent      = $this->value('footercontent', $default );
        $footerUrl          = $this->value('footerurl', $default );

        $template_name      = $this->value('template', $default = 'default template' );

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

        $values = collect ([
            'title'             => Str::is('null', $titleBuffer)    ? ' ' : $titleBuffer,
            'content'           => Str::is('null', $contentBuffer)  ? ' ' : $contentBuffer,
            'body'              => Str::is('null', $bodyBuffer)     ? ' ' : $bodyBuffer,
            'color'             => $color,
            'link_url'          => Str::isUrl($linkBuffer)          ? $linkBuffer : '',
            'timestamp'         => $timestamp,
            'image_url'         => Str::isUrl($imageUrlBuffer)      ? $imageUrlBuffer : '',
            'thumbnail_url'     => Str::isUrl($thumbnailUrlBuffer)  ? $thumbnailUrlBuffer : '',
            'footer_content'    => Str::is('null', $footerContent)  ? ' ' : $footerContent,
            'footer_url'        => Str::isUrl($footerUrl)           ? $footerUrl : '',
        ])->filter( fn ($value) => filled($value));

        $embed->update($values->all());

        $values = $values
            ->map(fn ($value) => is_bool($value) ? ($value ? 'True' : 'False') : $value)
            ->map(fn ($value, $key) => "**{$key}**: {$value}")
            ->implode("\n");


        $message
            ->title('Updated template!')
            ->content("Changed:\n{$values}");

            $message->reply($interaction, true);
    }
}
