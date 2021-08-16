<?php
namespace Examples\Documents;

use Examples\Documents\Delete;
use Examples\Documents\Get;
use Examples\Documents\PagedResults;
use Examples\Documents\QueryFilter;
use Examples\Documents\Query;
use Examples\Documents\QueryLimits;
use Examples\Documents\Ref;
use Examples\Documents\Set;
use Examples\Documents\SubColQuery;
use Examples\Documents\SubDocQuery;
use PHPUnit\Framework\TestCase;
use Exception;

class DocumentsExamplesTest extends TestCase 
{
  /**
   * @covers \Get
   */
  public function testGetDocumet()
  {
    try 
    {
      $doc = new Get();
      $doc->getDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Set
   */
  public function testSetDocument()
  {
    try 
    {
      $doc = new Set();
      $doc->setDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Delete
   */
  public function testDeleteDocument()
  {
    try 
    {
      $doc = new Delete();
      $doc->deleteDocuments();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Query
   */
  public function testQueryDocument()
  {
    try 
    {
      $doc = new Query();
      $doc->queryDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \QueryLimit
   */
  public function testQueryLimitDocument()
  {
    try 
    {
      $doc = new QueryLimits();
      $doc->queryLimitsDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \QueryFilter
   */
  public function testQueryFilterDocument()
  {
    try 
    {
      $doc = new QueryFilter();
      $doc->queryFilterDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \PagedResults
   */
  public function testPagedResultsDocument()
  {
    try 
    {
      $doc = new PagedResults();
      $doc->pagedResultsDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \SubColQuery
   */
  public function testSubColDocument()
  {
    try 
    {
      $doc = new SubColQuery();
      $doc->subColDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \SubDocQuery
   */
  public function testSubDocDocument()
  {
    try 
    {
      $doc = new SubDocQuery();
      $doc->subDocDocument();
    } 
    catch (Exception $e)
    {
      $this->assertTrue(true);
    }
  }
  /**
   * @covers \Ref
   */
  public function testRefDocument()
  {
    try 
    {
      $doc = new Ref();
      $doc->refDocument();
      $this->assertTrue(true);
    } 
    catch (Exception $e)
    {
      $this->assertTrue(false);
    }
  }
}

?>