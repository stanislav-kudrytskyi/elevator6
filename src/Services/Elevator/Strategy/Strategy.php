<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 12:02
 */

namespace App\Services\Elevator\Strategy;

use App\Contracts\Elevator\IState;
use App\Contracts\Elevator\Strategy\IStrategy;

abstract class Strategy implements IStrategy
{
	/**
	 * @var IState
	 */
	protected $state;

	public function __construct(IState $state)
	{
		$this->state = $state;
	}
}