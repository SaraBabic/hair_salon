Projekat se pokrece tako sto se pokrene komanda:
    symfony server:start

Parametri za konektovanje sa bazom se nalaze u .env fajlu.

Pokrenuti mysql server lokalno u xampp-u.

Pokrenuti komandu posle svakog pull-a:
    php bin/console doctrine:migrations:migrate

za pokretanje slanja mejlova preko mailer_dsn-a koji napises u env :
    php bin/console messenger:consume async

za instalaciju webpack-a:
    yarn install (ili npm ako to imas)

da bi modifikovanje js i css bilo vidljivo na sajtu(da se naprave ti fajlovi u public/build/) 
(ovo ostaje ukljuceno i pise fajlove ponovo na svaki save):
    yarn watch

da bi se ti fajlovi mogli ukljuciti u twigu:
    u webpack.config.js dodati novi entry:
        .addEntry('naziv na koji cemo se pozivati u twigu', 'putanja do tog fajla')
