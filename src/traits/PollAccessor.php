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
     * Check if it the Voter can select one option or many
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
        return !is_null($this->isClosed);
    }

    /**
     * Get the question
     *
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /*
     * Check if the poll is open
     *
     * @return bool
     */
    public function isOpen()
    {
        return !$this->isLocked();
    }

    public function isRunning()
    {
        return $this->isOpen() && $this->hasStarted();
    }

    public function hasStarted()
    {
        return $this->starts_at <= now();
    }

    public function isComingSoon()
    {
        return $this->isOpen() && now() < $this->starts_at;
    }
}