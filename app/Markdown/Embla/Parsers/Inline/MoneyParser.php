<?php

namespace App\Markdown\Embla\Parsers\Inline;

use Illuminate\Support\Number;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class MoneyParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[([A-Z]{3}):?([0-9]{1})?\]\((.*?)\)');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		$cursor = $inlineContext->getCursor();
		$cursor->advanceBy($inlineContext->getFullMatchLength());

		[$type, $precision, $value] = $inlineContext->getSubMatches();

		if (preg_match('/^([A-Z]{3})$/', $type, $matches) === 1) {
			$formatted = Number::currency((float) $value, $type, precision: (int) $precision ?? 0);
			$inlineContext->getContainer()->appendChild(new Text($formatted));
			return true;
		}

		return false;
	}
}