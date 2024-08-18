<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embeds extends Model
{
    use HasFactory;

    protected $attributes = [
        'template' => 'default_template',
        'color' => 16760025,
        'timestamp' => true,
    ];

    protected $fillable = [
        'discord_id',
        'template',
        'title',
        'content',
        'body',
        'link_url',
        'color',
        'footer_content',
        'footer_url',
        'image_url',
        'thumbnail_url',
        'timestamp',
    ];
}
