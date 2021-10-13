<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('highlight', [$this, 'highlight']),
        ];
    }

    public function highlight($text, $terms)
    {
        if (!is_array($terms)) $terms = [ $terms, ];
        $highlight = array();
        foreach($terms as $term) {
            $highlight[]= '<span class="highlight">'.$term.'</span>';
        }

        return str_ireplace($terms, $highlight, $text);
    }
}