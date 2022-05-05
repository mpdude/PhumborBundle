<?php

namespace Webfactory\Bundle\PhumborBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Webfactory\Bundle\PhumborBundle\Transformer\BaseTransformer;

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

    public function getFilters(): array
    {
        return [
            new TwigFilter('thumbor', [$this, 'transform']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('thumbor', [$this, 'transform']),
        ];
    }

    public function transform(string $orig, string $transformation = null, array $overrides = []): string
    {
        return $this->transformer->transform($orig, $transformation, $overrides);
    }
}
