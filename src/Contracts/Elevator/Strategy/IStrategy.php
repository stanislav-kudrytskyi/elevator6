<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 12:03
 */

namespace App\Contracts\Elevator\Strategy;

use App\Contracts\Elevator\IState;
use App\Contracts\Elevator\IStateResolution;

interface IStrategy
{
	public function __construct(IState $state);
	public function resolve(): IStateResolution;
}