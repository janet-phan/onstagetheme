/**
 * Editor preview for Show listing dates/venue (Query Loop context).
 */
( function ( wp ) {
	if ( ! wp || ! wp.blocks || ! wp.element ) {
		return;
	}

	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { useBlockProps } = wp.blockEditor || {};
	const ServerSideRender = wp.serverSideRender && wp.serverSideRender.default
		? wp.serverSideRender.default
		: wp.serverSideRender;

	registerBlockType( 'onstage/show-listing-meta', {
		apiVersion: 3,
		title: 'Show dates and venue',
		icon: 'calendar-alt',
		category: 'theme',
		description: 'Calendar date lines and venue from the Show post.',
		supports: {
			html: false,
			reusable: false,
		},
		usesContext: [ 'postId', 'postType' ],
		edit: function ( props ) {
			const blockProps = useBlockProps
				? useBlockProps( { className: 'onstage-show-listing-meta-editor' } )
				: { className: 'onstage-show-listing-meta-editor' };
			const postId = props.context && props.context.postId;

			if ( ! postId || ! ServerSideRender ) {
				return el(
					'div',
					blockProps,
					el(
						'p',
						{ className: 'onstage-show-listing-placeholder' },
						'Show dates and venue appear here inside a Query Loop.'
					)
				);
			}

			return el(
				'div',
				blockProps,
				el( ServerSideRender, {
					block: 'onstage/show-listing-meta',
					urlQueryArgs: { post_id: postId },
				} )
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp );
