<?php

declare(strict_types=1);

namespace OpenTelemetry\Tests\Unit\SDK\Trace\SpanExporter;

use ArrayObject;
use Generator;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter
 */
class InMemoryExporterTest extends TestCase
{
    /**
     * @dataProvider provideSpans
     */
    public function test_export(iterable $spans): void
    {
        $instance = new InMemoryExporter();

        $instance->export($spans);

        $this->assertSame(
            $spans,
            $instance->getSpans()
        );
    }

    public function test_from_connection_string(): void
    {
        $this->assertInstanceOf(
            InMemoryExporter::class,
            InMemoryExporter::fromConnectionString()
        );
    }

    public function test_get_storage(): void
    {
        $storage = new ArrayObject();

        $this->assertSame(
            $storage,
            (new InMemoryExporter($storage))->getStorage()
        );
    }

    public function test_get_spans(): void
    {
        $storage = new ArrayObject();

        $this->assertSame(
            (array) $storage,
            (new InMemoryExporter($storage))->getSpans()
        );
    }

    public function provideSpans(): Generator
    {
        $spans = [];

        for ($x = 0; $x < 3; $x++) {
            $spans[] = $this->createMock(SpanDataInterface::class);

            yield $x => [$spans];
        }
    }
}
