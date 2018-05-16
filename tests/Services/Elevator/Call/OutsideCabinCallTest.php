<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 15:18
 */

namespace App\Tests\Services\Elevator\Call;

use App\Contracts\Elevator\Call\IElevatorCall;
use App\Contracts\Elevator\Call\IOutsideCabinCall;
use App\Services\Elevator\Call\OutsideCabinCall;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class OutsideCabinCallTest extends TestCase
{
    /**
     * @dataProvider getValidCalls
     */
    public function testFromCabinCallInitialization($floor, $direction)
    {
        $call = new OutsideCabinCall();
        $this->assertInstanceOf(IElevatorCall::class, $call);
        $this->assertInstanceOf(IOutsideCabinCall::class, $call);
        $call->setFloor($floor);
        $call->setDirection($direction);
        $this->assertEquals($floor, $call->getFloor());
        $this->assertEquals($direction, $call->getDirection());
    }

    /**
     * @dataProvider getInvalidCalls
     * @expectedException \App\Services\Elevator\ElevatorException
     * @expectedExceptionCode 400
     */
    public function testInvalidParametersOutsideCalls($floor, $direction)
    {
        $call = new OutsideCabinCall();
        $this->assertInstanceOf(IElevatorCall::class, $call);
        $this->assertInstanceOf(IOutsideCabinCall::class, $call);
        $call->setFloor($floor);
        $call->setDirection($direction);
    }

    /**
     * @expectedException \App\Services\Elevator\ElevatorException
     * @expectedExceptionCode 412
     */
    public function testFloorNumberIsPositive()
    {
        (new OutsideCabinCall())->setFloor(-1);
    }

    public function getValidCalls()
    {
        return [
            [3, 'up'],
            [2, 'down'],
            [1, 'up'],
        ];
    }

    public function getInvalidCalls()
    {
        return [
            [1, 'smth'],
            [2, 'downup'],
        ];
    }
}