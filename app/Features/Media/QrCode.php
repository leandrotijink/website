<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Features\Media;

use JsonSerializable;
use Stringable;

final class QrCode implements Stringable, JsonSerializable
{
	protected array $config;

	// -----------------

	public function __construct(string $data)
	{
		$this->config = [
			'data' => mb_trim($data),
		];
	}

	public function __toString(): string
	{
		return $this->url();
	}

	// -----------------

	public function jsonSerialize(): string
	{
		return $this->__toString();
	}

	// -----------------

	public static function from(string $data): self
	{
		return new self($data);
	}

	// -----------------

	public function url(): string
	{
		return 'https://api.qrserver.com/v1/create-qr-code?' . http_build_query([
			'size' => ($this->config['height'] ?? '200') . 'x' . ($this->config['width'] ?? '200'),
			'bgcolor' => $this->config['background']?? 'FFFFFF',
			'color' => $this->config['foreground'] ?? '000000',
			'qzone' => $this->config['margin'] ?? '4',
			'format' => $this->config['format'] ?? 'svg',
			'data' => $this->config['data'],
		]);
	}
}