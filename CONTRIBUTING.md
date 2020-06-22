# LinkCutter Contributing Guide

In order to maintain the project organized, please follow this steps before send any pull requests.

1) Create an issue or grab an issue before send your PR's.
2) Fork the repository to your Github's account.
3) Go to the repository folder and do the project setup (check the docs).


## Coding Style

LinkCutter follows the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard and the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard.

### PHPDoc

Below is an example of a valid Laravel documentation block. Note that the `@param` attribute is followed by two spaces, the argument type, two more spaces, and finally the variable name:
```php
/**
 * Register a binding with the container.
 *
 * @param  string|array  $abstract
 * @param  \Closure|string|null  $concrete
 * @param  bool  $shared
 * @return void
 * @throws \Exception
 */
public function bind($abstract, $concrete = null, $shared = false)
{
    //
}

```

If you have any question please, [open a issue](https://github.com/ilicmarko/linkcutter/issues)!
