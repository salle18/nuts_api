<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseMigrations;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $this->afterApplicationCreated(array($this, 'seedDatabase'));

        return $app;
    }

    protected function seedDatabase()
    {
        factory(App\Currency::class, 10)
            ->create()
            ->each(function ($currency) {
                factory(App\Account::class, 2)
                    ->make()
                    ->each(function ($account) use ($currency) {
                        $currency->account()->save($account);
                        factory(App\Transaction::class, 10)
                            ->make()
                            ->each(function ($transaction) use ($account) {
                                $account->transactions()->save($transaction);
                            });
                    });
            });
    }
}
