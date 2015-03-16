<?php

namespace MCDH\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MCDHUserBundle extends Bundle
{
	public function getParent(){
		return 'FOSUserBundle';
	}
}
