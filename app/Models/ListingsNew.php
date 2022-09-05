<?php


namespace App\Models;

class Listing
{
    public static function all()
    {
        return
            [
                [
                    'id' => 1,
                    'title' => 'Listing one',
                    'description' => 'very long long story ...very long long story'
                ],
                [
                    'id' => 2,
                    'title' => 'Listing two',
                    'description' => 'very long long story number two...',
                ],
            ];
    }

    public static function find($id) {
        $listings = self::all();

        foreach ($listings as $listing) {
            if ($listing['id'] == $id ) {
                return $listing;
            }
        }
    }
}
