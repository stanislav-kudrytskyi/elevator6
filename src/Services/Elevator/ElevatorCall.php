<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 12:42 PM
 */

namespace App\Services\Elevator;


use App\Contracts\Elevator\IDirection;
use App\Contracts\Elevator\IElevatorCall;

class ElevatorCall implements IElevatorCall
{
    protected $fromFloor;
    protected $toFloor;
    protected $direction;

    public function getFromFloor(): ?int
    {
        return $this->fromFloor;
    }

    public function getToFloor(): ?int
    {
        return $this->toFloor;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction = null): IElevatorCall
    {
        if (!in_array($direction, [IDirection::UP, IDirection::DOWN])) {
            throw new ElevatorException('Invalid direction', 400);
        }

        $this->direction = $direction;
        return $this;
    }

    public function setFromFloor(int $floorNumber): IElevatorCall
    {
        $this->fromFloor = $floorNumber;
        return $this;
    }

    public function setToFloor(int $floorNumber): IElevatorCall
    {
        $this->toFloor = $floorNumber;
        return $this;
    }
}