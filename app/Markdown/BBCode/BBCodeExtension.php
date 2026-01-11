<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Markdown\BBCode;

use App\Markdown\BBCode\Parsers\Inline\GalleryItemParser;
use App\Markdown\BBCode\Parsers\Inline\GalleryParser;
use App\Markdown\BBCode\Parsers\Inline\GalleryCustomParser;
use App\Markdown\BBCode\Parsers\Inline\ImageParser;
use App\Markdown\BBCode\Parsers\Inline\UpdateParser;
use App\Markdown\BBCode\Parsers\Inline\YouTubeParser;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\Embed\Embed;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Stringable;

class BBCodeExtension implements ExtensionInterface, NodeRendererInterface
{

	public function register(EnvironmentBuilderInterface $environment): void
	{
		$environment->addInlineParser(new GalleryParser(), 250);
		$environment->addInlineParser(new GalleryCustomParser(), 250);
		$environment->addInlineParser(new GalleryItemParser(), 250);
		$environment->addInlineParser(new ImageParser(), 250);
		$environment->addInlineParser(new UpdateParser(), 250);
		$environment->addInlineParser(new YouTubeParser(), 250);

		$environment->addRenderer(Text::class, $this, 100);
		$environment->addRenderer(Embed::class, $this, 100);
	}

	public function render(Node $node, ChildNodeRendererInterface $childRenderer): Stringable|string|null
	{
		if ($node instanceof Embed) {
			return new HtmlElement('iframe', ['class' => 'youtube', 'src' => $node->getUrl(), 'allowfullscreen' => 'true']);
		}

		return null;
	}
}