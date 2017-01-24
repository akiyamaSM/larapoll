<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inani\Larapoll\Poll;

class PollTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_new_poll()
    {
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $bool = $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
                     ->maxSelection()
                     ->generate();

        $this->assertTrue($bool);
        $this->assertTrue($poll->isRadio());
        $this->assertEquals(4, $poll->optionsNumber());
    }

    /** @test */
    public function it_adds_new_options()
    {
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $bool = $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
                    ->maxSelection()
                    ->generate();

        $this->assertTrue($bool);
        $this->assertTrue($poll->isRadio());
        $this->assertEquals(4, $poll->optionsNumber());

        $poll->attach([
            'Yii', 'CodeIgniter'
        ]);

        $this->assertEquals(6, $poll->optionsNumber());
    }

    /** @test */
    public function it_removes_unvoted_options_from_poll()
    {
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $bool = $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
            ->maxSelection()
            ->generate();

        $this->assertTrue($bool);
        $this->assertEquals(4, $poll->optionsNumber());

        $option = $poll->options()->first();
        $this->assertTrue($poll->detach($option));
        $this->assertEquals(3, $poll->optionsNumber());

    }

    /** @test */
    public function user_votes_in_a_poll()
    {
        $voter = $this->makeUser();
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
                     ->maxSelection(2)
                     ->generate();
        $voteFor = $poll->options()->first();
        $this->assertTrue($voter->poll($poll)->vote($voteFor));
    }

    /** @test */
    public function user_selects_more_options_to_votes_in_a_poll()
    {
        $voter = $this->makeUser();
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
                     ->maxSelection(2)
                     ->generate();
        $voteFor = $poll->options()->get()->take(3)->pluck('id')->all();
        try{
            $voter->poll($poll)->vote($voteFor);
        }catch (\InvalidArgumentException $e){

        }
        $this->assertNotNull($e);
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
