<?php

declare(strict_types=1);

namespace Tests\integration;

use App\Service\CardDeckService;

class CardDeckServiceTest extends TestCase
{
    public function testSuits()
    {
        $cardDeck = CardDeckService::getShuffledDeck(CardDeckService::getDeck());

        $this->assertStringContainsString('S', join("", $cardDeck));
        $this->assertStringContainsString('H', join("", $cardDeck));
        $this->assertStringContainsString('D', join("", $cardDeck));
        $this->assertStringContainsString('C', join("", $cardDeck));
    }

    public function testCardArray()
    {
        $cardDeck = CardDeckService::getDeck();

        $this->assertIsArray($cardDeck);
        $this->assertContainsOnly('string', $cardDeck);
    }

    public function testGetDeck()
    {
        $cardDeck = CardDeckService::getDeck();

        $this->assertCount(52, $cardDeck);
        $this->assertEquals('4S', $cardDeck[2]);
        $this->assertEquals('2H', $cardDeck[13]);
    }

    public function testGetShuffledDeck()
    {
        $cardDeck = CardDeckService::getShuffledDeck(CardDeckService::getDeck());

        $this->assertCount(52, $cardDeck);
        $this->assertFalse('4S' === $cardDeck[2]);
        $this->assertFalse('2H' === $cardDeck[13]);
    }

}