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

Przygotowałem dockera z 3 kontenerami:

1. PHP/APP z kodem aplikacji oraz workerami
2. MYSQL bazka 
3. NGINX/z przekierowaniem (reverse proxy) na kontener APP

Całość w jednej sieci.
Mailera używam na potrzeby tej aplikacji "MAIL_MAILER=log" można podejrzeć w storage->logs->laravel.log

Po wrzuceniu na repozytorium projektu zrzuciłem je sobie do odzielnego katalogu i przeszedłem cały proces uruchomieniowy z
README wszystko powinno działać.

Projekt przygtowałem bez dockera, docker skonfigurowałem pod projekt na końcu, testowałem na ubuntu powinno działać :)
