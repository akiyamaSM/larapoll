<?php

Route::group(['namespace' => 'Inani\Larapoll\Http\Controllers', 'prefix' => 'larapoll'], function(){
    Route::get('/admin/polls', ['uses' => 'PollManagerController@index', 'as' => 'poll.index']);
    Route::post('/admin/polls', ['uses' => 'PollManagerController@store', 'as' => 'poll.store']);
});