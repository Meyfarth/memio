<?php

/*
 * This file is part of the Medio project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\Medio\Examples;

use Gnugat\Medio\Model\Constant;
use Gnugat\Medio\Model\ConstantCollection;

class ConstantCollectionTest extends PrettyPrinterTestCase
{
    public function testZeroConstants()
    {
        $constantCollection = new ConstantCollection();

        $generatedCode = $this->prettyPrinter->generateCode($constantCollection);

        $this->assertSame('', $generatedCode);
    }

    public function testOneConstant()
    {
        $constantCollection = ConstantCollection::make()
            ->add(new Constant('MY_CONSTANT', '0'))
        ;

        $generatedCode = $this->prettyPrinter->generateCode($constantCollection);

        $this->assertExpectedCode($generatedCode);
    }

    public function testThreeConstants()
    {
        $constantCollection = ConstantCollection::make()
            ->add(new Constant('FIRST_CONSTANT', '0'))
            ->add(new Constant('SECOND_CONSTANT', '1'))
            ->add(new Constant('THIRD_CONSTANT', '2'))
        ;

        $generatedCode = $this->prettyPrinter->generateCode($constantCollection);

        $this->assertExpectedCode($generatedCode);
    }
}
