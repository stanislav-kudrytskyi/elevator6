<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 09:15
 */

namespace App\Tests\Services\Elevator\Call;

use App\Contracts\Elevator\Call\IElevatorCall;
use App\Contracts\Elevator\Call\IFromCabinCall;
use App\Services\Elevator\Call\FromCabinCall;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class FromCabinCallTest extends TestCase
{
    /**
     * @dataProvider getValidCalls
     */
    public function testFromCabinCallInitialization($floor)
    {
        $call = new FromCabinCall();
        $this->assertInstanceOf(IElevatorCall::class, $call);
        $this->assertInstanceOf(IFromCabinCall::class, $call);
        $call->setFloor($floor);
        $this->assertEquals($floor, $call->getFloor());
    }

    /**
     * @expectedException \App\Services\Elevator\ElevatorException
     * @expectedExceptionCode 412
     */
    public function testFloorNumberIsPositive()
    {
        (new FromCabinCall())->setFloor(-1);
    }

    public function getValidCalls()
    {
        return [[3], [5], [6]];
    }
}
