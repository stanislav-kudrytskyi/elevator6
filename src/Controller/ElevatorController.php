<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 12:21 PM
 */

namespace App\Controller;

use App\Contracts\Elevator\Strategy\IStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class ElevatorController extends Controller
{
    public function main(IStrategy $strategy)
    {
        return new JsonResponse($strategy->resolve()->toArray());
    }

    public function resolveState()
    {

    }
}