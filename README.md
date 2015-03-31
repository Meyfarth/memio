# Memio [![SensioLabsInsight](https://insight.sensiolabs.com/projects/a2b24423-9840-45ab-a011-598aa3ba26bf/mini.png)](https://insight.sensiolabs.com/projects/a2b24423-9840-45ab-a011-598aa3ba26bf) [![Travis CI](https://travis-ci.org/memio/memio.png)](https://travis-ci.org/memio/memio)

> **Caution**: Memio is being renamed (previously gnugat/medio) and split into smaller packages.

Memio is a library, it allows you to describe PHP code by initializing "Model" classes
(e.g. `new Method('__construct')`) and then to generate it using a `PrettyPrinter`!

> **Note**: The actual generation logic is hold by [Twig templates](http://twig.sensiolabs.org/).
> If the coding style provided doesn't appeal to you, you can overwrite those templates easily.

## Installation

Install it using [Composer](https://getcomposer.org/download):

    composer require memio/memio:~1.0@rc

## Full example

We're going to generate a class with a constructor and two attributes:

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Memio\Memio\Config\Path;
use Memio\Memio\PrettyPrinter;
use Memio\Memio\Validator;
use Memio\Memio\Model\File;
use Memio\Memio\Model\Object;
use Memio\Memio\Model\Property;
use Memio\Memio\Model\Method;
use Memio\Memio\Model\Argument;

// Initialize the code generator
$loader = new \Twig_Loader_Filesystem(Path::templates());
$twig = new \Twig_Environment($loader);
$prettyPrinter = new PrettyPrinter($twig);

// Describe the code you want to generate using "Models"
$file = File::make('src/Vendor/Project/MyService.php')
    ->setStructure(
        Object::make('Vendor\Project\MyService')
            ->addProperty(new Property('createdAt'))
            ->addProperty(new Property('filename'))
            ->addMethod(
                Method::make('__construct')
                    ->addArgument(new Argument('DateTime', 'createdAt'))
                    ->addArgument(new Argument('string', 'filename'))
            )
    )
;

// Optionally check that you didn't create any syntax error
$validate = new Validator();
$validate->validate($file); // @throws Memio\Memio\Exception\InvalidModelException

// Generate the code and display in the console
echo $prettyPrinter->generateCode($file);

// Or display it in a browser
// echo '<pre>'.htmlspecialchars($prettyPrinter->generateCode($file)).'</pre>';
```

With this simple example, we get the following output:

```
<?php

namespace Vendor\Project;

class MyService
{
    private $createdAt;

    private $filename;

    public function __construct(DateTime $createdAt, $filename)
    {
    }
}
```

## Want to know more?

Memio can be quite powerful, discover how by reading the docs:

* [Model Tutorial](doc/01-model-tutorial.md)
* [PHPdoc Tutorial](doc/02-phpdoc-tutorial.md)
* [Validation Tutorial](doc/03-validation-tutorial.md)
* [Examples](doc/04-examples.md)
* [Templates](doc/05-templates.md)

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/memio/memio/releases)
* the file listing the [changes between versions](CHANGELOG.md)

And finally some meta documentation:

* [copyright and MIT license](LICENSE)
* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)

## Roadmap

* commands (e.g. add use statement, add PHPdoc, injecting dependency, etc)
* parsing existing code (using [nikic](http://nikic.github.io/aboutMe.html)'s [PHP-Parser](https://github.com/nikic/PHP-Parser))
* TemplateEngine interface, to allow the choice between Twig and basic PHP templating
