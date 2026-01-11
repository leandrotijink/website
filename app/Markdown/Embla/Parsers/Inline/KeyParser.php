<?php

namespace App\Markdown\Embla\Parsers\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class KeyParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[key\]\((.*?)\)');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		$keys = explode(' ', last($inlineContext->getMatches()));

		foreach ($keys as $key) {
			$element = new HtmlInline(sprintf('<kbd>%s</kbd>', $key));
			$inlineContext->getContainer()->appendChild($element);
		}

		return true;
	}
}