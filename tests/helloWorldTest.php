<?php

namespace \tests;

require_once __DIR__ . './project';

use atoum;

class HelloWorld extends atoum {
    public function testGetHiAtoum
    {
        $this
            ->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getHiAtoum())
                    -isEqualTo('hi atoum!')
    }
}

?>