<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 3:35 PM
 */

namespace App\Tests\Services\Elevator;

use App\Contracts\Elevator\Call\IElevatorCall;
use App\Services\Elevator\Call\FromCabinCall;
use App\Services\Elevator\Call\OutsideCabinCall;
use App\Services\Elevator\State;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class StateTest extends TestCase
{
    /**
     * @param $numberOfFloors
     * @param $currentFloor
     * @param $targetFloor
     * @param $elevatorCalls
     * @param $personsInside
     * @param $direction
     * @dataProvider getStateData
     */
    public function testGetCurrentFloor(
        $numberOfFloors,
        $currentFloor,
        $targetFloor,
        $elevatorCalls,
        $personsInside,
        $direction
    )
    {
        $state = (new State());
        $this->assertEquals(0, $state->getNumberOfFloors());

        $state->setNumberOfFloors($numberOfFloors)
            ->setCurrentFloor($currentFloor)
            ->setTargetFloor($targetFloor)
            ->setElevatorCalls(...$elevatorCalls)
            ->setPersonsInside($personsInside)
            ->setCurrentDirection($direction);


        $this->assertEquals($numberOfFloors, $state->getNumberOfFloors());
        $this->assertEquals($currentFloor, $state->getCurrentFloor());
        $this->assertEquals($targetFloor, $state->getCurrentTargetFloor());
        $this->assertEquals($personsInside, $state->getNumberOfPersonsInside());
        $this->assertEquals($direction, $state->getCurrentDirection());
        $calls = $state->getElevatorCalls();
        $this->assertEquals(count($elevatorCalls), count($calls));
        $this->assertInstanceOf(IElevatorCall::class, $calls[0]);
    }

    public function getStateData()
    {
        return [
           [
               5,
               1,
               null,
               [
                   (new OutsideCabinCall())->setDirection('down')->setFloor(4),
                   (new FromCabinCall())->setFloor(4),
               ],
                1,
                'up'
           ]
        ];
    }
}