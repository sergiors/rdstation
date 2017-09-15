RDStation Integration
---------------------


How to use
----------

```php
use Sergiors\RDStation\ApiKey;
use Sergiors\RDStation\RDStation;
use Sergiors\RDStation\Lead;

$apiKey = new ApiKey(/* token */, /* private_token */);
$rdstation = new RDStation($apiKey, $request);
$lead = new Lead($rdstation, 'RDStation Integration Github', 'jimi@hendrix.com');
$lead->addParam('name', 'Jimi Hendrix');
$lead->addTag('fender')->addTag('marshall')->addTag('fuzzface');

$lead->trigger();
```

License
-------
MIT
