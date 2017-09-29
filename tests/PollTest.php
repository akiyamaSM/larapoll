<?php

namespace Inani\Larapoll\Tests;

use App\User;
use Inani\Larapoll\Poll;
use InvalidArgumentException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inani\Larapoll\Exceptions\VoteInClosedPollException;
use Inani\Larapoll\Exceptions\RemoveVotedOptionException;

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
        $this->assertTrue($voter->poll($poll)->vote($voteFor->getKey()));
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

    /** @test */
    public function it_doesnt_remove_voted_options_from_poll()
    {
        $voter = $this->makeUser();
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $bool = $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
                     ->maxSelection(2)
                     ->generate();

        $this->assertTrue($bool);
        $this->assertEquals(4, $poll->optionsNumber());

        $option = $poll->options()->first();
        $this->assertTrue($voter->poll($poll)->vote($option->getKey()));
        try{
            $poll->detach($option);
        }catch (RemoveVotedOptionException $e){
        }
        $this->assertNotNull($e);

        $this->assertEquals(4, $poll->optionsNumber());
    }

    /** @test */
    public function it_gets_poll_ordered()
    {
        $voter = $this->makeUser();
        $anOtherVoter = $this->makeUser();
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
            ->maxSelection(2)
            ->generate();
        $option = $poll->options()->first();
        $this->assertTrue($voter->poll($poll)->vote($option->getKey()));
        $this->assertTrue($anOtherVoter->poll($poll)->vote($option->getKey()));

        $mostVoted = $poll->results()->inOrder()[0];
        $this->assertEquals($option->getKey(), $mostVoted["option"]->getKey());
        $this->assertEquals(2, $mostVoted["votes"]);
    }

    /** @test */
    public function it_closes_poll()
    {
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
            ->maxSelection(2)
            ->generate();
        $this->assertFalse($poll->isLocked());
        $this->assertTrue($poll->lock());
        $this->assertTrue($poll->isLocked());
    }

    /** @test */
    public function it_doesnt_vote_in_closed_poll()
    {
        $voter = $this->makeUser();
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
            ->maxSelection(2)
            ->generate();
        $this->assertTrue($poll->lock());
        $option = $poll->options()->first();

        try{
            $voter->poll($poll)->vote($option->getKey());
        }catch(\Exception $e){
            $this->assertTrue($e instanceof VoteInClosedPollException);
        }
        $this->assertNotNull($e);
    }

    /** @test */
    public function it_does_reopen_a_closed_poll()
    {
        $voter = $this->makeUser();
        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
            ->maxSelection(2)
            ->generate();
        $this->assertTrue($poll->lock());
        $option = $poll->options()->first();

        try{
            $voter->poll($poll)->vote($option->getKey());
        }catch(\Exception $e){
            $this->assertTrue($e instanceof VoteInClosedPollException);
        }
        $this->assertNotNull($e);

        $poll->unLock();
        $this->assertTrue($voter->poll($poll)->vote($option->getKey()));
    }
    /** @test */
    public function it_removes_poll_with_its_options_and_votes()
    {
        $voter = $this->makeUser();

        $poll = new Poll([
            'question' => 'What is the best PHP framework?'
        ]);

        $poll->addOptions(['Laravel', 'Zend', 'Symfony', 'Cake'])
            ->maxSelection()
            ->generate();

        $voteFor = $poll->options()->first();

        $voter->poll($poll)->vote($voteFor->getKey());

        $id = $poll->id;
        $this->assertTrue($poll->remove());
        $this->dontSeeInDatabase('options', [
                'poll_id' => $id
            ]);;
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
