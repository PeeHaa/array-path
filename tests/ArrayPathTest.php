<?php declare(strict_types=1);

namespace PeeHaa\ArrayPathTest;

use PeeHaa\ArrayPath\ArrayPath;
use PeeHaa\ArrayPath\NotFoundException;
use PHPUnit\Framework\TestCase;

class ArrayPathTest extends TestCase
{
    private $source;

    public function setUp()
    {
        $this->source = [
            'key1' => [
                'key11' => [
                    'key21' => 'value21',
                ],
                'key12' => 'value11',
            ],
            'key2' => [

            ],
        ];
    }

    public function testGetThrowsOnUnknownKey()
    {
        $this->expectException(NotFoundException::class);

        (new ArrayPath())->get($this->source, 'key3');
    }

    public function testGetScalarValue()
    {
        $this->assertSame('value21', (new ArrayPath())->get($this->source, 'key1.key11.key21'));
    }

    public function testGetWithCustomDelimiter()
    {
        $this->assertSame('value21', (new ArrayPath('/'))->get($this->source, 'key1/key11/key21'));
    }

    public function testSetNewKey()
    {
        (new ArrayPath())->set($this->source, 'key3', 'value3');

        $this->assertTrue(isset($this->source['key3']));
        $this->assertSame('value3', $this->source['key3']);
    }

    public function testSetNewArray()
    {
        $source = [];

        (new ArrayPath())->set($source, 'key3', 'value3');

        $this->assertTrue(isset($source['key3']));
        $this->assertSame('value3', $source['key3']);
    }

    public function testSetNewKeyTree()
    {
        (new ArrayPath())->set($this->source, 'key1.key13.key131', 'value131');

        $this->assertTrue(isset($this->source['key1']['key13']['key131']));
        $this->assertSame('value131', $this->source['key1']['key13']['key131']);
    }

    public function testSetOverwriteExisting()
    {
        (new ArrayPath())->set($this->source, 'key1.key12', 'newvalue');

        $this->assertSame('newvalue', $this->source['key1']['key12']);
    }

    public function testExistsWhenKeyExists()
    {
        $this->assertTrue((new ArrayPath())->exists($this->source, 'key1.key12'));
    }

    public function testExistsWhenKeyDoesNotExist()
    {
        $this->assertFalse((new ArrayPath())->exists($this->source, 'key1.key99'));
    }

    public function testRemoveExistingKey()
    {
        $match = $this->source;

        unset($match['key1']['key11']);

        (new ArrayPath())->remove($this->source, 'key1.key11');

        $this->assertSame($match, $this->source);
    }

    public function testRemoveNonExistingKey()
    {
        $match = $this->source;

        (new ArrayPath())->remove($this->source, 'key1.key99');

        $this->assertSame($match, $this->source);
    }
}
