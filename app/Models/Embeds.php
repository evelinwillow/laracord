<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embeds extends Model
{
    use HasFactory;

    protected $attributes = [
        'discord_id' => '',
        'template' => 'default_template',
        'title' => 'Default title',
        'content' => 'Default content',
        'body' => 'Default body',
        'link_url' => 'https://evelin.website',
        'color' => 16760025,
        'footer_content' => 'Default footer',
        'footer_url' => 'https://evelin.website',
        'image_url' => 'https://github.com/evelinwillow/pfp/blob/main/ezgif-7-835ce8ed54.gif?raw=true',
        'thumbnail_url' => 'https://github.com/evelinwillow/pfp/blob/main/ezgif-7-835ce8ed54.gif?raw=true',
        'timestamp' => true,
    ];

    protected $fillable = ['discord_id'];
}
