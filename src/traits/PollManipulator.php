<?php
namespace Inani\Larapoll\Traits;


use Inani\Larapoll\Option;

trait PollManipulator
{

    public function attach($options)
    {
        if(is_array($options))
        {
            $newOptions = [];

            foreach($options as $option){
                if(is_string($option)){
                    $newOptions[] = new Option([
                        'name' => $option
                    ]);
                }else{
                    throw new \InvalidArgumentException("Array arguments must be composed of Strings values");
                }
            }
            return $this->options()->saveMany($newOptions);
        }

        if(is_string($options)){
            return $this->options()->save(
                new Option([
                    'name' => $options
                ])
            );
        }

        throw new \InvalidArgumentException("Invalid Argument provided");
    }
}