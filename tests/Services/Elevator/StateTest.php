<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 3:35 PM
 */

namespace App\Tests\Services\Elevator;

use App\Services\Elevator\State;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class StateTest extends TestCase
{
    public function testGetCurrentFloor()
    {
        $state = new State();
        $this->assertEquals(0, $state->getNumberOfFloors());
        $this->assertEquals(6, $state->setNumberOfFloors(6)->getNumberOfFloors());
    }
}