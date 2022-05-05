<?php

namespace Webfactory\Bundle\PhumborBundle\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use Thumbor\Url\BuilderFactory;
use Webfactory\Bundle\PhumborBundle\Transformer\BaseTransformer;
use Webfactory\Bundle\PhumborBundle\Transformer\Exception\UnknownTransformationException;

/**
 * Description of BaseTransformerTest.
 *
 * @author jobou
 */
class BaseTransformerTest extends TestCase
{
    /**
     * @var \Webfactory\Bundle\PhumborBundle\Transformer\BaseTransformer
     */
    private $transformer;

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
        $this->transformer = new BaseTransformer(
            $this->factory,
            [
                'width_50' => [
                    'resize' => ['width' => 50, 'height' => 0],
                ],
            ]
        );
    }

    /**
     * Test without transformation.
     *
     * @test
     */
    public function emptyTransformation()
    {
        $transformedUrl = $this->transformer->transform('http://phumbor.jb.fr/logo.png', null);
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png');

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test normal transformation.
     *
     * @test
     */
    public function normalTransformation()
    {
        $transformedUrl = $this->transformer->transform('http://phumbor.jb.fr/logo.png', 'width_50');
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->resize(50, 0);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * @test
     */
    public function unknownTransformationException()
    {
        self::expectException(UnknownTransformationException::class);
        $transformedUrl = $this->transformer->transform('http://phumbor.jb.fr/logo.png', 'not_known');
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png');

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test override transformation.
     *
     * @test
     */
    public function overrideTransformation()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            'width_50',
            ['resize' => ['width' => 40, 'height' => 0]]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->resize(40, 0);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test multiple transformation.
     *
     * @test
     */
    public function multipleTransformation()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            'width_50',
            [
                'resize' => ['width' => 40, 'height' => 0],
                'fit_in' => ['width' => 40, 'height' => 0],
            ]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->resize(40, 0)->fitIn(40, 0);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test trim without color.
     *
     * @test
     */
    public function trimWithoutColor()
    {
        $transformedUrl = $this->transformer->transform('http://phumbor.jb.fr/logo.png', null, ['trim' => false]);
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->trim(false);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test trim with color.
     *
     * @test
     */
    public function trimWithColor()
    {
        $transformedUrl = $this->transformer->transform('http://phumbor.jb.fr/logo.png', null, ['trim' => 'color']);
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->trim('color');

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test crop.
     *
     * @test
     */
    public function crop()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['crop' => ['top_left_x' => 10, 'top_left_y' => 10, 'bottom_right_x' => 10, 'bottom_right_y' => 10]]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->crop(10, 10, 10, 10);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test crop.
     *
     * @test
     */
    public function resize()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['resize' => ['width' => 10, 'height' => 10]]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->resize(10, 10);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test crop.
     *
     * @test
     */
    public function fitIn()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['fit_in' => ['width' => 10, 'height' => 10]]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->fitIn(10, 10);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test fullFitIn.
     *
     * @test
     */
    public function fullFitIn()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['full_fit_in' => ['width' => 10, 'height' => 10]]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->fullFitIn(10, 10);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test halign.
     *
     * @test
     */
    public function halign()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['halign' => 'center']
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->halign('center');

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test valign.
     *
     * @test
     */
    public function valign()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['valign' => 'middle']
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->valign('middle');

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test smartCrop.
     *
     * @test
     */
    public function smartCrop()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['smart_crop' => true]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->smartCrop(true);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test metadataOnly.
     *
     * @test
     */
    public function metadataOnly()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['metadata_only' => true]
        );
        $buildedUrl = $this->factory->url('http://phumbor.jb.fr/logo.png')->metadataOnly(true);

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test filters.
     *
     * @test
     */
    public function filters()
    {
        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            [
                'filters' => [
                    ['name' => 'brightness', 'arguments' => 56],
                    ['name' => 'color', 'arguments' => ['black', 'red']],
                ],
            ]
        );

        $buildedUrl = $this
            ->factory
            ->url('http://phumbor.jb.fr/logo.png')
            ->addFilter('brightness', 56)
            ->addFilter('color', 'black', 'red')
        ;

        $this->assertEquals($transformedUrl, $buildedUrl);
    }

    /**
     * Test setFactory.
     *
     * @test
     */
    public function setFactory()
    {
        $overrideFactory = new BuilderFactory('http://mynewhostname', '123456799');
        $this->transformer->setFactory($overrideFactory);

        $transformedUrl = $this->transformer->transform(
            'http://phumbor.jb.fr/logo.png',
            null,
            ['metadata_only' => true]
        );
        $buildedUrl = $overrideFactory->url('http://phumbor.jb.fr/logo.png')->metadataOnly(true);
        $this->assertEquals($transformedUrl, $buildedUrl);
    }
}
