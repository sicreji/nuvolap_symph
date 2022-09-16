<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DemoExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('toto', [$this, 'doSomething']),
            new TwigFilter('uppercase', [$this, 'doUpperCase']),
            new TwigFilter('array_len', [$this, 'doArrayLen']),
            new TwigFilter('wrapper', [$this, 'doWrap']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('lipsum', [$this, 'doLipsum']),
        ];
    }

    public function doSomething(string $value)
    {
        return "toto";
    }

    public function doUpperCase(string $value)
    {
        return mb_strtoupper($value);
    }

    public function doArrayLen(array $value)
    {
        return sizeof($value);
    }

    public function doWrap(string $value)
    {
        return '<p class="danger">'. $value .'</p>';
    }

    public function doLipsum($limit=100)
    {
        $texte = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel mollis nibh, vitae mollis neque. Suspendisse varius massa non velit efficitur, eu eleifend nibh vestibulum. Curabitur sodales lorem risus, nec vulputate quam faucibus at. Nulla facilisi. Sed lacinia vestibulum lacinia. Etiam vitae lectus blandit, fringilla nibh vitae, dignissim ex. Cras vel molestie nisl. Maecenas id metus fermentum, tincidunt erat ut, iaculis metus. Ut a congue urna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Duis sit amet vehicula nisl. Nunc interdum tortor id tincidunt tempor. Cras id consectetur metus. Nulla orci ex, luctus eget posuere ac, convallis a diam. Suspendisse eget risus lacus.";
        return substr($texte, 0, $limit);
    }
    
}
