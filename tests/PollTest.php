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
    }
}
