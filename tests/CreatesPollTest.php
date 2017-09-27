<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inani\Larapoll\Exceptions\RemoveVotedOptionException;
use Inani\Larapoll\Exceptions\VoteInClosedPollException;
use Inani\Larapoll\Poll;
use InvalidArgumentException;

class CreatesPollTest extends \TestCase
{
    use DatabaseTransactions;

    public function create_form_is_shown()
    {

    }

    public function an_admin_can_create_a_poll()
    {

    }

    public function an_error_is_shown_if_not_filled()
    {

    }

    /**
     * Make one user
     *
     * @return mixed
     */
    public function makeUser()
    {
        return factory(User::class)->create();
    }
}
