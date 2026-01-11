<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Markdown\Embla;

use App\Markdown\Embla\Parsers\Inline\HighlightParser;
use App\Markdown\Embla\Parsers\Inline\KeyParser;
use App\Markdown\Embla\Parsers\Inline\KeywordParser;
use App\Markdown\Embla\Parsers\Inline\MoneyParser;
use Blade;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Event\DocumentRenderedEvent;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Stringable;

class EmblaExtension implements ExtensionInterface, NodeRendererInterface
{

	public static bool $allowBladeRendering = false;

	public function register(EnvironmentBuilderInterface $environment): void
	{
		$environment->addInlineParser(new MoneyParser(), 260);
		$environment->addInlineParser(new HighlightParser(), 250);
		$environment->addInlineParser(new KeyParser(), 250);
		$environment->addInlineParser(new KeywordParser(), 250);

		$environment->addRenderer(FencedCode::class, $this, 100);

		$environment->addEventListener(DocumentRenderedEvent::class, [$this, 'onDocumentRenderedEvent']);
	}

	public function render(Node $node, ChildNodeRendererInterface $childRenderer): Stringable|string|null
	{
		if ($node instanceof FencedCode && static::$allowBladeRendering) {
			$info = $node->getInfoWords();
			if (in_array('blade', $info)) {
				return Blade::render($node->getLiteral());
			}
		}

		return null;
	}

	// -----------------

	public function onDocumentRenderedEvent(): void
	{
		static::$allowBladeRendering = false;
	}
}