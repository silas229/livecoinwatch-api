<?php
declare(strict_types=1);

namespace LiveCoinWatchApi\Tests\Unit;

use LiveCoinWatchApi\Client;
use LiveCoinWatchApi\Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsInt;

final class ApiStatusTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client($_ENV[ 'API_KEY' ]);
    }

    public function test_status(): void
    {
        $response = $this->client->status();

        assertEquals(200, $response->getStatusCode());
    }

    public function test_credits(): void
    {
        $response = $this->client->credits();

        $body = json_decode((string)$response->getBody(), true);

        assertEquals(200, $response->getStatusCode());

        assertIsInt($body->dailyCreditsLimit);
        assertEquals($_ENV['DAILY_CREDITS_LIMIT'], $body->dailyCreditsLimit);

        assertIsInt($body->dailyCreditsRemaining);
        assert($body->dailyCreditsRemaining <= $body->dailyCreditsLimit, 'Remaining credits are less than or equal to the limit');
    }
}

