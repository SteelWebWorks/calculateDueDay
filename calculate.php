<?php

include_once './validate.php';

class Calculate
{

    private $dateCreated;

    private $estimatedTime;

    private $dueDate;

    public function __construct($dateCreated, $estimatedTime) {
        
        $this->dateCreated = Validate::validateDate($dateCreated);
        $this->estimatedTime = Validate::validateTime($estimatedTime);
        if ($this->dateCreated == false) {
            throw new Exception("Invalid date. The format should be YYYY-MM-DD[T| ]HH:mm (must be a working day between the working hours)");
        }
        if($this->estimatedTime == false) {
            throw new Exception("Invalid estimation time. Must be digits only");
        }
        $this->dueDate = new DateTime($this->dateCreated);
        $this->calculateDueTime();
    }

    public function calculateDueTime() {
        $weeks = (int) floor($this->estimatedTime / 40);
        $this->estimatedTime = $this->estimatedTime - ($weeks * 40);
        

        $days = (int) floor($this->estimatedTime / 8);
        $this->estimatedTime = $this->estimatedTime - ($days * 8);
                
        if ($weeks > 0) {            
            $this->dueDate->add(new DateInterval('P'. $weeks. 'W'));
        }
        
        $remainingDaysInWeek = 5 - $this->dueDate->format('N');
        if ($remainingDaysInWeek > 0 && $days > 0) {
            $this->dueDate->add(new DateInterval('P'. $remainingDaysInWeek. 'D'));
            if (($days - $remainingDaysInWeek) > 0) {
                $this->dueDate->add(new DateInterval('P'. (($days - $remainingDaysInWeek) +2 ). 'D'));
            }
        }
        
        $dayEnd = new DateTime($this->dueDate->format('Y-m-d 17:00'));
        $timeDiff = $dayEnd->diff($this->dueDate);
        if ($timeDiff->h > $this->estimatedTime) {
            $this->dueDate->add(new DateInterval('P'. ($this->estimatedTime). 'H'));
        } else {
            $this->dueDate->add(new DateInterval('PT'. ($this->estimatedTime - $timeDiff->h + 16). 'H'));
        }
        

    }
    public function getDueDate() {
        return $this->dueDate->format('Y-m-d H:i');
    }

}