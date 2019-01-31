<?php

$prefix = config('larapoll_config.prefix');

// NEED GUARD FOR ADMIN
// NEED GUARD FOR USER WHO SHOULD VOTE
// NEED MIDDELWARE FOR ADMIN
Route::group(['namespace' => 'Inani\Larapoll\Http\Controllers', 'prefix' => $prefix, 'middleware' => 'web'], function(){

    $middleware = config('larapoll_config.admin_auth');

    $guard = config('larapoll_config.admin_guard');

    Route::get('/admin', ['uses' => 'PollManagerController@home', 'as' => 'poll.home']);
    Route::get('/admin/polls', ['uses' => 'PollManagerController@index', 'as' => 'poll.index'])->middleware("$middleware:$guard");
    Route::get('/admin/polls/create', ['uses' => 'PollManagerController@create', 'as' => 'poll.create'])->middleware("$middleware:$guard");
    Route::get('/admin/polls/{poll}', ['uses' => 'PollManagerController@edit', 'as' => 'poll.edit'])->middleware("$middleware:$guard");
    Route::patch('/admin/polls/{poll}', ['uses' => 'PollManagerController@update', 'as' => 'poll.update'])->middleware("$middleware:$guard");
    Route::delete('/admin/polls/{poll}', ['uses' => 'PollManagerController@remove', 'as' => 'poll.remove'])->middleware("$middleware:$guard");
    Route::patch('/admin/polls/{poll}/lock', ['uses' => 'PollManagerController@lock', 'as' => 'poll.lock'])->middleware("$middleware:$guard");
    Route::patch('/admin/polls/{poll}/unlock', ['uses' => 'PollManagerController@unlock', 'as' => 'poll.unlock'])->middleware("$middleware:$guard");
    Route::post('/admin/polls', ['uses' => 'PollManagerController@store', 'as' => 'poll.store'])->middleware("$middleware:$guard");
    Route::get('/admin/polls/{poll}/options/add', ['uses' => 'OptionManagerController@push', 'as' => 'poll.options.push'])->middleware("$middleware:$guard");
    Route::post('/admin/polls/{poll}/options/add', ['uses' => 'OptionManagerController@add', 'as' => 'poll.options.add'])->middleware("$middleware:$guard");
    Route::get('/admin/polls/{poll}/options/remove', ['uses' => 'OptionManagerController@delete', 'as' => 'poll.options.remove'])->middleware("$middleware:$guard");
    Route::delete('/admin/polls/{poll}/options/remove', ['uses' => 'OptionManagerController@remove', 'as' => 'poll.options.remove'])->middleware("$middleware:$guard");
    Route::post('/vote/polls/{poll}', 'VoteManagerController@vote')->name('poll.vote');
});