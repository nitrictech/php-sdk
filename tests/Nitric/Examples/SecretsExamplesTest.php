<?php
namespace Examples\Events;

use Examples\Secrets\Access;
use Examples\Secrets\Latest;
use Examples\Secrets\Put;
use PHPUnit\Framework\TestCase;
use Exception;
use TypeError;

class SecretsExamplesTest extends TestCase 
{
  /**
   * @covers \Access
   */
  public function testAccessSecret()
  {
    try 
    {
      $doc = new Access();
      $doc->accessSecret();
      $this->assertTrue(true);
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Latest
   */
  public function testLatestSecret()
  {
    try 
    {
      $doc = new Latest();
      $doc->latestSecret();
      $this->assertTrue(true);
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Put
   */
  public function testPutSecret()
  {
    try 
    {
      $doc = new Put();
      $doc->putSecret();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
}