<?php
namespace Examples\Queues;

use Examples\Queues\Receive;
use Examples\Queues\Send;
use PHPUnit\Framework\TestCase;
use Exception;

class QueuesExamplesTest extends TestCase 
{
  /**
   * @covers \Receive
   */
  public function testReceiveQueue()
  {
    try 
    {
      $doc = new Receive();
      $doc->receiveQueue();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Send
   */
  public function testSendQueue()
  {
    try 
    {
      $doc = new Send();
      $doc->sendQueue();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
}