<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Inani\Larapoll\Poll;

class ManipulatesPollTest extends LarapollTestCase
{

    /** @test */
    public function admin_can_add_new_options()
    {
        $this->beAdmin();

        $poll = factory(Poll::class)->create();

        $input = [
            'options[0]' => 'some option'
        ];

        $this->visit(route('poll.options.push', $poll->id))
            ->see($poll->question)
            ->submitForm('Add', $input);

        $this->assertResponseStatus(200)
            ->see('New poll options have been added successfully');
    }

    public function admin_can_remove_options()
    { }

    public function an_error_is_shown_if_less_than_two_options_are_left()
    { }

    public function an_admin_can_close_an_opened_poll()
    { }

    public function an_admin_can_open_a_closed_poll()
    { }

    public function an_admin_can_delete_a_poll()
    {
        $this->beAdmin();

        $this->visit(route('poll.index'))
            ->press('')
            ->assertSessionHas('success');
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
