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

class GalleryItemParser implements InlineParserInterface
{
	public function getMatchDefinition(): InlineParserMatch
	{
		return InlineParserMatch::regex('\[item=([0-9]{4}),([a-z0-9-._]*?)](.*?)\[\/item]');
	}

	public function parse(InlineParserContext $inlineContext): bool
	{
		[$directory, $filename, $caption] = $inlineContext->getSubMatches();

		$cursor = $inlineContext->getCursor();
		$cursor->advanceBy($inlineContext->getFullMatchLength());

		$image_url = Storage::url('/blog/' . $directory . '/' . $filename);
		$thumbnail_url = Storage::url('/blog/' . $directory . '/thumbs/' . $filename);

		$element = new HtmlInline(sprintf('<a href="%s" class="spotlight image print:rounded-none"><img src="%s" alt="%s" class="aspect-5/3" decoding="async" loading="lazy"></a>', $image_url, $thumbnail_url, $caption));
		$inlineContext->getContainer()->appendChild($element);

		return true;
	}
}