document.addEventListener('DOMContentLoaded', function () {
	if (typeof wp !== 'undefined' && wp.blocks) {
		const { registerBlockType } = wp.blocks
		const { TextControl } = wp.components
		const { useBlockProps } = wp.blockEditor

		registerBlockType('custom-feedback/feedback-list', {
			title: 'Feedback List',
			description: 'A custom feedback list block',
			category: 'widgets',
			icon: 'list-view',

			edit: function ({ attributes, setAttributes }) {
				const blockProps = useBlockProps()
				return wp.element.createElement(
					'div',
					blockProps,
					wp.element.createElement(TextControl, {
						label: 'List of Feedback',
						value: attributes.listTitle,
						onChange: function (value) {
							setAttributes({ listTitle: value })
						},
					})
				)
			},

			save: function ({ attributes }) {
				return wp.element.createElement('div', null, wp.element.createElement('h3', null, attributes.listTitle))
			},

			attributes: {
				listTitle: {
					type: 'string',
					default: 'User Feedback',
				},
			},
		})
	}
})
