<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Inani\Larapoll\Exceptions\RemoveVotedOptionException;
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
            ->see($poll->question)
            ->see('Cristiano Ronaldo')
            ->see('Neymar Jr')
            ->see('Lionel Messi');
    }

    /** @test */
    public function an_admin_can_add_new_options()
    {
        $this->beAdmin();

        $poll = factory(Poll::class)->create();

        $options = [
            'options' => [ 'option'. str_random(3) ]
        ];

        $this->post(route('poll.options.add', [ 'id' => $poll->id ]), $options)
            ->assertResponseStatus(200)
            ->seeInDatabase('options', [
                 'name' => $options['options'][0],
                 'poll_id' => $poll->id
            ]);
    }

    /** @test */
    public function an_admin_can_remove_unvoted_options()
    {
        $this->beAdmin();
        $poll = new Poll([
            'question' => 'Who is the Best Player of the World?'
        ]);

        $poll->addOptions(['Cristiano Ronaldo', 'Lionel Messi', 'Neymar Jr', 'Other'])
            ->maxSelection()
            ->generate();

        $toDelete = $poll->options()->orderBy('id', 'desc')->first();
        $options = [
            'options' => [ $toDelete->id ]
        ];
        $this->delete( route('poll.options.remove', $poll->id), $options)
             ->dontSeeInDatabase('options', [
                'name' => $toDelete->name,
                'id' => $toDelete->id
             ]);
    }

    /** @test */
    public function an_admin_cant_remove_voted_option()
    {

        $this->beAdmin();
        $poll = new Poll([
            'question' => 'Who is the Best Player of the World?'
        ]);

        $poll->addOptions(['Cristiano Ronaldo', 'Lionel Messi', 'Neymar Jr', 'Other'])
            ->maxSelection()
            ->generate();

        $voteFor = $poll->options()->first();
        $options = [
            'options' => [ $voteFor->id ]
        ];
        $this->user->poll($poll)->vote($voteFor->getKey());

        $this->delete( route('poll.options.remove', $poll->id), $options)
            ->SeeInDatabase('options', [
                'name' => $voteFor->name,
                'id' => $voteFor->id
            ]);
    }

    /** @test */
    public function an_admin_can_modify_poll_type()
    {
        $this->beAdmin();

        $poll = new Poll([
            'question' => 'Who is the Best Player of the World?'
        ]);

        $poll->addOptions(['Cristiano Ronaldo', 'Lionel Messi', 'Neymar Jr', 'Other'])
            ->maxSelection()
            ->generate();

        $options = [
            'count_check' => 2,
        ];
        $this->post(route('poll.update', $poll->id), $options)
            ->assertResponseStatus(200)
            ->assertEquals(2, Poll::findOrFail($poll->id)->maxCheck);
    }

    /** @test */
    public function an_admin_can_close_a_poll()
    {
        $this->beAdmin();

        $poll = new Poll([
            'question' => 'Who is the Best Player of the World?'
        ]);

        $poll->addOptions(['Cristiano Ronaldo', 'Lionel Messi', 'Neymar Jr', 'Other'])
            ->maxSelection()
            ->generate();

        $options = [
            'close' => 1,
        ];

        $this->post(route('poll.update', $poll->id), $options)
            ->assertResponseStatus(200)
            ->assertTrue(Poll::findOrFail($poll->id)->isLocked());
    }

    /** @test */
    public function an_admin_can_reopen_a_closed_poll()
    {
        $this->beAdmin();

        $poll = new Poll([
            'question' => 'Who is the Best Player of the World?'
        ]);

        $poll->addOptions(['Cristiano Ronaldo', 'Lionel Messi', 'Neymar Jr', 'Other'])
            ->maxSelection()
            ->generate();

        $this->assertTrue($poll->lock());
        $options = [
            'close' => 0,
        ];

        $this->post(route('poll.update', $poll->id), $options)
            ->assertResponseStatus(200)
            ->assertFalse(Poll::findOrFail($poll->id)->isLocked());
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
