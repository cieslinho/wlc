document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('feedback-form') // feedback form
	const feedbackList = document.getElementById('feedback-list') // feedback list
	const paginationContainer = document.querySelector('.feedback__pagination') // pagination feedback
	const feedbackDetails = document.getElementById('feedback-details') // container for feedback details
	const feedbackDetailsContent = document.getElementById('feedback-details-content') // content feedback details

	// load feedback
	function loadFeedbacks(page) {
		const formData = new FormData()
		formData.append('action', 'load_feedbacks')
		formData.append('page', page)
		formData.append('security', feedbackFormData.nonce)

		fetch(feedbackFormData.ajaxurl, {
			method: 'POST',
			body: formData,
		})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					feedbackList.innerHTML = data.data.feedbacks

					const pagination = data.data.pagination
					let paginationHTML = ''

					if (pagination.has_prev) {
						paginationHTML += `<button class="feedback__prev" data-page="${
							pagination.current_page - 1
						}">Previous</button>`
					}

					if (pagination.has_next) {
						paginationHTML += `<button class="feedback__next" data-page="${pagination.current_page + 1}">Next</button>`
					}

					paginationContainer.innerHTML = paginationHTML

					addPaginationListeners()

					addFeedbackDetailsListeners()
				} else {
					console.error('Error loading feedbacks:', data.data.message || 'Unknown error')
					feedbackList.innerHTML = '<p>Error loading feedbacks.</p>'
					paginationContainer.innerHTML = ''
				}
			})
			.catch(error => console.error('Fetch error:', error))
	}

	function addPaginationListeners() {
		const paginationButtons = paginationContainer.querySelectorAll('.feedback__prev, .feedback__next')

		paginationButtons.forEach(button => {
			button.addEventListener('click', function (e) {
				e.preventDefault()
				const newPage = parseInt(this.getAttribute('data-page'), 10)
				loadFeedbacks(newPage)
			})
		})
	}

	function addFeedbackDetailsListeners() {
		const viewFeedbackButtons = feedbackList.querySelectorAll('.view-feedback')

		viewFeedbackButtons.forEach(button => {
			button.addEventListener('click', function (e) {
				const feedbackId = button.getAttribute('data-id')
				loadFeedbackDetails(feedbackId)
			})
		})
	}

	function loadFeedbackDetails(feedbackId) {
		const formData = new FormData()
		formData.append('action', 'load_feedback_details')
		formData.append('feedback_id', feedbackId)
		formData.append('security', feedbackFormData.nonce)

		fetch(feedbackFormData.ajaxurl, {
			method: 'POST',
			body: formData,
		})
			.then(response => response.json())
			.then(data => {
				console.log('Server response:', data)

				if (data.success) {
					console.log('Received data:', data.data)
					feedbackDetails.style.display = 'flex'
					feedbackDetailsContent.innerHTML = `
                        <p class="feedback__result">${feedbackFormData.labels.first_name}: <span>${
						data.data.first_name ? data.data.first_name : 'No data'
					}</span></p>
                        <p class="feedback__result">${feedbackFormData.labels.last_name}: <span>${
						data.data.last_name ? data.data.last_name : 'No data'
					}</span></p>
                        <p class="feedback__result">${feedbackFormData.labels.email}: <a href="mailto:${
						data.data.email || ''
					}">${data.data.email ? data.data.email : 'No data'}</a></p>
                        <p class="feedback__result">${feedbackFormData.labels.subject}: <span>${
						data.data.subject ? data.data.subject : 'No data'
					}</span></p>
                        <p class="feedback__result">${feedbackFormData.labels.message}: <span>${
						data.data.message ? data.data.message : 'No data'
					}</span></p>
                    `
				} else {
					console.error('Error loading feedback details:', data.data ? data.data.message : 'Unknown error')
					feedbackDetails.style.display = 'none'
					feedbackDetailsContent.innerHTML = ''
				}
			})
			.catch(error => {
				console.error('Fetch error:', error)
				feedbackDetails.style.display = 'none'
				feedbackDetailsContent.innerHTML = ''
			})
	}

	if (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault()

			const formData = new FormData(form)
			formData.append('action', 'submit_feedback')
			formData.append('security', feedbackFormData.nonce)

			fetch(feedbackFormData.ajaxurl, {
				method: 'POST',
				body: formData,
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						alert(data.data.message)
						form.reset()
						loadFeedbacks(1)
					} else {
						alert(data.data.message || 'Error submitting feedback')
					}
				})
				.catch(error => console.error('Submit error:', error))
		})
	}

	// init
	loadFeedbacks(1)
})
