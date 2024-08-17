<?php

declare(strict_types=1);

class BringBackTheRssButtonExtension extends Minz_Extension
{

	public function init()
	{
		$this->registerController('rss');

		Minz_View::appendScript($this->getFileUrl('script.js', 'js'));

		$this->registerHook(
			'nav_menu',
			array($this, 'addRssButton')
		);
	}

	public function addRssButton()
	{
		$icon_url = $this->getFileUrl('rss.svg', 'svg');
		return '<button class="btn" id="bringBackRssButton" title="Create RSS feed">
			<img class="icon" src="' . $icon_url . '" loading="lazy" alt="rss">
		</button>';
	}
}
