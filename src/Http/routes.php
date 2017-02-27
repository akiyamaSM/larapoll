<?php

Route::group(['namespace' => 'Inani\Larapoll\Http\Controllers', 'prefix' => 'larapoll'], function(){
    Route::get('/admin', ['uses' => 'PollManagerController@index', 'as' => 'poll.index']);
});