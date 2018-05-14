<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 12:21 PM
 */

namespace App\Controller;


use App\Contracts\Elevator\IState;
use Symfony\Component\HttpFoundation\Response;

class ElevatorController
{
    public function main(IState $state)
    {
        $state->getCurrentTargetFloor();
        return new Response('Hi monkey');
    }

    public function resolveState()
    {

    }
}