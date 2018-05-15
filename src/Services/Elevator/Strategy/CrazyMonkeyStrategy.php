<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 12:34
 */

namespace App\Services\Elevator\Strategy;

use App\Contracts\Elevator\IDirection;
use App\Contracts\Elevator\IStateResolution;
use App\Contracts\Elevator\Strategy\ICrazyMonkeyStrategy;
use App\Services\Elevator\StateResolution;

class CrazyMonkeyStrategy extends Strategy implements ICrazyMonkeyStrategy
{
	protected function determineTargetFloor(): int
	{
		if ($this->state->getCurrentFloor() === 1) {
			return 2;
		}

		if ($this->state->getCurrentFloor() === $this->state->getNumberOfFloors()) {
			return $this->state->getNumberOfFloors() - 1;
		}

		return $this->state->getCurrentFloor() + 1;
	}

	protected function determineDirection(): string
	{
		return $this->determineTargetFloor() - $this->state->getCurrentFloor() > 0 ? IDirection::UP : IDirection::DOWN;
	}

	public function resolve(): IStateResolution
	{
		return new StateResolution(
			$this->determineTargetFloor(),
			$this->determineDirection()
		);
	}
}