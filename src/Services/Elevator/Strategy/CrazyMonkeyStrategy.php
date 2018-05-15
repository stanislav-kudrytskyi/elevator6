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

		$delta = mt_rand(0, 1) ? 1 : -1;
		return $this->state->getCurrentFloor() + $delta;
	}

	protected function determineDirection(): ?string
	{
		$target = $this->determineTargetFloor();
		$current = $this->state->getCurrentFloor();

		if ($target - $current === 0) {
			return null;
		}

		return $target - $current > 0 ? IDirection::UP : IDirection::DOWN;
	}

	public function resolve(): IStateResolution
	{
		return new StateResolution(
			$this->determineTargetFloor(),
			$this->determineDirection()
		);
	}
}