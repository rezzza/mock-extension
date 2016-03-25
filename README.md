# Behat Mock Extension

**DEPRECATED** We no longer provide support for this extension. Feel free to fork.

Let the mock engine that you want coming to help you in your behat tests by mocking the Symfony services.

* dev-master : Behat 2.5.x
* dev-behat3 : Behat 3.0.x

## Adapters

* Atoum : https://github.com/atoum/atoum

## Setup

**1** - Declare to use the extension in your `behat.yml`

```yml
default:
    extensions:
        Rezzza\MockExtension\Extension: ~
```

**2** - Implements `Rezzza\MockExtension\MockAware` interface on your context.

**3** - Override `AppKernel::getContainerBaseClass`
```php
    protected function getContainerBaseClass()
    {
        if ('test' == $this->environment) {
            return 'Rezzza\MockExtension\MockContainer';
        }

        return parent::getContainerBaseClass();
    }
```

## Usage

In your context create mock for your services :
```php
use Rezzza\MockExtension\Adapter\AtoumAdapter;

$mockGoutte = $this->mocker->mockService(
    'my.goutte_client',
    new AtoumAdapter('\Behat\Mink\Driver\Goutte\Client')
);
```

Then follow the instructions of your mock engine to use the result

## Contribute

If you want to see your prefered mock engine, you can make a PR by creation the adapter.

It just needs to follow `Rezzza\MockExtension\MockEngine` interface.

## Credit

Initial concept come from : https://github.com/PolishSymfonyCommunity/Symfony2MockerExtension

but Mockery drives me crazy...
