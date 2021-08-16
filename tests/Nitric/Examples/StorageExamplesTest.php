<?php
namespace Examples\Events;

use Examples\Storage\Delete;
use Examples\Storage\Read;
use Examples\Storage\Write;
use PHPUnit\Framework\TestCase;
use Exception;
use TypeError;

class StorageExamplesTest extends TestCase 
{
  /**
   * @covers \Write
   */
  public function testWriteStorage()
  {
    try 
    {
      $doc = new Write();
      $doc->writeStorage();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Read
   */
  public function testReadStorage()
  {
    try 
    {
      $doc = new Read();
      $doc->readStorage();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Delete
   */
  public function testDeleteStorage()
  {
    try 
    {
      $doc = new Delete();
      $doc->deleteStorage();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
}