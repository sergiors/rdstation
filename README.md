RDStation Integration
---------------------


How to use
----------

```php
use Sergiors\RDStation\Credentials;
use Sergiors\RDStation\RDStation;
use Sergiors\RDStation\Lead;

$credentials = new Credentials(/* token */, /* private_token */);
$rdStation = new RDStation($credentials, $request);
$lead = new Lead($rdStation, 'RDStation Integration Github', 'jimi@hendrix.com');
$lead->addParam('name', 'Jimi Hendrix');
$lead->addTag('fender')->addTag('marshall')->addTag('fuzzface');

$lead->trigger();
```

License
-------
MIT
