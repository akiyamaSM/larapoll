<?php
namespace Inani\Larapoll\Traits;


use Illuminate\Support\Collection;
use Inani\Larapoll\Exceptions\CheckedOptionsException;
use Inani\Larapoll\Exceptions\OptionsInvalidNumberProvidedException;
use Inani\Larapoll\Exceptions\OptionsNotProvidedException;
use Inani\Larapoll\Option;

trait PollManipulator
{

    /**
     * attach new options
     * 
     * @param $options
     * @return mixed
     */
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


    /**
     * Remove a (list of elements)
     *
     * @param $options
     * @return bool
     * @throws CheckedOptionsException
     * @throws OptionsInvalidNumberProvidedException
     * @throws OptionsNotProvidedException
     */
    public function detach($options)
    {
        $options = is_array($options) ? $options : func_get_args();

        $oldOptions = [];

        $elements = $this->options()->pluck('id');
        foreach($options as $option){

            if(is_int($option)){
                if($this->containsAndNotVoted($elements, $option)){
                    $oldOptions[] = $option;
                }
            }else if($option instanceof Option){
                if($this->containsAndNotVoted($elements, $option->getKey())) {
                    $oldOptions = $option->getKey();
                }
            }else {
                throw new \InvalidArgumentException("Array arguments must be composed of ids or option object values");
            }

        }

        // verify the number of options
        $diff = ($elements->count() - count($oldOptions));
        if( $diff == 0)
            throw new OptionsNotProvidedException();
        if( $diff == 1)
            throw new OptionsInvalidNumberProvidedException();

        if($this->isRadio()){
            $count = count($oldOptions);
            return Option::destroy($oldOptions) == $count;
        }

        if($diff <= $this->maxCheck)
            throw new CheckedOptionsException();

        $count = count($elements);
        return Option::destroy($elements) == $count;
    }

    private function containsAndNotVoted(Collection $elements, $against)
    {
        //if options are voted throw new RemoveVotedOptionException
        return $elements->contains($against);
    }
}