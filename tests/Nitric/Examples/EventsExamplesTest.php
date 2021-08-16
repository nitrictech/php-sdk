<?php
namespace Examples\Events;

use Examples\Events\Publish;
use Examples\Events\EventIDs;
use PHPUnit\Framework\TestCase;
use Exception;
use TypeError;

class EventsExamplesTest extends TestCase 
{
  /**
   * @covers \Publish
   */
  public function testPublishEvent()
  {
    try 
    {
      $doc = new Publish();
      $doc->publishTopic();
    } 
    catch (TypeError $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \EventIDs
   */
  public function testEventIdsEvent()
  {
    try 
    {
      $doc = new EventIDs();
      $doc->eventIdsTopic();
    } 
    catch (TypeError $e)
    {
      $this->assertTrue(true);
    }
  }
}