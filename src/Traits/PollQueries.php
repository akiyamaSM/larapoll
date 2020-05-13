<?php

namespace Inani\Larapoll\Traits;


trait PollQueries
{
    protected $results = null;

    /**
     * Get Poll results
     *
     * @return array
     */
    public function results()
    {
        $this->results = collect();
        foreach($this->options()->get() as $option){
            $this->results->push([
              "option" => $option,
              "votes" => $option->countVotes(),
            ]);
        }
        return $this;
    }


    /**
     * Get the result in order
     *
     * @return mixed
     */
    public function inOrder()
    {
        if(! is_null($this->results)){
            $new = $this->results->sortByDesc('votes');
            return $new->toArray();
        }
    }

    /**
     * Get results in poll order
     *
     * @return mixed
     */
    public function grab()
    {
        if(! is_null($this->results)){
            return $this->results->toArray();
        }
    }

}