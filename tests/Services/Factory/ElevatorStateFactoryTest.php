<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 6:26 PM
 */

namespace App\Tests\Services\Factory;


use App\Services\Factory\ElevatorStateFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;

class ElevatorStateFactoryTest extends TestCase
{
    protected $requestStack;

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->requestStack = $this->createMock(RequestStack::class);
    }

    public function testBuildState()
    {
        $elevatorState = ElevatorStateFactory::buildState($this->requestStack);
        $this->assertEquals(0, $elevatorState->getNumberOfFloors());
    }
}