# Behat Mock Extension

Let the mock engine you want come to help you in your behat tests by mocking the Symfony services.

*Only Behat 2 supported for now*.

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

Then use the mock created the way your mock engine works.

## Credit

Initial concept come from : https://github.com/PolishSymfonyCommunity/Symfony2MockerExtension

but Mockery drives me crazy...
