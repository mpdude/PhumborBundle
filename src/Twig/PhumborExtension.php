<?php

namespace Webfactory\Bundle\PhumborBundle\Twig;

use Webfactory\Bundle\PhumborBundle\Transformer\BaseTransformer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PhumborExtension extends AbstractExtension
{
    /**
     * @var BaseTransformer
     */
    private $transformer;

    public function __construct(BaseTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('thumbor', array($this, 'transform')),
        );
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('thumbor', array($this, 'transform')),
        );
    }

    public function transform(string $orig, string $transformation = null, array $overrides = array()): string
    {
        return $this->transformer->transform($orig, $transformation, $overrides);
    }
}
