<?php
namespace Inani\Larapoll\Traits;


trait PollAccessor
{

    /**
     * Return number of Options
     *
     * @return mixed
     */
    public function optionsNumber()
    {
        return $this->options()->count();
    }

    /**
     * Check if it accepts one option
     *
     * @return bool
     */
    public function isRadio()
    {
        return $this->maxCheck == 1;
    }

    /**
     * Check if it accepts many options
     *
     * @return bool
     */
    public function isCheckable()
    {
        return !$this->isRadio();
    }

    /**
     * Check if the poll is closed
     *
     * @return bool
     */
    public function isLocked()
    {
        return $this->isClosed == 1;
    }
}