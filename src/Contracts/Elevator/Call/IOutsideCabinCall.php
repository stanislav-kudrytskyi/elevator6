<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 13:07
 */

namespace App\Contracts\Elevator\Call;

interface IOutsideCabinCall extends IElevatorCall
{
	public function setDirection(string $direction);
	public function getDirection(): string;
}