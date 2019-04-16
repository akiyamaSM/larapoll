<?php
namespace Inani\Larapoll\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LarapollTestCase extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
}
