<?php
/**
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@gmail.com>
 * Date: 5/15/2018
 * Time: 09:26
 */

namespace App\Contracts;

interface ISelfValidated
{
	/**
	 * @return bool
	 * @throws \Exception
	 */
	public function validate(): bool;
}