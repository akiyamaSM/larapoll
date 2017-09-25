<?php

Route::group(['namespace' => 'Inani\Larapoll\Http\Controllers', 'prefix' => 'larapoll'], function(){
    Route::get('/admin/polls', ['uses' => 'PollManagerController@index', 'as' => 'poll.index']);
    Route::get('/admin/polls/{poll}', ['uses' => 'PollManagerController@edit', 'as' => 'poll.edit']);
    Route::post('/admin/polls', ['uses' => 'PollManagerController@store', 'as' => 'poll.store']);
    Route::post('/admin/polls/{poll}/add', ['uses' => 'OptionManagerController@add', 'as' => 'poll.options.add']);
});