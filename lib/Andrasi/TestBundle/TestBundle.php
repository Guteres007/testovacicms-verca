<?php

namespace Andrasi\TestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TestBundle extends Bundle
{
    public function make() {
        return 'ok';
    }


}
