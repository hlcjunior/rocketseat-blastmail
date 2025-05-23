<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property mixed $subscribers
 */
class EmailList extends Model
{
    use HasFactory;

    public function subscribers(): HasMany
    {

        return $this->hasMany(Subscriber::class);

    }
}
