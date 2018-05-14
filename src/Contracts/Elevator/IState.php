<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 12:00 PM
 */

namespace App\Contracts\Elevator;


interface IState
{
    public function getNumberOfFloors(): int;
    public function getNumberOfPersonsInside(): int;
    public function getCurrentFloor(): int;
    public function getCurrentTargetFloor(): int;
    /**
     * @return IElevatorCall[]
     */
    public function getElevatorCalls(): array;

    public function setElevatorCalls(IElevatorCall ...$calls):IState;
    public function setNumberOfFloors(int $number): IState;
    public function setCurrentFloor(int $floor): IState;
    public function setTargetFloor(int $floor): IState;
}