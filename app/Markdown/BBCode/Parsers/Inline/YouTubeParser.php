<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Markdown\BBCode\Parsers\Inline;

use League\CommonMark\Extension\Embed\Embed;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class YouTubeParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[youtube=(.*?)]');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		$cursor = $inlineContext->getCursor();
		$cursor->advanceBy($inlineContext->getFullMatchLength());

		$identifier = last($inlineContext->getSubMatches());

		$element= new Embed('https://youtube.com/embed/' . $identifier);
		$inlineContext->getContainer()->appendChild($element);

		return true;
	}
}