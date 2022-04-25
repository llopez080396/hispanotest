module.exports = {
	env: "prod",
	server: {
		local: {
			page_url: 'http://localhost:8081/',
			api: 'https://test.hispanocash.com',
			headers: {
				'content-type': 'application/json',
				'reference': 'hispano'
			},
			validate_reference: {
				token_api: 'vw1Uvg3guzdgY7MpNzOMjl072UKSheYTJwuxfWRwTZ6rWLQqkFPbAQrwX2EB'
			}
		},
		dev: {
			page_url: 'https://hispano.blueberry.team/',
			api: 'https://test.hispanocash.com',
			headers: {
				'content-type': 'application/json',
				'reference': 'hispano'
			},
			validate_reference: {
				token_api: 'vw1Uvg3guzdgY7MpNzOMjl072UKSheYTJwuxfWRwTZ6rWLQqkFPbAQrwX2EB'
			}
		},
		prod: {
			page_url: 'https://hispanocash.com',
			api: 'https://api.hispanocash.com',
			headers: {
				'content-type': 'application/json',
				'reference': 'hispano'
			},
			validate_reference: {
				token_api: 'vw1Uvg3guzdgY7MpNzOMjl072UKSheYTJwuxfWRwTZ6rWLQqkFPbAQrwX2EB'
			}
		}
	},
}