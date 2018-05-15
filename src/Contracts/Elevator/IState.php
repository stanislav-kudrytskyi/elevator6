<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 12:00 PM
 */

namespace App\Contracts\Elevator;


use App\Contracts\Elevator\Call\IElevatorCall;
use App\Contracts\Elevator\Call\IFromCabinCall;
use App\Contracts\Elevator\Call\IOutsideCabinCall;

interface IState
{
    public function getNumberOfFloors(): int;
    public function getNumberOfPersonsInside(): int;
    public function getCurrentFloor(): int;
    public function getCurrentTargetFloor(): int;
    public function getCurrentDirection(): ?string;
    /**
     * @return IElevatorCall[]
     */
    public function getElevatorCalls(): array;

	/**
	 * @return IFromCabinCall[]
	 */
    public function getFromCabinCalls(): array;

	/**
	 * @return IOutsideCabinCall[]
	 */
    public function getOutsideCabinCalls():array;

    public function setCurrentDirection(string $direction = null);
    public function setElevatorCalls(IElevatorCall ...$calls):IState;
    public function setNumberOfFloors(int $number): IState;
    public function setCurrentFloor(int $floor): IState;
    public function setTargetFloor(int $floor = 0): IState;
    public function setPersonsInside(int $number = 0): IState;
}