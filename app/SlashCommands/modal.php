<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Laracord\Commands\SlashCommand;
use Discord\Helpers\Collection;

class modal extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'modal';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'The Modal slash command.';

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
        $this
    ->modal('Create Ticket')
    ->text('Title', placeholder: 'Enter a title.', minLength: 2, maxLength: 32, required: true)
    ->paragraph('Description', placeholder: 'Please describe the issue in detail.', minLength: 5, maxLength: 256, required: true)
    ->submit(fn ($interaction, $components) => $this->createTicket($interaction, $components))
    ->show($interaction);
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
protected function createTicket(Interaction $interaction, Collection $components)
{
    $title = $components->get('custom_id', 'title')->value;
    $description = $components->get('custom_id', 'description')->value;


    return $this->message("Your ticket with name $title and description $description has been created.")->reply($interaction, ephemeral: true);
}
}
