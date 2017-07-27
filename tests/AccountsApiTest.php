<?php

class AccountsApiTest extends TestCase
{
    /**
     * @group api
     * @group accounts
     */
    public function testIndex()
    {
        $this->get('api/accounts')
            ->seeJsonStructure([
                '*' => ['id', 'description', 'currency_id', 'amount', 'currency' => [
                    'id',
                    'code'
                ]]
            ]);
    }

    /**
     * @group api
     * @group accounts
     */
    public function testShow()
    {
        $this->get('api/accounts/1')
            ->seeJsonStructure(['id', 'description', 'currency_id', 'amount', 'currency' => [
                'id',
                'code'
            ]]);
    }

    /**
     * @group api
     * @group accounts
     */
    public function testStore()
    {
        $this->dontSeeInDatabase('accounts', [
            'description' => 'Create account',
            'currency_id' => 1
        ]);

        $this->json('POST', '/api/accounts', ['description' => 'Create account', 'currency_id' => 1])
            ->seeJsonStructure(['id', 'description', 'currency_id', 'amount', 'currency' => [
                'id',
                'code'
            ]]);

        $this->seeInDatabase('accounts', [
            'description' => 'Create account',
            'currency_id' => 1
        ]);
    }

    /**
     * @group api
     * @group accounts
     */
    public function testUpdate()
    {
        $this->seeInDatabase('accounts', [
            'id' => 1,
            'currency_id' => 1
        ]);

        $this->json('PUT', '/api/accounts/1', ['description' => 'Update account', 'currency_id' => 2])
            ->seeJsonStructure(['id', 'description', 'currency_id', 'amount', 'currency' => [
                'id',
                'code'
            ]]);

        $this->seeInDatabase('accounts', [
            'id' => 1,
            'description' => 'Update account',
            'currency_id' => 2
        ]);
    }

    /**
     * @group api
     * @group accounts
     */
    public function testDestroy()
    {
        $this->seeInDatabase('accounts', [
            'id' => 1
        ]);

        $this->json('DELETE', 'api/accounts/1')
            ->seeJsonEquals([
                'data' => null
            ]);

        $this->dontSeeInDatabase('accounts', [
            'id' => 1
        ]);
    }
}
