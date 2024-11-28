document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('feedback-form')

	form.addEventListener('submit', function (e) {
		e.preventDefault() // Zablokowanie standardowego wysyłania formularza

		const formData = new FormData(form)

		// Dodanie nonce i action do danych formularza
		formData.append('action', 'submit_feedback')
		formData.append('security', feedbackFormData.nonce) // Dodanie nonce

		// Wysyłanie danych za pomocą AJAX
		fetch(feedbackFormData.ajaxurl, {
			method: 'POST',
			body: formData,
		})
			.then(response => response.json())
			.then(data => {
				console.log(data) // Logowanie odpowiedzi z serwera, aby sprawdzić dane
				if (data.success) {
					alert(data.data.message) // Jeśli sukces, wyświetl wiadomość
					form.reset() // Resetowanie formularza po udanym wysłaniu
				} else {
					alert(data.data.message) // Jeśli błąd, wyświetl wiadomość o błędzie
				}
			})
			.catch(error => {
				console.error('Error:', error) // Logowanie błędów
			})
	})
})
