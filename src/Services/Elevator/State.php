<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 2:12 PM
 */

namespace App\Services\Elevator;


use App\Contracts\Elevator\Call\IFromCabinCall;
use App\Contracts\Elevator\Call\IOutsideCabinCall;
use App\Contracts\Elevator\IDirection;
use App\Contracts\Elevator\Call\IElevatorCall;
use App\Contracts\Elevator\IState;
use App\Contracts\ISelfValidated;

class State implements IState, ISelfValidated
{
    protected $numberOfFloors = 0;

    protected $targetFloor = 0;
    protected $currentFloor = 0;
    protected $direction = null;
    protected $personsInside = 0;

	/**
	 * @var IOutsideCabinCall[]
	 */
    protected $outsideCabinCall = [];

    /**
     * @var IFromCabinCall[]
     */
    protected $fromCabinCall = [];

    public function getNumberOfFloors(): int
    {
        return $this->numberOfFloors;
    }

    public function getElevatorCalls(): array
    {
        return array_merge($this->fromCabinCall, $this->outsideCabinCall);
    }

    public function getFromCabinCalls(): array
	{
		return $this->fromCabinCall;
	}

	public function getOutsideCabinCalls(): array
	{
		return $this->outsideCabinCall;
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

    public function getCurrentDirection(): ?string
	{
		return $this->direction;
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

    public function setTargetFloor(int $floor = null): IState
    {
        $this->targetFloor = $floor;
        return $this;
    }

    public function setElevatorCalls(IElevatorCall ...$calls): IState
    {
        foreach ($calls as $call) {
			if ($call instanceof IOutsideCabinCall) {
				$this->outsideCabinCall[] = $call;
				continue;
			}

			$this->fromCabinCall[] = $call;
		}

        return $this;
    }

    public function setPersonsInside(int $number = 0): IState
	{
		$this->personsInside = $number;
		return $this;
	}

	public function setCurrentDirection(string $direction = null)
	{
		if (!in_array($direction, [null, IDirection::UP, IDirection::DOWN])) {
			throw new ElevatorException('Invalid direction', 400);
		}

		$this->direction = $direction;
		return $this;
	}

	public function validate(): bool
	{
		if ($this->currentFloor === 0) {
			throw new ElevatorException('Current floor not specified', 412);
		}

		if ($this->numberOfFloors === 0) {
			throw new ElevatorException('Number of floors not specified', 412);
		}

		if ($this->currentFloor < 1 || $this->currentFloor > $this->numberOfFloors) {
			throw new ElevatorException("Current floor value is out of range [1, {$this->numberOfFloors}]");
		}
		if ($this->targetFloor && $this->targetFloor < 1 || $this->targetFloor > $this->numberOfFloors) {
			throw new ElevatorException("Current floor value is out of range [1, {$this->numberOfFloors}]");
		}

		return true;
	}
}