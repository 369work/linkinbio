/**
 * LinkInBio - Dark mode toggle
 *
 * Loaded in the head so the saved choice is applied before the page paints;
 * otherwise a dark-mode visitor would see a light flash on every load.
 * The OS colour-scheme setting is deliberately ignored: only an explicit
 * choice made with the toggle is applied, so it never fights a style variation.
 *
 * @package linkinbio
 * @since 1.2.0
 */

( function () {
	'use strict';

	var STORAGE_KEY = 'linkinbio-theme';
	var html = document.documentElement;

	/**
	 * Read the saved choice.
	 *
	 * @return {string} 'dark', 'light' or ''.
	 */
	function readTheme() {
		try {
			return window.localStorage.getItem( STORAGE_KEY ) || '';
		} catch ( error ) {
			return '';
		}
	}

	/**
	 * Save the choice. Storage can be blocked (private mode, site data off).
	 *
	 * @param {boolean} isDark Whether dark mode is on.
	 */
	function saveTheme( isDark ) {
		try {
			window.localStorage.setItem( STORAGE_KEY, isDark ? 'dark' : 'light' );
		} catch ( error ) {
			// Nothing to do: the choice simply lasts for this page view.
		}
	}

	/**
	 * Sync the toggle button's pressed state and label.
	 *
	 * @param {HTMLElement|null} toggle The toggle button.
	 * @param {boolean}          isDark Whether dark mode is on.
	 */
	function syncToggle( toggle, isDark ) {
		if ( ! toggle ) {
			return;
		}

		toggle.setAttribute( 'aria-pressed', String( isDark ) );
		toggle.setAttribute(
			'aria-label',
			isDark ? toggle.dataset.labelLight || 'Switch to light mode' : toggle.dataset.labelDark || 'Switch to dark mode'
		);
	}

	html.classList.toggle( 'is-dark', 'dark' === readTheme() );

	document.addEventListener( 'DOMContentLoaded', function () {
		var toggle = document.querySelector( '.lib-dark-toggle' );

		syncToggle( toggle, html.classList.contains( 'is-dark' ) );

		if ( ! toggle ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var isDark = ! html.classList.contains( 'is-dark' );

			html.classList.toggle( 'is-dark', isDark );
			syncToggle( toggle, isDark );
			saveTheme( isDark );
		} );
	} );
} )();
