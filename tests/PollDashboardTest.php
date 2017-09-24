<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inani\Larapoll\Option;
use Inani\Larapoll\Poll;

class PollDashboardTest extends \TestCase
{
    use DatabaseMigrations;

    protected $user;

    /** @test */
    public function a_guest_doesnt_enter_to_dashboard()
    {
        $this->visit(route('poll.index'))
            ->see('Login');
    }

    /** @test */
    public function an_authenticated_admin_enters_to_dashboard()
    {
        $this->beAdmin()
            ->visit(route('poll.index'))
            ->assertResponseStatus(200)
            ->see('Dashboard');
    }

    /** @test */
    public function an_admin_can_see_polls_list()
    {
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
            ->maxSelection()
            ->generate();

        $this->beAdmin()
            ->visit(route('poll.index'))
            ->see($poll->question);
    }

    /** @test */
    public function an_admin_can_add_a_poll()
    {
        $this->beAdmin();

        $request =[
            'question' => 'Who is the Best Player of the World?',
            'options' => [
                'Cristiano Ronaldo', 'Lionel Messi', 'Neymar Jr'
            ],
            'maxCheck' => 1
        ];
        $this->post(route('poll.store'), $request)
            ->assertResponseStatus(200)
            ->seeInDatabase('polls', [ 'question' => $request['question'] ]);
    }

    /** @test */
    public function an_admin_can_see_a_poll()
    {
        $this->beAdmin();
        $poll = new Poll([
            'question' => 'Who is the Best Player of the World?'
        ]);

        $poll->addOptions(['Cristiano Ronaldo', 'Lionel Messi', 'Neymar Jr'])
            ->maxSelection()
            ->generate();
        $this->get(route('poll.edit', [ 'poll' => $poll->id ]))
            ->assertResponseStatus(200)
            ->see($poll->question);
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
