<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 12:02
 */

namespace App\Services\Elevator\Strategy;

use App\Contracts\Elevator\Call\IElevatorCall;
use App\Contracts\Elevator\IState;
use App\Contracts\Elevator\Strategy\IStrategy;

abstract class Strategy implements IStrategy
{
    /**
     * @var IState
     */
    protected $state;
    protected $direction;
    protected $currentFloor;

    public function __construct(IState $state)
    {
        $this->state = $state;
        $this->direction = $this->state->getCurrentDirection();
        $this->currentFloor = $this->state->getCurrentFloor();
    }

    protected function getNearestCall(IElevatorCall ...$calls): ?IElevatorCall
    {
        $first = array_shift($calls);

        return array_reduce($calls, function (IElevatorCall $carry, IElevatorCall $item) {
            if (abs($carry->getFloor() - $this->currentFloor) > abs($item->getFloor() - $this->currentFloor)) {
                return $item;
            }

            return $carry;
        }, $first);
    }

    protected function getFurthestCall(IElevatorCall ...$calls): ?IElevatorCall
    {
        $first = array_shift($calls);

        return array_reduce($calls, function (IElevatorCall $carry, IElevatorCall $item) {
            if (abs($carry->getFloor() - $this->currentFloor) < abs($item->getFloor() - $this->currentFloor)) {
                return $item;
            }

            return $carry;
        }, $first);
    }
}