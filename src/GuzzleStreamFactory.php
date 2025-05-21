<?php declare(strict_types=1);

namespace AlanVdb\Http\Factory;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\StreamFactoryInterface;
use AlanVdb\Http\Exception\InvalidResourceProvided;

class GuzzleStreamFactory implements StreamFactoryInterface
{
    public function createStream(string $content = ''): StreamInterface
    {
        $stream = new Stream(fopen('php://temp', 'r+'));
        $stream->write($content);
        $stream->rewind();
        return $stream;
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        $stream = new Stream(fopen($filename, $mode));
        $stream->rewind();
        return $stream;
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        if (!is_resource($resource)) {
            throw new InvalidResourceProvided('Resource must be a valid resource');
        }
        $stream = new Stream($resource);
        $stream->rewind();
        return $stream;
    }
}