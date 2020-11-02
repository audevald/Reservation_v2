<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\DateTime;

class ReservationSearch {

    /**
     * @var DateTime|null
     */
    private $date;

    /** 
     * @var string|null
     */
    private $name;

    /**
     * @var boolean|null
     */
    private $cancel;


    /**
     * Get the value of date
     *
     * @return  DateTime|null
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param  DateTime|null  $date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string|null
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string|null  $name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of cancel
     *
     * @return  boolean|null
     */ 
    public function getCancel()
    {
        return $this->cancel;
    }

    /**
     * Set the value of cancel
     *
     * @param  boolean|null  $cancel
     *
     * @return  self
     */ 
    public function setCancel($cancel)
    {
        $this->cancel = $cancel;

        return $this;
    }
}