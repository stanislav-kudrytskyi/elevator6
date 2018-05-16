<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/16/2018
 * Time: 5:09 PM
 */

namespace App\Tests\Services\Elevator;

use App\Contracts\Elevator\IState;
use App\Contracts\Elevator\IStateResolution;
use App\Contracts\Elevator\Strategy\IStrategy;
use App\Services\Elevator\Call\FromCabinCall;
use App\Services\Elevator\Call\OutsideCabinCall;
use App\Services\Elevator\State;
use App\Services\Elevator\Strategy\StandardStrategy;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class StandardStrategyTest extends TestCase
{
    protected function mockState(array $data)
    {
        $state = $this->createMock(State::class);
        $state->method('getNumberOfFloors')->willReturn($data['numberOfFloors']);
        $state->method('getNumberOfPersonsInside')->willReturn($data['personsInside']);
        $state->method('getCurrentFloor')->willReturn($data['currentFloor']);
        $state->method('getCurrentDirection')->willReturn($data['direction']);
        $state->method('getCurrentTargetFloor')->willReturn($data['currentTargetFloor']);
        $state->method('getFromCabinCalls')->willReturn($data['fromCabinCalls']);
        $state->method('getOutsideCabinCalls')->willReturn($data['outsideCabinCalls']);
        return [$state, $data['RESULT'],];
    }

    /**
     * @param IState $state
     * @dataProvider getStatesSet
     */
    public function testResolve(IState $state, array $result)
    {
        $strategy = new StandardStrategy($state);
        $this->assertInstanceOf(IStrategy::class, $strategy);
        $solution = $strategy->resolve();
        $this->assertInstanceOf(IStateResolution::class, $solution);
        $this->assertEquals($result['floor'], $solution->getTargetFloor());
    }

    public function getStatesSet()
    {
        $set = [
            'motionless elevator - open door on current floor' => [
                'numberOfFloors' => 5,
                'personsInside' => 0,
                'currentFloor' => 1,
                'direction' => null,
                'currentTargetFloor' => null,
                'fromCabinCalls' => [],
                'outsideCabinCalls' => [
                    (new OutsideCabinCall())->setFloor(1)->setDirection('up')
                ],
                'RESULT' => ['floor' => 1, ],
            ],
            'motionless elevator - single call' => [
                'numberOfFloors' => 5,
                'personsInside' => 0,
                'currentFloor' => 1,
                'direction' => null,
                'currentTargetFloor' => null,
                'fromCabinCalls' => [],
                'outsideCabinCalls' => [
                    (new OutsideCabinCall())->setFloor(3)->setDirection('up')
                ],
                'RESULT' => ['floor' => 3, ],
            ],
            'motionless elevator - choose nearest floor' => [
                'numberOfFloors' => 6,
                'personsInside' => 0,
                'currentFloor' => 4,
                'direction' => null,
                'currentTargetFloor' => null,
                'fromCabinCalls' => [],
                'outsideCabinCalls' => [
                    (new OutsideCabinCall())->setFloor(5)->setDirection('up'),
                    (new OutsideCabinCall())->setFloor(2)->setDirection('down')
                ],
                'RESULT' => ['floor' => 5, ],
            ],
            'in move elevator - skip call with mismatched direction' => [
                'numberOfFloors' => 6,
                'personsInside' => 2,
                'currentFloor' => 1,
                'direction' => 'up',
                'currentTargetFloor' => '2',
                'fromCabinCalls' => [
                    (new FromCabinCall())->setFloor(6),
                ],
                'outsideCabinCalls' => [
                    (new OutsideCabinCall())->setFloor(2)->setDirection('down')
                ],
                'RESULT' => ['floor' => 6, ],
            ],
            'in move elevator - stop to pick up a person with matched direction' => [
                'numberOfFloors' => 6,
                'personsInside' => 2,
                'currentFloor' => 1,
                'direction' => 'up',
                'currentTargetFloor' => '2',
                'fromCabinCalls' => [
                    (new FromCabinCall())->setFloor(6),
                ],
                'outsideCabinCalls' => [
                    (new OutsideCabinCall())->setFloor(2)->setDirection('up')
                ],
                'RESULT' => ['floor' => 2, ],
            ],
        ];

        return array_map(function ($state) {
            return $this->mockState($state);
        }, $set);
    }
}