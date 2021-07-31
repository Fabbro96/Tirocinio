L'utente si trova inizialmente in home.php dove puó scegliere fra varie opzioni.
Selezionando "LOG IN" potrá loggarsi e qui ci sono due strade:
-Admin, che puó visualizzare haPagato.php dove puó cambiare l'attributo contenuto nel database riferito allo stato del pagamento di una persona, listaUtenti.php dove puó controllare la lista di utenti iscritti, listaInsegnanti.php per controllare gli insegnanti, inserimentoCorso.php per l'inserimento di un corso nel DataBase, registrazioneUtente.php per l'inserimento di un utente nel DataBase, evento.php per inserire un Evento privato (accessibile solo agli utenti registrati) oppure uno Shooting. Infine puó accedere alla pagina "visualizzaCorsi.php" dove potrá vedere che utente é iscritto a quale corso.
-Utente: puó accedere a "visualizzaCorsi.php" dove vedrá solo i corsi al quale é iscritto, "evento.php" dove potrá prenotare un evento privato oppure uno shooting, "paginaLogin.php" per loggarsi

La pagina "logout.php" serve per distruggere la "$\_SESSION" e quindi avere attributi da ospite
-Ospite: puó solo prenotare uno shooting

#GESTITE A LIVELLO DI DATABASE
-Pagina riservata all'insegnante
-Pagina riservata al corso
-Pagina per l'evento privato
-Pagina per lo shooting

#COSE FATTE
-Pagina di Home (Home.php)
-Pagina di Login (PaginaLogin.php e poi login.php per verificare la correttezza dei dati inseriti durante la fase di login)
-Pagina di registrazione utente (paginaregistrazione.html poi regutente.php per inserire nel DB i dati)
-Pagina contenente la lista degli utenti registrati (list.php)
-Pagina per l'inserimento dei corsi (checkCorso.php, inserimentocorso.html)
-Pagina che visualizza i tutti i corsi disponibili con l'etá media degli utenti (visualizzacorsi.php)
-Pagina che gestisce la situazione di pagamento dei vari utenti (haPagato.php)
-Pagina per prenotare un evento/shooting (evento.php)



#DOMANDE
-Come gestisco la questione dei corsi? Con un'altra tabella? Oppure va bene se elimino la PrimaryKey "Nome" dalla tabella corso in modo creare piú righe con lo stesso corso ma mail diverse? (Foreign Key)
