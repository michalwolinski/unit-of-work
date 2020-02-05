# Unit of Work for Laravel

Unit of Work (Entity Manager) design pattern Laravel implementation.

---
## Installation by Composer
1. Run
    ```php   
    composer require michalwolinski/unit-of-work
    ``` 
    in console to install this library.
---

## Usage

I propose to use Dependency Injection to inject `UnitOfWorkInterface`.

Example implementation in service class:
```php

use App\User;
use MichalWolinski\UnitOfWork\Interfaces\UnitOfWorkInterface;

class Service {

    /**
     * @var UnitOfWorkInterface
     */
    private UnitOfWorkInterface $unitOfWork;

    public function __construct(UnitOfWorkInterface $unitOfWork)
    {
        $this->unitOfWork = $unitOfWork;
    }

    public function example()
    {
        $user           = new User();
        $user->email    = 'firma@haxmedia.pl';
        $user->name     = 'Michal Wolinski';
        $user->password = 'secret';

        $user2           = new User();
        $user2->email    = 'example@company.com';
        $user2->name     = 'John Doe';
        $user2->password = 'secret';

        // CREATE RECORDS
        $this->unitOfWork->insert($user);
        $this->unitOfWork->insert($user2);
        $this->unitOfWork->commit();

        dump($user2->getKey());

        // UPDATE RECORDS
        $user2->name = 'Jane Doe';
        $this->unitOfWork->update($user2);
        $this->unitOfWork->commit();

        // REMOVE RECORDS
        $this->unitOfWork->delete($user2);
        $this->unitOfWork->commit();
    }
}
```

## Authors

* **Michal Wolinski** - [Haxmedia](https://haxmedia.pl)

## License

This project is licensed under the MIT License.