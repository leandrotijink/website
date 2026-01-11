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

class UpdateParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[update=([^,\]]{1,}),?(.*?)?\](.*?)\[\/update\]');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		[$caption, $accent, $content] = $inlineContext->getSubMatches();

		$cursor = $inlineContext->getCursor();
		$cursor->advanceBy($inlineContext->getFullMatchLength());

		$element = new HtmlInline(sprintf('<span caption="%s" class="context %s">%s</span>', $caption, $accent ?? 'auto', $content));
		$inlineContext->getContainer()->appendChild($element);

		return true;
	}
}