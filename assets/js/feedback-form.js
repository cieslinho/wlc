document.addEventListener('DOMContentLoaded', function () {
	if (typeof wp !== 'undefined' && wp.blocks) {
		const { registerBlockType } = wp.blocks
		const { TextControl, TextareaControl } = wp.components
		const { useBlockProps } = wp.blockEditor

		registerBlockType('custom-feedback/feedback-form', {
			title: 'Feedback Form',
			description: 'A custom feedback form block',
			category: 'widgets',
			icon: 'forms',

			edit: function ({ attributes, setAttributes }) {
				const blockProps = useBlockProps()

				return wp.element.createElement(
					'div',
					blockProps,
					wp.element.createElement(
						'form',
						{
							id: 'feedback-form',
							onsubmit: function (e) {
								e.preventDefault()
								saveFeedbackForm(attributes)
							},
						},
						wp.element.createElement(TextControl, {
							label: 'First Name',
							value: attributes.firstName,
							onChange: function (value) {
								setAttributes({ firstName: value })
							},
						}),
						wp.element.createElement(TextControl, {
							label: 'Last Name',
							value: attributes.lastName,
							onChange: function (value) {
								setAttributes({ lastName: value })
							},
						}),
						wp.element.createElement(TextControl, {
							label: 'Email',
							value: attributes.email,
							onChange: function (value) {
								setAttributes({ email: value })
							},
						}),
						wp.element.createElement(TextareaControl, {
							label: 'Message',
							value: attributes.message,
							onChange: function (value) {
								setAttributes({ message: value })
							},
						}),
						wp.element.createElement(
							'button',
							{
								type: 'submit',
							},
							'Submit'
						)
					)
				)
			},

			save: function ({ attributes }) {
				return wp.element.createElement(
					'div',
					null,
					wp.element.createElement('h3', null, 'Feedback Form'),
					wp.element.createElement('p', null, 'Name: ' + attributes.firstName + ' ' + attributes.lastName),
					wp.element.createElement('p', null, 'Email: ' + attributes.email),
					wp.element.createElement('p', null, 'Message: ' + attributes.message)
				)
			},

			attributes: {
				firstName: {
					type: 'string',
					default: '',
				},
				lastName: {
					type: 'string',
					default: '',
				},
				email: {
					type: 'string',
					default: '',
				},
				message: {
					type: 'string',
					default: '',
				},
			},
		})
	}
})
