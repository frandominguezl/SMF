<?php

/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines https://www.simplemachines.org
 * @copyright 2024 Simple Machines and individual contributors
 * @license https://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 3.0 Alpha 1
 */

declare(strict_types=1);

namespace SMF\Actions\Moderation;

use SMF\Actions\ActionInterface;
use SMF\Utils;

/**
 * Ends a moderator session, requiring authentication to access the moderation
 * center again.
 */
class EndSession implements ActionInterface
{
	/****************************
	 * Internal static properties
	 ****************************/

	/**
	 * @var self
	 *
	 * An instance of this class.
	 * This is used by the load() method to prevent multiple instantiations.
	 */
	protected static self $obj;

	/****************
	 * Public methods
	 ****************/

	/**
	 * Do the job.
	 */
	public function execute(): void
	{
		// This is so easy!
		unset($_SESSION['moderate_time']);

		// Clean any moderator tokens as well.
		foreach ($_SESSION['token'] as $key => $token) {
			if (strpos($key, '-mod') !== false) {
				unset($_SESSION['token'][$key]);
			}
		}

		Utils::redirectexit();
	}

	/***********************
	 * Public static methods
	 ***********************/

	/**
	 * Static wrapper for constructor.
	 *
	 * @return object An instance of this class.
	 */
	public static function load(): object
	{
		if (!isset(self::$obj)) {
			self::$obj = new self();
		}

		return self::$obj;
	}

	/**
	 * Convenience method to load() and execute() an instance of this class.
	 */
	public static function call(): void
	{
		self::load()->execute();
	}

	/******************
	 * Internal methods
	 ******************/

	/**
	 * Constructor. Protected to force instantiation via self::load().
	 */
	protected function __construct()
	{
	}
}

?>