backend:
	php artisan serve &

frontend:
	npm run dev &

start: backend frontend
	wait
migrate:
	php artisan migrate