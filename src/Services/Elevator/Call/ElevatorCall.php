<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 12:59
 */

namespace App\Services\Elevator\Call;

use App\Contracts\Elevator\Call\IElevatorCall;
use App\Services\Elevator\ElevatorException;

abstract class ElevatorCall implements IElevatorCall
{
    protected $floor;

    public function setFloor(int $floor): IElevatorCall
    {
        if ($floor < 1) {
            throw new ElevatorException('Floor number must be positive', 412);
        }

        $this->floor = $floor;
        return $this;
    }

    public function getFloor(): int
    {
        return $this->floor;
    }
}