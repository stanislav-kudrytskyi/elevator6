<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 2:20 PM
 */

namespace App\Services\Factory;

use App\Contracts\Elevator\Call\IFromCabinCall;
use App\Contracts\Elevator\Call\IOutsideCabinCall;
use App\Contracts\Elevator\IState;
use App\Contracts\Elevator\Strategy\ICrazyMonkeyStrategy;
use App\Contracts\ISelfValidated;
use App\Services\Elevator\ElevatorException;
use App\Services\Elevator\State;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ElevatorFactory
{
	protected $container;
	protected $request;


	public function __construct(RequestStack $stack, ContainerInterface $container)
	{
		$this->request = $stack->getCurrentRequest();
		$this->container = $container;
	}

	protected function buildElevatorCall(array $callData)
	{
		if (!empty($callData['to'])) {
			/**
			 * @var IFromCabinCall $call;
			 */
			$call = $this->container->get(IFromCabinCall::class);
			$call->setFloor($callData['to']);
			return $call;
		}
		/**
		 * @var IOutsideCabinCall $call
		 */
		$call = $this->container->get(IOutsideCabinCall::class);
		$call->setFloor($callData['from']);
		$call->setDirection($callData['direction']);
		return $call;
	}

	/**
	 * @return IState
	 * @throws \Exception
	 */
    public function buildState()
    {
		$calls = $this->request->get('calls');
		$calls = is_array($calls) ? $calls : [];

		foreach ($calls as $key => $data) {
			$calls[$key] = $this->buildElevatorCall($data);
		}

		/**
		 * @var IState|ISelfValidated $state
		 */
        $state = (new State());
        $state->setElevatorCalls(...$calls)
			->setNumberOfFloors($this->request->get('numberOfFloors', 0))
			->setCurrentFloor($this->request->get('currentFloor', 0))
			->setTargetFloor($this->request->get('targetFloor', 0))
			->setPersonsInside($this->request->get('personsInside'));

        $state->validate();
        return $state;
    }

    public function buildStrategy()
	{
		switch ($this->request->get('strategy')) {
			case 'monkey':
				return $this->container->get(ICrazyMonkeyStrategy::class);
		}

		throw new ElevatorException('Specified strategy is not supported', 405);
	}
}