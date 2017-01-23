<?php

namespace Inani\Larapoll;

use Illuminate\Database\Eloquent\Model;
use Inani\Larapoll\Traits\PollCreator;

class Poll extends Model
{
    use PollCreator;
    protected $fillable = ['question'];

    /**
     * A poll has many options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
