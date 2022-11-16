Projekat se pokrece tako sto se pokrene komanda:
    symfony server:start

Parametri za konektovanje sa bazom se nalaze u .env fajlu.

Pokrenuti mysql server lokalno u xampp-u.

Pokrenuti komandu posle svakog pull-a:
    php bin/console doctrine:migrations:migrate

za pokretanje slanja mejlova preko mailer_dsn-a koji napises u env :
    php bin/console messenger:consume async