<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 12:04
 */

namespace App\Contracts\Elevator;

interface IStateResolution
{
	public function getDirection();
	public function getTargetFloor();
	public function toArray(): array;
}