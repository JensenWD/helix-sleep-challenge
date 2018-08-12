<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    public function testProductIsRetrieved()
    {
        $product = factory('App\Product')->create()->toArray();
        $user = factory('App\User')->create();

        $this->get('/products/' . $product['id'], ['api-token' => $user->api_token])->seeJson($product);
    }

    public function testProductIsAdded()
    {
        $product = factory('App\Product')->make()->toArray();
        $user = factory('App\User')->create();

        $response = $this->post('/products', $product, ['api-token' => $user->api_token]);

        $this->assertResponseStatus(201);
    }

    public function testProductIsUpdated()
    {
        $product = factory('App\Product')->create()->toArray();
        $product['price'] = 50;
        $user = factory('App\User')->create();

        $response = $this->put('/products/' . $product['id'], $product, ['api-token' => $user->api_token])->seeJson([
            'price' => 50
        ]);

        $this->assertResponseStatus(200);
    }

    public function testImageIsUpdatedOnProduct()
    {
        $product = factory('App\Product')->create()->toArray();
        $user = factory('App\User')->create();
        $this->post('/products/' . $product['id'] . '/image',
            ['img_path' => 'https://updated.com'], ['api-token' => $user->api_token]);

        $this->assertResponseStatus(200);
    }

    public function testProductIsDeleted()
    {
        $product = factory('App\Product')->create()->toArray();
        $user = factory('App\User')->create();

        $response = $this->delete('/products/' . $product['id'],[], ['api-token' => $user->api_token]);

        $this->assertResponseStatus(200);
    }

    public function testProductsAreRetrieved()
    {
        factory('App\Product', 10)->create();
        $user = factory('App\User')->create();
        $this->get('/products/', ['api-token' => $user->api_token]);

        $this->assertResponseStatus(200);
    }
}
