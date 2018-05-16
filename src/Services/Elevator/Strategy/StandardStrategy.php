<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/16/2018
 * Time: 5:08 PM
 */

namespace App\Services\Elevator\Strategy;

use App\Contracts\Elevator\Call\IFromCabinCall;
use App\Contracts\Elevator\Call\IOutsideCabinCall;
use App\Contracts\Elevator\IDirection;
use App\Contracts\Elevator\IState;
use App\Contracts\Elevator\IStateResolution;
use App\Contracts\Elevator\Strategy\IStandardStrategy;
use App\Services\Elevator\StateResolution;

class StandardStrategy extends Strategy implements IStandardStrategy
{
    protected $filteredOutCabinCalls = [];
    protected $filteredFromCabinCalls = [];

    protected function filterOutCabinCalls()
    {
        $this->filteredOutCabinCalls = $this->state->getOutsideCabinCalls();

        if (null === $this->direction) {
            return;
        }

        $this->filteredOutCabinCalls = array_filter($this->filteredOutCabinCalls, function (IOutsideCabinCall $call) {
            if ($this->direction !== $call->getDirection()) {
                return false;
            }

            if ($this->direction === IDirection::UP) {
                return $call->getFloor() > $this->currentFloor;
            }

            return $call->getFloor() < $this->currentFloor;
        });
    }

    protected function filterFromCabinCalls()
    {
        $this->filteredFromCabinCalls = $this->state->getFromCabinCalls();

        if (null === $this->direction) {
            return;
        }

        $this->filteredFromCabinCalls = array_filter($this->filteredFromCabinCalls, function (IFromCabinCall $call) {
            if ($this->direction === IDirection::UP) {
                return $call->getFloor() > $this->currentFloor;
            }

            return $call->getFloor() < $this->currentFloor;
        });
    }

    public function __construct(IState $state)
    {
        parent::__construct($state);
        $this->filterOutCabinCalls();
        $this->filterFromCabinCalls();
    }

    public function resolve(): IStateResolution
    {
        $call = $this->getNearestCall(...array_merge(
            $this->filteredFromCabinCalls,
            $this->filteredOutCabinCalls
            )
        );

        if (!$call) {
            return new StateResolution($this->currentFloor, null);
        }

        return new StateResolution($call->getFloor(), $this->direction);
    }
}
