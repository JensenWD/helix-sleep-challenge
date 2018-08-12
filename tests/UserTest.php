<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testRetrieveAUsersProducts()
    {
        $user = factory('App\User')->create();

        $user->each(function ($u) {
            $u->products()->save(factory('App\Product')->make());
        });

        $this->get('/user/' . $user['id'] . '/products', ['api-token' => $user->api_token]);
        $this->assertResponseStatus(200);
    }

    public function testAttachProductToAUser()
    {
        $product = factory('App\Product')->create()->toArray();
        $user = factory('App\User')->create();

        $this->post('/user/' . $user->id . '/product/' . $product['id'],[], ['api-token' => $user->api_token]);

        $this->assertResponseStatus(200);
    }

    public function testDetachProductFromAUser()
    {
        $product = factory('App\Product')->create()->toArray();
        $user = factory('App\User')->create();

        \App\ProductUser::create(
            ['user_id' => $user->id, 'product_id' => $product['id']]
        );

        $this->delete('/user/' . $user->id . '/product/' . $product['id'], [], ['api-token' => $user->api_token]);

        $this->assertResponseStatus(200);
    }
}
