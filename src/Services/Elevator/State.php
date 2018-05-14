<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 2:12 PM
 */

namespace App\Services\Elevator;


use App\Contracts\Elevator\IElevatorCall;
use App\Contracts\Elevator\IState;

class State implements IState
{
    protected $numberOfFloors = 0;

    protected $targetFloor = 0;
    protected $currentFloor = 0;
    protected $personsInside = 0;

    /**
     * @var IElevatorCall[]
     */
    protected $elevatorCalls = [];

    public function getNumberOfFloors(): int
    {
        return $this->numberOfFloors;
    }

    public function getElevatorCalls(): array
    {
        return $this->elevatorCalls;
    }

    public function getCurrentTargetFloor(): int
    {
        return $this->targetFloor;
    }

    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }

    public function getNumberOfPersonsInside(): int
    {
        return $this->personsInside;
    }

    public function setNumberOfFloors(int $number): IState
    {
        $this->numberOfFloors = $number;
        return $this;
    }

    public function setCurrentFloor(int $floor): IState
    {
        $this->currentFloor = $floor;
        return $this;
    }

    public function setTargetFloor(int $floor): IState
    {
        $this->targetFloor = $floor;
        return $this;
    }

    public function setElevatorCalls(IElevatorCall ...$calls): IState
    {
        $this->elevatorCalls = $calls;
        return $this;
    }
}