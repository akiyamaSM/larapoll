<?php

namespace Inani\Larapoll;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id', 'option_id'
    ];
    protected $table = 'larapoll_votes';

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
