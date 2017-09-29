<?php

Route::group(['namespace' => 'Inani\Larapoll\Http\Controllers', 'prefix' => 'larapoll'], function(){
    Route::get('/admin/polls', ['uses' => 'PollManagerController@index', 'as' => 'poll.index']);
    Route::get('/admin/polls/create', ['uses' => 'PollManagerController@create', 'as' => 'poll.create']);
    Route::get('/admin/polls/{poll}', ['uses' => 'PollManagerController@edit', 'as' => 'poll.edit']);
    Route::post('/admin/polls/{poll}', ['uses' => 'PollManagerController@update', 'as' => 'poll.update']);
    Route::delete('/admin/polls/{poll}', ['uses' => 'PollManagerController@remove', 'as' => 'poll.remove']);
    Route::post('/admin/polls', ['uses' => 'PollManagerController@store', 'as' => 'poll.store']);
    Route::post('/admin/polls/{poll}/options/add', ['uses' => 'OptionManagerController@add', 'as' => 'poll.options.add']);
    Route::delete('/admin/polls/{poll}/options/remove', ['uses' => 'OptionManagerController@remove', 'as' => 'poll.options.remove']);
});