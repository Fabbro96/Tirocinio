<h1 align="center">Tirocinio</h1>
L'utente si trova inizialmente in home.php dove puó scegliere fra varie opzioni.<br>
Selezionando "LOG IN" potrá loggarsi e qui ci sono due strade:<br>
<h4><p style="color:blue;"> Admin, che puó visualizzare <b>haPagato.php</b> dove puó cambiare l'attributo contenuto nel database riferito allo stato del pagamento di una persona, listaUtenti.php dove puó controllare la lista di utenti iscritti, listaInsegnanti.php per controllare gli insegnanti, inserimentoCorso.php per l'inserimento di un corso nel DataBase, registrazioneUtente.php per l'inserimento di un utente nel DataBase, evento.php per inserire un Evento privato (accessibile solo agli utenti registrati) oppure uno Shooting. Infine puó accedere alla pagina "visualizzaCorsi.php" dove potrá vedere che utente é iscritto a quale corso.</p></h4>
<h4><p style="color:red;">-Utente: puó accedere a "visualizzaCorsi.php" dove vedrá solo i corsi al quale é iscritto, "evento.php" dove potrá prenotare un evento privato oppure uno shooting, "paginaLogin.php" per loggarsi</p></h4>

La pagina "logout.php" serve per distruggere la "$\_SESSION" e quindi avere attributi da ospite
<h4><p style="color:pink;">-Ospite: puó solo prenotare uno shooting</h4>
