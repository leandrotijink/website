<?php

namespace App\Markdown\Embla\Parsers\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class HighlightParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[mark:?(.*?)\]\((.*?)\)');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		$cursor = $inlineContext->getCursor();
		$cursor->advanceBy($inlineContext->getFullMatchLength());

		[, $accent, $text] = $inlineContext->getMatches();

		$element = new HtmlInline(sprintf('<mark class="bg-%s-300">%s</mark>', $accent ?? 'auto', $text));
		$inlineContext->getContainer()->appendChild($element);

		return true;
	}
}