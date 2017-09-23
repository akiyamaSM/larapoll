<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Inani\Larapoll\Exceptions\RemoveVotedOptionException;
use Inani\Larapoll\Exceptions\VoteInClosedPollException;
use Inani\Larapoll\Poll;
use InvalidArgumentException;

class PollCreationTest extends \TestCase
{
    use DatabaseTransactions;

    protected $user;

    /** @test */
    public function a_guest_doesnt_enter_to_dashboard()
    {
        $this->visit(route('poll.index'))
            ->see('Login');
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
