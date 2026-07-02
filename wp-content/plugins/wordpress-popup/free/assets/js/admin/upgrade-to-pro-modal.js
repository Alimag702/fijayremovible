( function( $ ) {
	'use strict';

	Optin.upgradeToProModal = Hustle.View.extend( {
		el: '.sui-wrap-hustle',
		logShown: false,
		moduleType: '',
		previewView: null,

		initialize() {
			// Display "Upgrade modal".
			if ( 'true' === utils.getUrlParam( 'requires-pro' ) ) {
				const self = this;
				setTimeout( () => self.openUpgradeModal(), 100 );
			}
		},
		openUpgradeModal( e ) {
			let focusOnClose = this.$( '#hustle-create-new-module' )[ 0 ];

			if ( e ) {
				e.preventDefault();
				e.stopPropagation();
				focusOnClose = e.currentTarget;
			}

			$( '.sui-button-onload' ).removeClass( 'sui-button-onload' );

			if ( ! $( '#hustle-modal--upgrade-to-pro' ).length ) {
				return;
			}

			SUI.openModal(
				'hustle-modal--upgrade-to-pro',
				focusOnClose,
				'hustle-button--upgrade-to-pro',
				true
			);
		},
	} );

	new Optin.upgradeToProModal();
}( jQuery ) );
