<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 6:26 PM
 */

namespace App\Tests\Services\Factory;


use App\Contracts\Elevator\Call\IElevatorCall;
use App\Contracts\Elevator\Call\IFromCabinCall;
use App\Contracts\Elevator\Call\IOutsideCabinCall;
use App\Services\Elevator\Call\FromCabinCall;
use App\Services\Elevator\Call\OutsideCabinCall;
use App\Services\Factory\ElevatorFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ElevatorFactoryTest extends TestCase
{
    protected $requestStack;
    protected $request;
    protected $container;

    protected function setUp()
    {
        $parameters = json_decode('{
  "numberOfFloors" : 5,
  "currentFloor": 5,
  "personsInside": 2,
  "calls": [
  	{
  		"direction": "up",
  		"from": 4,
  		"to": null
  	},
  	{
  		"direction": "up",
  		"from": 1,
  		"to": null
  	},
  	{
  		"to": 2
  	}
  ]
}', true);

        $this->request = Request::create('/elevator', 'POST', $parameters);

        $this->requestStack = $this->createMock(RequestStack::class);
        $this->requestStack->method('getCurrentRequest')->willReturn($this->request);
        $this->container = $this->createMock(Container::class);
        $this->container->method('get')->will(
            $this->onConsecutiveCalls(
                new OutsideCabinCall(),
                new OutsideCabinCall(),
                new FromCabinCall()
            )
        );

    }

    public function testBuildState()
    {
        $this->assertInstanceOf(RequestStack::class, $this->requestStack);
        $elevatorState = (new ElevatorFactory($this->requestStack, $this->container))->buildState();
        $this->assertEquals(5, $elevatorState->getNumberOfFloors());
        $this->assertEquals(5, $elevatorState->getCurrentFloor());
        $this->assertEquals(0, $elevatorState->getCurrentTargetFloor());
        $this->assertEquals(2, $elevatorState->getNumberOfPersonsInside());
        $this->assertInternalType('array', $elevatorState->getElevatorCalls());

        $calls = $elevatorState->getElevatorCalls();
        $this->assertEquals(3, count($calls));
        $this->assertInstanceOf(IElevatorCall::class, $calls[0]);

        $calls = $elevatorState->getOutsideCabinCalls();
        $this->assertEquals(2, count($calls));
        $this->assertInstanceOf(IOutsideCabinCall::class, $calls[0]);

        $calls = $elevatorState->getFromCabinCalls();
        $this->assertEquals(1, count($calls));
        $this->assertInstanceOf(IFromCabinCall::class, $calls[0]);
    }
}
