<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 12:36
 */

namespace App\Services\Elevator;

use App\Contracts\Elevator\IStateResolution;

class StateResolution implements IStateResolution
{
    protected $direction;
    protected $targetFloor;

    public function __construct(int $targetFloor, string $direction = null)
    {
        $this->targetFloor = $targetFloor;
        $this->direction = $direction;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function getTargetFloor()
    {
        return $this->targetFloor;
    }

    public function toArray(): array
    {
        return [
            'direction' => $this->getDirection(),
            'targetFloor' => $this->getTargetFloor(),
        ];
    }
}