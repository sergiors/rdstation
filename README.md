RDStation Integration
---------------------


How to use
----------

```php
use Sergiors\RDStation\RDStation;
use Sergiors\RDStation\Lead;

$rdstation = new RDStation(/* token */, $request);
$lead = new Lead($rdstation, 'RDStation Integration Github', 'jimi@hendrix.com');
$lead->addParam('name', 'Jimi Hendrix');
$lead->addTag('fender')->addTag('marshall')->addTag('fuzzface');

$lead->trigger();
```

License
-------
MIT
