<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Markdown\BBCode\Parsers\Inline;

use App\Models\Exploration\Colorway;
use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class GalleryCustomParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[gallery=([A-Z0-9]{1,4})]');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		$size = last($inlineContext->getSubMatches());

		$cursor = $inlineContext->getCursor();
		$cursor->advanceBy($inlineContext->getFullMatchLength());

		$element = match ($size) {
			'6' => new HtmlInline('<span class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 spotlight-group gap-4">'),
			'4' => new HtmlInline('<span class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 spotlight-group gap-4">'),
			'3' => new HtmlInline('<span class="grid grid-cols-2 sm:grid-cols-3 spotlight-group gap-4">'),
			default => new HtmlInline('<span class="grid grid-cols-2 spotlight-group gap-4">'),
		};

		$inlineContext->getContainer()->appendChild($element);

		return true;
	}
}