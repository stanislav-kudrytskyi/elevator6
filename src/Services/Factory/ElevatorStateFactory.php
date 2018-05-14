<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 2:20 PM
 */

namespace App\Services\Factory;


use App\Contracts\Elevator\IState;
use App\Services\Elevator\State;
use Symfony\Component\HttpFoundation\RequestStack;

class ElevatorStateFactory
{
    /**
     * @param RequestStack $stack
     * @return IState
     */
    public static function buildState(RequestStack $stack)
    {
        $request = $stack->getCurrentRequest();

        $state = new State();
        return $state;
    }
}