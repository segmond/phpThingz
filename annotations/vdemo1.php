<?php
namespace Foo;
require __DIR__ .'/vendor/autoload.php';

use \Doctrine\Common\Annotations\Annotation;
use \Doctrine\Common\Annotations\AnnotationReader;
use \Doctrine\Common\Annotations\FileCacheReader;

/**
 * @Annotation
 */
final class Validate extends Annotation {
	public $type;
	public $required = false;
}

// @Foo\Validate(type="string", required=false)

$reader = new FileCacheReader(new AnnotationReader(), "/tmp/mycachepath", $debug=true);
//var_dump($reader);

class User {
	/** 
	 * @Foo\Validate(type="string", required=false)
	 */
	protected $first_name;

	/** 
	 * @Foo\Validate(type="string", required=true)
	 */
	protected $last_name;
}

$john = new User();
$property = new \ReflectionProperty('Foo\User', 'first_name');
$annotations = $reader->getPropertyAnnotations($property);
var_dump($annotations);

$property = new \ReflectionProperty('Foo\User', 'last_name');
$annotations = $reader->getPropertyAnnotations($property);
var_dump($annotations);

var_dump("--------------------------------");
foreach ($annotations as $a) {
	var_dump($a);
	if ($a instanceof \Foo\Validate) {
		echo "match\n";
	}
}
