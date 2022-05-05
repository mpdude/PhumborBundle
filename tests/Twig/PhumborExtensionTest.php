<?php

namespace Webfactory\Bundle\PhumborBundle\Tests\Twig;

use PHPUnit\Framework\TestCase;
use Thumbor\Url\BuilderFactory;
use Webfactory\Bundle\PhumborBundle\Transformer\BaseTransformer;
use Webfactory\Bundle\PhumborBundle\Twig\PhumborExtension;

/**
 * Description of PhumborExtensionTest.
 *
 * @author jobou
 */
class PhumborExtensionTest extends TestCase
{
    /**
     * @var \Webfactory\Bundle\PhumborBundle\Twig\PhumborExtension
     */
    private $extension;

    /**
     * @var \Thumbor\Url\BuilderFactory
     */
    private $factory;

    /**
     * SetUp.
     */
    protected function setUp(): void
    {
        $this->factory = new BuilderFactory('http://localhost', '123456789');
        $transformer = new BaseTransformer(
            $this->factory,
            [
                'width_50' => [
                    'resize' => ['width' => 50, 'height' => 0],
                ],
            ]
        );
        $this->extension = new PhumborExtension($transformer);
    }

    /**
     * Test twig getFilters.
     *
     * @test
     */
    public function getFilters()
    {
        $this->assertEquals(\count($this->extension->getFilters()), 1);
    }

    /**
     * Test twig getFunctions.
     *
     * @test
     */
    public function getFunctions()
    {
        $this->assertEquals(\count($this->extension->getFunctions()), 1);
    }

    /**
     * Test twig get filters.
     *
     * @test
     */
    public function transform()
    {
        $transformedUrl = $this->extension->transform('logo.png', 'width_50');
        $builtUrl = $this->factory->url('logo.png')->resize(50, 0);

        $this->assertEquals($builtUrl, $transformedUrl);
    }
}
