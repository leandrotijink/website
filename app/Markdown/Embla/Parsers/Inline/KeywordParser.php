<?php

namespace App\Markdown\Embla\Parsers\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class KeywordParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('#([A-Za-z0-9]{1,50}(?!\w))');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		$cursor = $inlineContext->getCursor();
		$previousChar = $cursor->peek(-1);
		if ($previousChar !== null && $previousChar !== ' ') {
			return false;
		}

		$cursor->advanceBy($inlineContext->getFullMatchLength());

		[$keyword] = $inlineContext->getSubMatches();

		$url = route('public.archive.keyword', ['keyword' => $keyword]);
		$inlineContext->getContainer()->appendChild(new Link($url, $keyword));

		return true;
	}
}