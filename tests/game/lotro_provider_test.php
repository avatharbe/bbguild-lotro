<?php
/**
 * @package bbGuild LOTRO Extension
 * @copyright (c) 2026 avathar.be
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace avathar\bbguildlotro\tests\game;

use PHPUnit\Framework\TestCase;
use avathar\bbguildlotro\game\lotro_provider;
use avathar\bbguildlotro\game\lotro_installer;

class lotro_provider_test extends TestCase
{
	/** @var lotro_provider */
	private $provider;

	protected function setUp(): void
	{
		parent::setUp();

		$installer = $this->getMockBuilder(lotro_installer::class)
			->disableOriginalConstructor()
			->getMock();

		$ext_manager = $this->getMockBuilder(\phpbb\extension\manager::class)
			->disableOriginalConstructor()
			->getMock();
		$ext_manager->method('get_extension_path')
			->willReturn('ext/avathar/bbguildlotro/');

		$this->provider = new lotro_provider($installer, $ext_manager);
	}

	public function test_game_id(): void
	{
		$this->assertSame('lotro', $this->provider->get_game_id());
	}

	public function test_game_name(): void
	{
		$this->assertSame('Lord of the Rings Online', $this->provider->get_game_name());
	}

	public function test_installer(): void
	{
		$this->assertInstanceOf(lotro_installer::class, $this->provider->get_installer());
	}

	public function test_has_no_api(): void
	{
		$this->assertFalse($this->provider->has_api());
		$this->assertNull($this->provider->get_api());
	}

	public function test_images_path(): void
	{
		$this->assertStringContainsString('bbguildlotro', $this->provider->get_images_path());
		$this->assertStringEndsWith('images/', $this->provider->get_images_path());
	}

	public function test_regions(): void
	{
		$regions = $this->provider->get_regions();
		$this->assertCount(2, $regions);
		$this->assertSame(array(
			'us' => 'US',
			'eu' => 'EU',
		), $regions);
	}

	public function test_api_locales_empty(): void
	{
		$this->assertEmpty($this->provider->get_api_locales());
	}

	public function test_armor_types(): void
	{
		$armor = $this->provider->get_armor_types();
		$this->assertCount(3, $armor);
		$this->assertSame(array(
			'CLOTH' => 'Cloth',
			'MAIL' => 'Mail',
			'PLATE' => 'Plate',
		), $armor);
	}
}
