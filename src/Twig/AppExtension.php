<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use App\Repository\ConfigurationRepository;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
			new TwigFilter('my_url_encode', [$this, 'myUrlEncode']),
        ];
    }

    public function myUrlEncode($text) {
	    // replace non letter or digits by -
		  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

		  // transliterate
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		  // remove unwanted characters
		  $text = preg_replace('~[^-\w]+~', '', $text);

		  // trim
		  $text = trim($text, '-');

		  // remove duplicate -
		  $text = preg_replace('~-+~', '-', $text);

		  // lowercase
		  $text = strtolower($text);

		  if (empty($text)) {
		    return 'n-a';
		  }

		  return $text;
	}

	public function convertEuro($value){
		$value = floatval($value)*$this->rateEuro;
		return $value;
	}
	


}