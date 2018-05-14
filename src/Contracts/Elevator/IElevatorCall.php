<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 12:04 PM
 */

namespace App\Contracts\Elevator;


interface IElevatorCall
{
    public function getFromFloor(): ?int;
    public function getToFloor(): ?int;
    public function getDirection(): ?string;

    public function setDirection(string $direction = null): IElevatorCall;
    public function setFromFloor(int $floorNumber): IElevatorCall;
    public function setToFloor(int $floorNumber): IElevatorCall;
}