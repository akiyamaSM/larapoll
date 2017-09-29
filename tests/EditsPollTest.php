<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditsPollTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function admin_can_see_poll_list()
    {
        $this->assertTrue(true);
    }

    public function admin_can_add_new_options()
    {

    }

    public function admin_can_remove_options()
    {

    }

    public function an_error_is_shown_if_less_than_two_options_are_left()
    {

    }

    public function an_admin_can_close_an_opened_poll()
    {

    }

    public function an_admin_can_open_a_closed_poll()
    {

    }

    /**
     * Make a user and Connect as admin
     *
     */
    protected function beAdmin()
    {
        $this->be(
            $this->user = $this->makeUser()
        );
        return $this;
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
