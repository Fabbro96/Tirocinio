## DA INSERIRE SU HTDOCS ##


# COSE DA FARE
-Gestione della pagina dell'admin/insegnante (aggiungere eventi, photo shooting, corsi)

-Admin iscrive utente ai corsi

-Inserimento dei dettagli riguardanti il corso (Etá consigliata, costo mensile, data di fine, volte a settimana)

-Bisogna sistemare la gestione degli alert nei vari php (registrazioneUtente, inserimentoCorso) perché quando aggiorno la pagina dopo aver inserito i dati esce subito l'alert.

-Come gestisco l'inserimento dei corsi?

-Visualizzare gli eventi ai quali sono iscritto


# COSE FATTE
-Pagina di Home (Home.php)

-Pagina di Login (PaginaLogin.php e poi login.php per verificare la correttezza dei dati inseriti durante la fase di login)

-Pagina di registrazione utente (paginaregistrazione.html poi regutente.php per inserire nel DB i dati)

-Pagina contenente la lista degli utenti registrati (list.php)

-Pagina per l'inserimento dei corsi (checkCorso.php, inserimentocorso.html)

-Pagina che visualizza i tutti i corsi disponibili con l'etá media degli utenti (visualizzacorsi.php)

-Pagina che gestisce la situazione di pagamento dei vari utenti (haPagato.php)

-Pagina per prenotare un evento/shooting (evento.php)

# --GESTITE A LIVELLO DI DATABASE--
-Pagina riservata all'insegnante
-Pagina riservata al corso
-Pagina per l'evento privato
-Pagina per lo shooting

# DOMANDE
-Come gestisco la questione dei corsi? Con un'altra tabella? Oppure va bene se elimino la PrimaryKey "Nome" dalla tabella corso in modo creare piú righe con lo stesso corso ma mail diverse? (Foreign Key)
