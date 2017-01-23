<?php

namespace Inani\Larapoll\Tests;

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
}
