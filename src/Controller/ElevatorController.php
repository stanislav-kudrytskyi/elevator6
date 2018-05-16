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
    public function resolve(IStrategy $strategy)
    {
        return new JsonResponse($strategy->resolve()->toArray());
    }

    public function index()
    {
		//I don't want upload vendor folder via sftp, Twig Bundle is not installed
		return new Response('<!DOCTYPE html><html><head><meta charset=utf-8><meta name=viewport content="width=device-width,initial-scale=1"><title>vue-elevator</title><link href=/static/css/app.e6ec141159a54c2df1c213e4492a4c9f.css rel=stylesheet></head><body><div id=app></div><script type=text/javascript src=/static/js/manifest.eeb2c031c0c552bd70ec.js></script><script type=text/javascript src=/static/js/app.8cbb2f49b262e142e8c9.js></script></body></html>');
    }
}