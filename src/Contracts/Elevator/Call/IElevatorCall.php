<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 12:04 PM
 */

namespace App\Contracts\Elevator\Call;


interface IElevatorCall
{
	public function setFloor(int $floor): IElevatorCall;
	public function getFloor(): int;
}