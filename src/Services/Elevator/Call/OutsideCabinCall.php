<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 13:10
 */

namespace App\Services\Elevator\Call;

use App\Contracts\Elevator\Call\IElevatorCall;
use App\Contracts\Elevator\Call\IOutsideCabinCall;
use App\Contracts\Elevator\IDirection;
use App\Services\Elevator\ElevatorException;

/**
 * Class OutsideCabinCall
 * @package App\Services\Elevator\Call
 */
class OutsideCabinCall extends ElevatorCall implements IOutsideCabinCall
{
    protected $direction;

    public function setDirection(string $direction = null): IElevatorCall
    {
        if (!in_array($direction, [IDirection::UP, IDirection::DOWN])) {
            throw new ElevatorException('Invalid direction', 400);
        }

        $this->direction = $direction;
        return $this;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}