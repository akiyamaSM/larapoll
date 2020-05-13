<?php
namespace Inani\Larapoll\Traits;

use Illuminate\Support\Facades\DB;
use Inani\Larapoll\Exceptions\CheckedOptionsException;
use Inani\Larapoll\Exceptions\OptionsInvalidNumberProvidedException;
use Inani\Larapoll\Exceptions\OptionsNotProvidedException;
use Inani\Larapoll\Option;
use Inani\Larapoll\Exceptions\DuplicatedOptionsException;

trait PollCreator
{
    protected $options_add = [];
    protected $maxSelection = 1;

    /**
     * Add an option to the array if not exists
     *
     * @param $option
     * @return bool
     * @throws DuplicatedOptionsException
     */
    private function pushOption($option)
    {
        if (!in_array($option, $this->options_add)) {
            $this->options_add[] = $option;
            return true;
        }
        throw new DuplicatedOptionsException();
    }

    /**
     * Add new Options
     *
     * @param $options
     * @return $this
     * @throws \InvalidArgumentException
     * @throws DuplicatedOptionsException
     */
    public function addOptions($options)
    {
        if (is_array($options)) {
            foreach ($options as $option) {
                if (is_string($option)) {
                    $this->pushOption($option);
                } else {
                    throw new \InvalidArgumentException("Array arguments must be composed of Strings values");
                }
            }
            return $this;
        }

        if (is_string($options)) {
            $this->pushOption($options);
            return $this;
        }

        throw new \InvalidArgumentException("Invalid Argument provided");
    }

    /**
     * Select max options to be voted by a user
     *
     * @param int $number
     * @return $this
     */
    public function maxSelection($number = 1)
    {
        if ($number <= 1) {
            $number = 1;
        }
        $this->maxSelection = $number;

        return $this;
    }

    /**
     * It starts at
     *
     * @param null $at
     * @return $this
     */
    public function startsAt($at = null)
    {
        $this->starts_at = !is_null($at) ? $at : now();

        return $this;
    }

    /**
     * It ends at
     *
     * @param null $at
     * @return $this
     */
    public function endsAt($at = null)
    {
        $this->ends_at = !is_null($at) ? $at : now()->addDays(7);

        return $this;
    }

    /**
     * Generate the poll
     *
     * @return bool
     * @throws CheckedOptionsException
     * @throws OptionsInvalidNumberProvidedException
     * @throws OptionsNotProvidedException
     */
    public function generate()
    {
        $totalOptions = count($this->options_add);

        // No option add yet
        if ($totalOptions == 0)
            throw new OptionsNotProvidedException();

        // There must be 2 options at least
        if ($totalOptions == 1)
            throw new OptionsInvalidNumberProvidedException();

        // At least one options should not be selected
        if ($totalOptions <= $this->maxSelection)
            throw new CheckedOptionsException();

        // Create Poll && assign options to it
        DB::transaction(function () {
            $this->maxCheck = $this->maxSelection;
            $this->save();
            $this->options()
                ->saveMany($this->instantiateOptions());
        });

        return true;
    }

    /**
     * Instantiate the options
     *
     * @return array
     */
    private function instantiateOptions()
    {
        $options = [];
        foreach ($this->options_add as $option) {
            $options[] = new Option([
                'name' => $option
            ]);
        }

        return $options;
    }
}
