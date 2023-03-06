<h1 align="center"> form-schema-sdk </h1>

<p align="center"> .</p>


## Installing

```shell
$ composer require cblink-service/form-schema-sdk -vvv
```

## Usage

```php

use Cblink\Service\FormSchema\Table;
use Cblink\Service\FormSchema\Schema;
use Cblink\Service\FormSchema\Consts\FormSearchConst;

$config = [
    'appid' => 'xxx',
    'secret' => 'xxxx',
    // base_url ...
];

$schema = new Schema($config);

$schema->table('category', function (Table $table) {
    $table->comment('分类');
    $table->field('name')->label('分类名称')->rules(['required', 'string'])
    $table->field('sort')->label('权重')->default(999);
    
    $table->searchable('sort')->type(FormSearchConst::TYPE_EQ);
    // 不需要添加created_at 与 updated_at
    // ...
});

```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/cblink-service/form-schema-sdk/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/cblink-service/form-schema-sdk/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT