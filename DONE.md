### W projekcie zostały wykonane wszystkie wymagane zadanie:
1. CRUD...,
2. Przeglądanie zadań
3. Powiadomienia e-mail
4. Walidacja
5. Obsługa wielu użytkowników
6. Udostępnianie zadań bez autoryzacji za pomocą linka z tokenem dostępowym:

### Oraz z zadań opcjonalnych został zaimplementowany logger

7. Pełna historia edycji notatek:
- Zapisuj każdą zmianę zadań (nazwy, opisy, priorytety, statusy, daty itp.) wraz z możliwością przeglądania poprzednich wersji.

Generalnie chciałem wykonać wszystkie zadania poprawnie bez błędów oraz dodatkowe ale ze względu na czas i napięty terminarz 
w tym tyg wykonałem jedno jeżelu uda mi się do końca tyg to zaimplementuję kolejne to samo z dockerem.

Wstępny plan na dockera jest aby wdrożyć 3 kontenery:

1. PHP/APP z kodem aplikacji oraz workerami
2. MYSQL bazka 
3. NGINX/APACHE z przekierowaniem (reverse proxy) na kontener APP

Całość w jednej sieci.
Przygotować Dockerfile z "FROM php:8.3-cli" image i w nim uruchomić workery.

Mailera używam na potrzeby tej aplikacji "MAIL_MAILER=log" można podejrzeć w storage->logs->laravel.log


