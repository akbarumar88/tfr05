<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagram 
{
    public static function getSample()
    {
        return [
            ['Genres' => 'Pop', 'Types' => 'Hard', 'Popularity' => 117],
            ['Genres' => 'Rock', 'Types' => 'Hard', 'Popularity' => 96],
            ['Genres' => 'Jazz', 'Types' => 'Hard', 'Popularity' => 78],
            ['Genres' => 'Metal', 'Types' => 'Hard', 'Popularity' => 52],
            ['Genres' => 'Pop', 'Types' => 'Smooth', 'Popularity' => 56],
            ['Genres' => 'Rock', 'Types' => 'Smooth', 'Popularity' => 36],
            ['Genres' => 'Jazz', 'Types' => 'Smooth', 'Popularity' => 174],
            ['Genres' => 'Metal', 'Types' => 'Smooth', 'Popularity' => 121],
            ['Genres' => 'Pop', 'Types' => 'Experimental', 'Popularity' => 127],
            ['Genres' => 'Rock', 'Types' => 'Experimental', 'Popularity' => 83],
            ['Genres' => 'Jazz', 'Types' => 'Experimental', 'Popularity' => 94],
            ['Genres' => 'Metal', 'Types' => 'Experimental', 'Popularity' => 58],
        ];
    }
}
