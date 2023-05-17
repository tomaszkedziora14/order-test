<?php


namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderProcessingTest extends WebTestCase
{
    public function testProcessOrders()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/orders');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $form = $crawler->selectButton('Process')->form();
        $form['channel1_orders'] = '10';
        $form['channel2_orders'] = '5';
        
        $client->submit($form);
        
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        
        $crawler = $client->followRedirect();
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Orders processed successfully', $crawler->filter('h1')->text());
    }
    
    public function testProcessOrdersWithInvalidInput()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/orders');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $form = $crawler->selectButton('Process')->form();
        $form['channel1_orders'] = '-5'; 
        $form['channel2_orders'] = 'abc'; 
        
        $client->submit($form);
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Invalid input', $client->getResponse()->getContent());
    }
}
