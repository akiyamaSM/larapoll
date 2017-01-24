<?php

namespace Inani\Larapoll;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name'];
    /**
     * An option belongs to one poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Check if the option is voted
     *
     * @return bool
     */
    public function isVoted()
    {
        return $this->voters()->count() != 0;
    }

    /**
     * Get the voters who voted to that option
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function voters()
    {
        return $this->belongsToMany(User::class, 'votes')->withTimestamps();
    }
}
