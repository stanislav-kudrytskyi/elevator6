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
use Symfony\Component\HttpFoundation\Response;

class ElevatorController extends Controller
{
    public function main(IStrategy $strategy)
    {
        return new JsonResponse($strategy->resolve()->toArray());
    }

    public function index()
    {
		//return $this->render('index.html');
		return new Response('<!DOCTYPE html><html><head><meta charset=utf-8><meta name=viewport content="width=device-width,initial-scale=1"><title>vue-elevator</title><link href=/static/css/app.4836c1a1faa6db2a67aae4724affceae.css rel=stylesheet></head><body><div id=app></div><script type=text/javascript src=/static/js/manifest.eeb2c031c0c552bd70ec.js></script><script type=text/javascript src=/static/js/app.57305a7a2b3adc929640.js></script></body></html>');
    }
}