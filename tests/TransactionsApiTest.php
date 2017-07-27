<?php

class TransactionsApiTest extends TestCase
{
    /**
     * @group api
     * @group transactions
     */
    public function testIndex()
    {
        $this->get('api/accounts/1/transactions')
            ->seeJsonStructure([
                '*' => ['id', 'description', 'amount', 'account_id', 'created_at']
            ]);
    }

    /**
     * @group api
     * @group transactions
     */
    public function testShow()
    {
        $this->get('api/accounts/1/transactions/1')
            ->seeJsonStructure(['id', 'description', 'amount', 'account_id', 'created_at']);
    }

    /**
     * @group api
     * @group transactions
     */
    public function testStore()
    {
        $transactionData = [
            'description' => 'Create transaction',
            'amount' => 123.89,
            'account_id' => 1
        ];

        $this->dontSeeInDatabase('transactions', $transactionData);

        $this->json('POST', 'api/accounts/1/transactions', ['description' => 'Create transaction', 'amount' => 123.89])
            ->seeJson($transactionData);

        $this->seeInDatabase('transactions', $transactionData);
    }

    /**
     * @group api
     * @group transactions
     */
    public function testUpdate()
    {
        $updatedTransactionData = [
            'description' => 'Update transaction',
            'account_id' => 2,
            'amount' => 123.89
        ];

        $this->seeInDatabase('transactions', [
            'id' => 1,
            'account_id' => 1
        ]);

        $this->json('PUT', '/api/accounts/1/transactions/1', $updatedTransactionData)
            ->seeJson($updatedTransactionData);

        $this->seeInDatabase('transactions', $updatedTransactionData);
    }

    /**
     * @group api
     * @group transactions
     */
    public function testDestroy()
    {
        $this->seeInDatabase('transactions', [
            'id' => 1
        ]);

        $this->json('DELETE', 'api/accounts/1/transactions/1')
            ->seeJsonEquals([
                'data' => null
            ]);

        $this->dontSeeInDatabase('transactions', [
            'id' => 1
        ]);
    }
}
