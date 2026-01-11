<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Markdown\BBCode\Parsers\Inline;

use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class ImageParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[image=([0-9]{4}),([a-z0-9-._]*?),([a-z]{4,5})](.*?)\[\/image]');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		[$directory, $filename, $variant, $caption] = $inlineContext->getSubMatches();

		$cursor = $inlineContext->getCursor();
		$cursor->advanceBy($inlineContext->getFullMatchLength());

		$image_url = Storage::url('/blog/' . $directory . '/' . $filename);
		$thumbnail_url = Storage::url('/blog/' . $directory . ($variant === 'full' ? '/' : '/thumbs/') . $filename);

		$element = new HtmlInline(sprintf('<a href="%s" class="spotlight image %s print:rounded-none"><img src="%s" alt="%s" decoding="async" loading="lazy"></a>', $image_url, $variant, $thumbnail_url, $caption));
		$inlineContext->getContainer()->appendChild($element);

		return true;
	}
}