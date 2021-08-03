<h1 align="center">SVILUPPO DI UNA APPLICAZIONE PER LA GESTIONE DEI DATI DI UNA SCUOLA DI DANZA</h1>
L'utente si trova inizialmente in home.php dove puó scegliere fra varie opzioni.<br>
Selezionando "LOG IN" potrá loggarsi e qui ci sono due strade:<br><br>
<p style="color:blue;"> -Admin, che puó visualizzare "<b>haPagato.php</b>" dove puó cambiare l'attributo contenuto nel database riferito allo stato del pagamento di una persona, "<b>listaUtenti.php</b>" dove puó controllare la lista di utenti iscritti, "<b>listaInsegnanti.php</b>" per controllare gli insegnanti, "<b>inserimentoCorso.php</b>" per l'inserimento di un corso nel DataBase, "<b>registrazioneUtente.php</b>" per l'inserimento di un utente nel DataBase, "<b>evento.php</b>" per inserire un Evento privato (accessibile solo agli utenti registrati) oppure uno Shooting. Infine puó accedere alla pagina "<b>visualizzaCorsi.php</b>" dove potrá vedere che utente é iscritto a quale corso.</p>
<p style="color:red;">-Utente: puó accedere a "<b>visualizzaCorsi.php</b>" dove vedrá solo i corsi al quale é iscritto, "<b>evento.php</b>" dove potrá prenotare un evento privato oppure uno shooting, "<b>paginaLogin.php</b>" per loggarsi</p>

La pagina "<b>logout.php</b>" serve per distruggere la "$\_SESSION" e quindi avere attributi da ospite
<p style="color:pink;">-Ospite: puó solo prenotare uno shooting

 <h1 align="center"> TODO </h1>
-Fare un'altra tabella di frequenza con la mail delle persone+id corso+da quando inizia (data iscrizione) -> vede solo admin
-Tenere corso togliendo la mail tenendo il numero dell'insegnante (pubblico)
-Tabella dove tengo conto del mese e se ha pagato in quel mese oppure no
-Pagina per modifica del corso (modificare la data di inizio/fine, il maestro)
