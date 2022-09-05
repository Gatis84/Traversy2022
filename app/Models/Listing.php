<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    //    protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags' ];
    // ja negrib taisīt šo mainīgo, var aiziet uz AppServiceProvider.php failu un tur zem public function boot ierakstit  Model::unguard();
    // BET jabut uzmanigam, jo šādi ar masīvu var ieladēt neplānoti daudz info, kas UZREIZ pievienojas DB!!!



    public function scopeFilter($query, array $filters) {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if ($filters['search'] ?? false) {
            $query
                ->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    //relationship to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
