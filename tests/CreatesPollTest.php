<?php

namespace Inani\Larapoll\Tests;

use App\User;

class CreatesPollTest extends LarapollTestCase
{

    /** @test */
    public function create_form_is_shown()
    {
        $this->beAdmin()
            ->visit(route('poll.create'))
            ->assertResponseStatus(200)
            ->see('Create');
    }

    /** @test */
    public function an_admin_can_create_a_poll()
    {
        $input = [
            'question' => 'Best Series Ever?',
            'options[0]' => 'Narcos',
            'options[1]' => 'Breaking Bad'
        ];
        $this->beAdmin()
            ->visit(route('poll.create'))
            ->submitForm('create', $input);
    }

    /** @test */
    public function an_error_is_shown_if_not_filled()
    {
        $input = [
            'question' => ''
        ];
        $this->beAdmin()
            ->visit(route('poll.create'))
            ->submitForm('create', $input)
            ->see('Question should be asked')
            ->see('Two options must be used at least');
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
