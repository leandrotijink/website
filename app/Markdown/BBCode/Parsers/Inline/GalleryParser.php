<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Markdown\BBCode\Parsers\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class GalleryParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::oneOf('[gallery]', '[/gallery]', '[tbody]', '[/tbody]');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		$cursor = $inlineContext->getCursor();

		if ($inlineContext->getFullMatch() === '[gallery]') {
			$cursor->advanceBy($inlineContext->getFullMatchLength());
			$inlineContext->getContainer()->appendChild(new HtmlInline('<span class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 spotlight-group gap-4 print:grid-cols-4">'));
			return true;
		}

		if ($inlineContext->getFullMatch() === '[/gallery]') {
			$cursor->advanceBy($inlineContext->getFullMatchLength());
			$inlineContext->getContainer()->appendChild(new HtmlInline('</span>'));
			return true;
		}

		return false;
	}
}